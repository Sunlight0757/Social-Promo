<?php

require 'config.php';
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function spinText($text) {
  $pattern = '/\{([^{}]*)\}/i';
  return preg_replace_callback($pattern, function($matches) {
    $options = explode('|', $matches[1]);
    $randomIndex = array_rand($options);
    return trim($options[$randomIndex]);
  }, $text);
}

function sendEmailToUser($user, $template,$campaign)
{
  $Appointment = "";
  $bookingData = file_get_contents(bookingdatafile);
  $bookings = json_decode($bookingData, true);
  if($bookings!=null){
      foreach ($bookings as $booking){
          if ($booking['id'] == $user['id']) {
              $Appointment = $booking['dateofbooking'];
              $dateTime = DateTime::createFromFormat('d-m-Y/H:i', $Appointment);
              $Appointment = $booking['booking']." - ".$dateTime->format('D, M j, Y H:i');
              break;
          }
      }
  }

  $replace = array("{NAME}", "{WEBSITE}", "{PHONE}", "{EMAIL}", "{LOCATION}", "{BOOKING}", "{UNSUBSCRIBE}");
  $replaceby = array($user['fullName'], $user['website'], $user['number'], $user['email'], $user['location'], $Appointment, '<a id="uns" href="'.domain.'unsubscribe.php?index='.$user['id'].'">Unsubscribe</a>' );
  $content = str_ireplace($replace, $replaceby, $template['content']);
  $content = spinText($content);
  $mail = new PHPMailer(true);
  try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = host;
    $mail->SMTPAuth   = SMTPAuth;
    $mail->Username   = username;
    $mail->Password   = password;
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPSecure = SMTPSecure;
    $mail->Port = port;
    $mail->isHTML(true);
    $mail->Encoding = "base64";
    $mail->CharSet = "UTF-8";
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );

    //Recipients
    $mail->setFrom(address, name);

    $mail->addAddress($user['email'],  $user['fullName']);

    //Content
    $mail->isHTML(true);
    $mail->Subject = $template['title'];
    $body="";
    if(isset($template['image']) || $template['image'] != 'default.png'){
    $body.='<p><img width="100%" src="'.$template['image'].'" /></p>';
    }
    $body.=$content;
    $mail->Body = $body;

    $task="<h5 class='note'>Sending email to user " . $user['fullName'] . " with template: " . $template['id'] . " - ";
    if ($mail->send()) {
      $task .= '<span class="result-success">success</span></h5>';
      //update campaign state
      $date = date('l d - M- Y  H:i');
      
      $campaignData = file_get_contents('db/campaign.json');
      $campaignData = json_decode($campaignData, true);
      $position=0;
      foreach ($campaignData as $index => $item) {
        if ($item['id'] == $campaign['id']) {
          $position = $index;
          break; 
        }
      }

      //  $campaign['status'] .=$state; 
      $p = 0;
      $exist = 0;
      if(count($campaign['status'])>0)
      {
        foreach($campaign['status'] as $st){
          if($st['id'] == $user['id']){
            $st['date'] = $date;
            $st['state'] = 'Success';
            $campaign['status'][$p] = $st;
            $exist++;
          }
          $p++;
        }
      }
      if($exist == 0 or count($campaign['status'])==0){
        $new = array(
          'id'=>$user['id'],
          'state'=>'Success',
          'date' => $date
        );
        array_push($campaign['status'],$new);
      }

      $campaignData[$position] = $campaign;
      file_put_contents('db/campaign.json', json_encode($campaignData));
    } else {
      $task .= '<span class="result-failed">failed</span></h5>';
    }
    return $task;
  } catch (Exception $e) {
    var_dump($mail->ErrorInfo);
    $date = date('l d - M- Y  H:i');
    $campaignData = file_get_contents('db/campaign.json');
    $campaignData = json_decode($campaignData, true);
    $position = 0;
    foreach ($campaignData as $index => $item) {
      if ($item['id'] == $campaign['id']) {
        $position = $index;
        break; 
      }
    }
    
    $p =0;
    $exist = 0;

    if(count($campaign['status'])>0)
    {
      foreach($campaign['status'] as $st){
        if($st['id'] == $user['id']){
          $st['date'] = $date;
          $st['state'] = 'Failed';
          $campaign['status'][$p] = $st; 
          $exist++;
        }
        $p++;
      }
    }
    if($exist ==0 or count($campaign['status'])==0 ){
      $new = array(
        'id'=>$user['id'],
        'state'=>'Failed',
        'date' => $date
      );
      array_push($campaign['status'],$new);
    }
    $campaignData[$position] = $campaign;
    file_put_contents('db/campaign.json', json_encode($campaignData));
  }
}

function main($users, $flag) {
  $templateData = file_get_contents(adminTemplatesFile);
  $templateData = json_decode($templateData, true);
  $campaignData = file_get_contents('db/campaign.json');
  $campaignData = json_decode($campaignData, true);

  $country = 'Europe/London';
  $timezone = new DateTimeZone($country);
  $campaigns = [];

  foreach ($campaignData as $key => $campaign) {
    $currentDayOfWeek = date('l');
    $currentTime = new DateTime();
    $currentTime->setTimezone($timezone);
    $currentTime->format('H:i');
    if($flag) {
      if (in_array($currentDayOfWeek, $campaign['days'])) {
        if ($currentTime->format('H:i') == $campaign['time']) {
          array_push($campaigns,$campaign);
        }
      }
    } else {
      array_push($campaigns,$campaign);
    }
  }

  $result = [];

  foreach ($campaigns as $key => $campaign) {
    $groups =  $campaign['group'];
    $template_by_group = [];
    foreach ($templateData as $template) {
      if (in_array($template['group'], $groups)) {
        array_push($template_by_group, $template);
      }
    }

    for ($i = 0; $i < count($template_by_group); $i++) {
      $currentDayOfWeek = date('l');
      if ($campaign['type'] == 'Email') {
        if($campaign['days'] != 'Birthdays' && $campaign['days'] != 'Bookings' && !isset($campaign['holiday']) && !isset($campaign['forecast'])){
          if (in_array($currentDayOfWeek, $campaign['days'])) {
            if (!$template_by_group[$i]['sendemail']) {
              $currentTime = new DateTime();
              $currentTime->setTimezone($timezone);
              $currentTime->format('H:i');
              foreach ($users as $user) {
                if(in_array($template_by_group[$i]['group'],$user['groups'])){
                  array_push($result, sendEmailToUser($user, $template_by_group[$i],$campaign));
                }
              }
              //update sendEmail attribut to true
              $templateData;
              $position = (array_search($template_by_group[$i], $templateData));
              $template_by_group[$i]['sendemail'] = true;
              $templateData[$position] = $template_by_group[$i];

              if ($i == count($template_by_group) - 1) {
                foreach ($template_by_group as $key => $temp) {
                  # code...
                  $position = (array_search($temp, $templateData));
                  $temp['sendemail'] = false;
                  $templateData[$position] = $temp;
                }
              }

              file_put_contents(adminTemplatesFile, json_encode($templateData));
            } else {
              if (count($template_by_group) == 1) {
                foreach ($template_by_group as $key => $temp) {
                  # code...
                  $position = (array_search($temp, $templateData));
                  $temp['sendemail'] = false;
                  $templateData[$position] = $temp;
                  file_put_contents(adminTemplatesFile, json_encode($templateData));
                }
              }
            }
          }
        }
      }
    }
  }

  echo json_encode($result);
}

if(isset($_POST['users'])) {
  $data = json_decode($_POST['users'], true);
  $flag = isset($_POST['flag']) ? $_POST['flag'] : false;
  main($data, $flag);
} 

?>