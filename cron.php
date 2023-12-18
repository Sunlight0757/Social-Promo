<?php

require 'config.php';
require  "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$templateData = file_get_contents(adminTemplatesFile);
$templateData = json_decode($templateData, true);
$campaignData = file_get_contents('db/campaign.json');
$campaignData = json_decode($campaignData, true);
$userData = file_get_contents(datafile);
$users = json_decode($userData, true);
function spinText($text) {
    $pattern = '/\{([^{}]*)\}/i';
    return preg_replace_callback($pattern, function($matches) {
        $options = explode('|', $matches[1]);
        $randomIndex = array_rand($options);
        return trim($options[$randomIndex]);
    }, $text);
  }

// Fonction to send an e-mail to user
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

     $task="Sending email to user " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;

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
        $body.='<p><img src="'.$template['image'].'" /></p><br>';
        }
        $body.=$content;
        $mail->Body = $body;
        //var_dump($mail->Body);

        if ($mail->send()) {

            echo '/n/success'.$mail->ErrorInfo;
            

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
            $p =0;
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
            }}
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
            echo 'error '.$mail->ErrorInfo;
            
        }
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
        {foreach($campaign['status'] as $st){
            // var_dump($st); var_dump($st['id']);
            if($st['id'] == $user['id']){
                $st['date'] = $date;
                $st['state'] = 'Failed';
                $campaign['status'][$p] = $st; 
                $exist++;
            }
            $p++;
        }}
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

function sendEmailToAdmin($user, $template,$campaign)
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

     $task="Sending email to Admin of user : " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;

    $name = $user['fullName'];

    $message = "Hi Admin, ".adminbookingreminder.$name.", Booking Details - ".$Appointment;

    foreach (email_address as $adminEmail){
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

            $mail->addAddress($adminEmail,  'Admin');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Booking Reminder of User';
            $body="";
            $body.=$message;
            $mail->Body = $body;
            //var_dump($mail->Body);

            if ($mail->send()) {

                echo '/n/success'.$mail->ErrorInfo;


            } else {
                echo 'error '.$mail->ErrorInfo;

            }
        } catch (Exception $e) {
            var_dump($mail->ErrorInfo);
        }
    }
}


function sendSMSToUser($user, $template,$campaign){

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

    $task="Sending sms to user " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;
    $replace = array("{NAME}", "{WEBSITE}", "{PHONE}", "{EMAIL}", "{LOCATION}", "{BOOKING}", "{UNSUBSCRIBE}");
    $replaceby = array($user['fullName'], $user['website'], $user['number'], $user['email'], $user['location'], $Appointment, '<a id="uns" href="'.domain.'unsubscribe.php?index='.$user['id'].'">Unsubscribe</a>');
    $content = str_ireplace($replace, $replaceby, $template['content']);

    $content=strip_tags($content);
    $content = spinText($content);

// Twilio Account Credentials
$accountSid = twilo_ssid;
$authToken = twilo_token;

// Twilio Phone Number
$twilioPhoneNumber = twilo_phoneNumber;

// Recipient Phone Number
$toNumber = $user['number'];

// Message Body
$messageBody =  $content;

// Twilio API URL for sending messages
$url = 'https://api.twilio.com/2010-04-01/Accounts/' . $accountSid . '/Messages.json';

// Request parameters
$data = array(
    'To' => $toNumber,
    'From' => $twilioPhoneNumber,
    'Body' => $messageBody
);

// cURL configuration
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_USERPWD, $accountSid . ':' . $authToken);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    $state = date('l d - M- Y  H:i').'<br>'.$task.'<br><br>Fail<br><br>'; 
    $campaignData = file_get_contents('db/campaign.json');
    $campaignData = json_decode($campaignData, true);
    $position = 0;
    foreach ($campaignData as $index => $item) {
        if ($item['id'] == $campaign['id']) {
            $position = $index;
            break; 
        }
    }
    $campaign['status']=[];
    $campaignData[$position] = $campaign;
file_put_contents('db/campaign.json', json_encode($campaignData));
} else {
    // Message sent successfully
    echo 'Message sent! Response: ' . $response;
    $state = date('l d - M- Y  H:i').'<br>'.$task.'<br><br>Success<br><br>'; 
    $campaignData = file_get_contents('db/campaign.json');
    $campaignData = json_decode($campaignData, true);
    $position = 0;
    foreach ($campaignData as $index => $item) {
        if ($item['id'] == $campaign['id']) {
            $position = $index;
            break; 
        }
    }
    $campaign['status'] =[];
    $campaignData[$position] = $campaign;
file_put_contents('db/campaign.json', json_encode($campaignData));
}

// Close the cURL session
curl_close($ch);


}

function sendSMSToAdmin($user, $template,$campaign){

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

    $task="Sending sms to user " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;

    $content = "Hi Admin, ".adminbookingreminder.$user['fullName'].", Booking Details - ".$Appointment;

    foreach (sms_phoneNumber as $adminNumber){
// Twilio Account Credentials
        $accountSid = twilo_ssid;
        $authToken = twilo_token;

// Twilio Phone Number
        $twilioPhoneNumber = twilo_phoneNumber;

// Recipient Phone Number
        $toNumber = $adminNumber;

// Message Body
        $messageBody =  $content;

// Twilio API URL for sending messages
        $url = 'https://api.twilio.com/2010-04-01/Accounts/' . $accountSid . '/Messages.json';

// Request parameters
        $data = array(
            'To' => $toNumber,
            'From' => $twilioPhoneNumber,
            'Body' => $messageBody
        );

// cURL configuration
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_USERPWD, $accountSid . ':' . $authToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL request
        $response = curl_exec($ch);

// Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Message sent successfully
            echo 'Message sent! Response: ' . $response;
        }
// Close the cURL session
        curl_close($ch);
    }
}




function sendWhatsappToUser($user, $template,$campaign){
    $task="Sending whatsapp to user " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;
    $replace = array("{NAME}", "{WEBSITE}", "{PHONE}", "{EMAIL}", "{LOCATION}", "{UNSUBSCRIBE}");
    $replaceby = array($user['fullName'], $user['website'], $user['number'], $user['email'], $user['location'], '<a id="uns" href="'.domain.'unsubscribe.php?index='.$user['id'].'">Unsubscribe</a>');
    $content = str_ireplace($replace, $replaceby, $template['content']);

    $content=strip_tags($content);
    $content = spinText($content);
// Twilio Account Credentials
$accountSid = twilo_ssid;
$authToken = twilo_token;

// Twilio Phone Number
$twilioPhoneNumber = twilo_phoneNumber;

// Recipient Phone Number
$toNumber = $user['number'];

// Message Body
$messageBody =  $content;

// Twilio API URL for sending messages
$url = 'https://api.twilio.com/2010-04-01/Accounts/' . $accountSid . '/Messages.json';

// Request parameters
$data = array(
    'To' => $toNumber,
    'From' => 'whatsapp:'.twilo_whatsapp_sender,
    'Body' => $messageBody
);

// cURL configuration
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_USERPWD, $accountSid . ':' . $authToken);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    $state = date('l d - M- Y  H:i').'<br>'.$task.'<br><br>Fail<br><br>'; 
    $campaignData = file_get_contents('db/campaign.json');
    $campaignData = json_decode($campaignData, true);
    $position = 0;
    foreach ($campaignData as $index => $item) {
        if ($item['id'] == $campaign['id']) {
            $position = $index;
            break; 
        }
    }
    $campaign['status'] =[];
    $campaignData[$position] = $campaign;
file_put_contents('db/campaign.json', json_encode($campaignData));
} else {
    // Message sent successfully
    echo 'Message sent! Response: ' . $response;
    $state = date('l d - M- Y  H:i').'<br>'.$task.'<br><br>Success<br><br>'; 
    $campaignData = file_get_contents('db/campaign.json');
    $campaignData = json_decode($campaignData, true);
    $position = 0;
    foreach ($campaignData as $index => $item) {
        if ($item['id'] == $campaign['id']) {
            $position = $index;
            break; 
        }
    }
    $campaign['status'] =[];
    $campaignData[$position] = $campaign;
file_put_contents('db/campaign.json', json_encode($campaignData));
}

// Close the cURL session
curl_close($ch);


}
function filecaller($file, $postData) {
    $url = domain . $file;
  
    // Initialize cURL session
    $ch = curl_init();
  
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
  
    // Execute cURL request and get response
    $response = curl_exec($ch);
  
    // Check for cURL errors
    if (curl_errno($ch)) {
      echo 'cURL Error: ' . curl_error($ch);
    }
  
    // Close cURL session
    curl_close($ch);
  
    // Display the response if needed
    echo $response;
  }

function getPushContent($user, $template,$campaign)
{
    $task="Sending push to user " . $user['fullName'] . " with template: " . $template['id'] . "\n";
    echo $task;   

    $replace = array("{NAME}", "{WEBSITE}", "{PHONE}", "{EMAIL}", "{LOCATION}", "{UNSUBSCRIBE}");
    $replaceby = array($user['fullName'], $user['website'], $user['number'], $user['email'], $user['location'], $user['unsubscribe']);
    $content = str_ireplace($replace, $replaceby, $template['content']);
    $content=strip_tags($content);
    $content = spinText($content);
     $template['content'] = $content;
     $template['device'] = $user['device'];
     return $template;
    
}


function sendPushToUsers($pushData){
   

     $file = 'push.php'; // Replace with your file name
    $postData = array(
    'json' => json_encode($pushData)
    );

    filecaller($file, $postData);
}


function getlocationinfo($city = 'london'){


    $apiKey = locationapi;
    $curl = curl_init();
    $url = "https://api.api-ninjas.com/v1/geocoding?city=$city&limit=1";
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "X-Api-Key: $apiKey"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        return "Erreur cURL : $err";
    } else {
        $result= json_decode($response,true);
       // var_dump($result[0]);
        return  [$result[0]["latitude"],$result[0]["longitude"]];
    }
    
    }


function getWeather($lat,$lon){

    $apiKey = weatherapi;
    $curl = curl_init();
    $url = "https://api.openweathermap.org/data/2.5/forecast?appid=$apiKey&lat=$lat&lon=$lon&cnt=16";
    
    $ch = curl_init();
  
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch,  CURLOPT_CUSTOMREQUEST, "GET");
    // Execute cURL request and get response
    $response = curl_exec($ch);
  
    // Check for cURL errors
    if (curl_errno($ch)) {
      echo 'cURL Error: ' . curl_error($ch);
    }
  //var_dump($ch);
    // Close cURL session
    curl_close($ch);
  
    // Display the response if needed
    //echo $response;

    $weather=[];
    $result = json_decode($response,true);

    foreach ($result['list'] as $key => $dt) {
        # code...

        echo '<br>';
        if($key==0){
        array_push($weather,$dt['weather'][0]['main']);
        }

        $dateActuelle = new DateTime();

         $dateComparee = new DateTime($dt['dt_txt']);
        //  var_dump($dateComparee);
        $dateonly = $dateComparee->format('Y-m-d');
        $hoursonly = $dateComparee->format('H:i');

        $dateActuelle->add(new DateInterval('P1D'));

        $heureMinimum = '07:00';
        $yesterday = $dateActuelle->format('Y-m-d');
        

        if ($dateonly == $yesterday && $hoursonly >= $heureMinimum) {
            //
            array_push($weather,$dt['weather'][0]['main']);
            break;
            
        } 

    }
    //var_dump($result['weather'][0]['main']);
    return $weather;
    
    }



    function compareStrings($str1, $str2) {
        // Convert both strings to lowercase for a case-insensitive comparison
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);
    
        // Find the length of the shorter of the two strings
        $length = min(strlen($str1), strlen($str2));
    
        // Initialize a counter for common characters
        $commonChars = 0;
    
        // Iterate through the characters of both strings and count matches
        for ($i = 0; $i < $length; $i++) {
            if ($str1[$i] == $str2[$i]) {
                $commonChars++;
            }
        }
    
        // Calculate the percentage of match
        $percentage = ($commonChars / $length) * 100;
    
        // Check if the match percentage is greater than or equal to 80%
        if ($percentage >= 80) {
            return true;
        } else {
            return false;
        }
    }
      




$country = 'Europe/London';
$timezone = new DateTimeZone($country);
$campaigns = [];
foreach ($campaignData as $key => $campaign) {
    $currentDayOfWeek = date('l');
    $currentTime = new DateTime();
    $currentTime->setTimezone($timezone);
    $currentTime->format('H:i');
     if($campaign['days'] != 'Bookings' && $campaign['days'] != 'Birthdays' && is_array($campaign['days']) &&!isset($campaign['holiday']) && !isset($campaign['forecast'])){
         echo $currentDayOfWeek." -  Current Day<br>";
         var_dump($campaign);
         echo "<br>";
        if (in_array($currentDayOfWeek, $campaign['days'])) {
            echo $currentTime->format('H:i')." Current Time<br>";
            if ($currentTime->format('H:i') == $campaign['time']) {
                array_push($campaigns,$campaign);
    }
    }
   
    } if($campaign['days'] == 'Birthdays') {
        # code...
         if ($currentTime->format('H:i') == $campaign['time']) {
             array_push($campaigns,$campaign);
            }
    }
   if(isset($campaign['holiday'])) {
        # code...

            $moment= $campaign['moment'];$datefin='';
            $day = $campaign['days'];
            $date =  DateTime::createFromFormat('d-m-Y', reset($day));
            //$date = new DateTime(reset($day));
        if ($moment == "week_before") {
       
            $date->modify('-7 day');
            //echo $date->format('d-m-Y'). '  '.reset($day) ;
        } elseif ($moment == "same_day") {
            
            // echo $date->format('d-m-Y'). '  '.reset($day) ;
        } elseif ($moment == "day_before") {
         
            $date->modify('-1 day');
            // echo $date->format('d-m-Y'). '  '.reset($day) ;
        }

        $dateActuelle = new DateTime();

        if ($dateActuelle->format('d-m-Y') == $date->format('d-m-Y')) {
            // echo "it is today";
           echo $currentTime->format('H:i').'  vs'.$campaign['time'];
            if ($currentTime->format('H:i') == $campaign['time']) {
                echo 'hello';
                array_push($campaigns,$campaign);
               }
        } else {
           // echo "La date obtenue n'est pas aujourd'hui.";
        }
      
    }  

   if($campaign['days'] == 'Bookings') {
       array_push($campaigns,$campaign);
    }

    if(isset($campaign['forecast'])) {
        # code...
         if ($currentTime->format('H:i') == $campaign['time']) {
             array_push($campaigns,$campaign);
            }
    }
}
var_dump($campaigns);
$bookingData = file_get_contents(bookingdatafile);
$bookings = json_decode($bookingData, true);
foreach ($campaigns as $key => $campaign) {
    # code...
    $group =  $campaign['group'];
    $template_by_group = [];
    foreach ($templateData as $template) {
        # code..
// var_dump($campaign);
        if ($group == $template['group']) {
            array_push($template_by_group, $template);
        }
    }

    for ($i = 0; $i < count($template_by_group); $i++) {

        $currentDayOfWeek = date('l');

        if ($campaign['type'] == 'Email') {

            //var_dump($campaign['days'] != 'Birthdays' && !isset($campaign['holiday']));
            if($campaign['days'] != 'Birthdays' && $campaign['days'] != 'Bookings' && !isset($campaign['holiday']) && !isset($campaign['forecast'])){
                
                var_dump($campaign);
            if (in_array($currentDayOfWeek, $campaign['days'])) {
                if (!$template_by_group[$i]['sendemail']) {
                    $currentTime = new DateTime();
                    $currentTime->setTimezone($timezone);
                    $currentTime->format('H:i');
                        foreach ($users as $user) {
                            if(in_array($template_by_group[$i]['group'],$user['groups'])){
                                sendEmailToUser($user, $template_by_group[$i],$campaign);
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
               
                    break;
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
         
          elseif($campaign['days'] == 'Birthdays'){
            
            if (!$template_by_group[$i]['sendemail']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            
                        $today = date('d-m');

                        $birthday = $user['birthday'];

                        if (date('d-m', strtotime($birthday)) === $today) {
                            var_dump('birthday');
                            sendEmailToUser($user, $template_by_group[$i],$campaign);
                        }
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
               
                break;
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

          elseif($campaign['days'] == 'Bookings'){

            if (!$template_by_group[$i]['sendemail']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            //echo "You are Here<br>";
                            if($bookings!=null){
                                foreach ($bookings as $booking){
                                    if ($booking['id'] == $user['id']) {
                                        $Appointment = $booking['dateofbooking'];
                                        echo $Appointment."<br>";
                                        $dateTime = DateTime::createFromFormat('d-m-Y/H:i', $Appointment);
                                        $dateTime->sub(new DateInterval('PT'.$campaign['time'].'M'));
                                        $cronTime = $dateTime->format('Y-m-d H:i');
                                        $currentDateTime = new DateTime();
                                        $currentDateTime = $currentDateTime->format('Y-m-d H:i');
                                            echo "User: ".$user['fullName']." - Booking Time: ".$Appointment." - Cron Time: ".$cronTime." - Current Time: ".$currentDateTime."<br>";
                                        if($cronTime==$currentDateTime){
                                            sendEmailToUser($user, $template_by_group[$i],$campaign);
                                            if(send_email_alert){
                                                sendEmailToAdmin($user, $template_by_group[$i],$campaign);
                                            }
                                            echo " >> Email Send";
                                        }
                                    }
                                }
                            }
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

                break;
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

          //holiday
          elseif(isset($campaign['holiday'])){
            if (!$template_by_group[$i]['sendemail']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            
                       
                            sendEmailToUser($user, $template_by_group[$i],$campaign); 
                        
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
               
                break;
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

     //weather
     elseif (isset($campaign['forecast'])) {
      
        if (!$template_by_group[$i]['sendemail']) {
            $currentTime = new DateTime();
            $currentTime->setTimezone($timezone);
            $currentTime->format('H:i');
                foreach ($users as $user) {
                    $city = explode('/',$user['location'])[0];
                    if(in_array($template_by_group[$i]['group'],$user['groups'])){

                        $location_info = getlocationinfo($city);
                        $longitude = $location_info[1];
                        $latitude= $location_info[0];
                        echo $longitude .' '. $latitude.'<br>';
                        $weathers = getWeather($latitude,$longitude);
                      $currentweather = '';
                        if($campaign['days']=='before')
                        {
                            $currentweather=$weathers[1];
                        }
                         if($campaign['days']=='same')
                        {
                             $currentweather=$weathers[0];
                        }
                        if (compareStrings($campaign['forecast'],  $currentweather)) {
                            
                        sendEmailToUser($user, $template_by_group[$i],$campaign); 

                        }
                    
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
           
            break;
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

        //sms
        if ($campaign['type'] == 'SMS') {


            //Bookings
            if($campaign['days'] == 'Bookings'){

                if (!$template_by_group[$i]['sendsms']) {
                    $currentTime = new DateTime();
                    $currentTime->setTimezone($timezone);
                    $currentTime->format('H:i');
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            if($bookings!=null){
                                foreach ($bookings as $booking){
                                    if ($booking['id'] == $user['id']) {
                                        $Appointment = $booking['dateofbooking'];
                                        echo $Appointment."<br>";
                                        $dateTime = DateTime::createFromFormat('d-m-Y/H:i', $Appointment);
                                        $dateTime->sub(new DateInterval('PT'.$campaign['time'].'M'));
                                        $cronTime = $dateTime->format('Y-m-d H:i');
                                        $currentDateTime = new DateTime();
                                        $currentDateTime = $currentDateTime->format('Y-m-d H:i');
                                        echo "User: ".$user['fullName']." - Booking Time: ".$Appointment." - Cron Time: ".$cronTime." - Current Time: ".$currentDateTime."<br>";
                                        if($cronTime==$currentDateTime){
                                            sendSMSToUser($user, $template_by_group[$i],$campaign);
                                            if(send_sms_alert){
                                                sendSMSToAdmin($user, $template_by_group[$i],$campaign);
                                            }
                                            echo " >> SMS Send";
                                        }
                                    }
                                }
                            }
                        }

                        //update sendEmail attribut to true
                        $templateData;
                        $position = (array_search($template_by_group[$i], $templateData));
                        $template_by_group[$i]['sendsms'] = true;
                        $templateData[$position] = $template_by_group[$i];

                        if ($i == count($template_by_group) - 1) {
                            foreach ($template_by_group as $key => $temp) {
                                # code...
                                $position = (array_search($temp, $templateData));
                                $temp['sendsms'] = false;
                                $templateData[$position] = $temp;
                            }
                        }

                        file_put_contents(adminTemplatesFile, json_encode($templateData));
                    }
                    break;
                } else {

                    if (count($template_by_group) == 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendsms'] = false;
                            $templateData[$position] = $temp;
                            file_put_contents(adminTemplatesFile, json_encode($templateData));
                        }
                    }
                }

            }


            if($campaign['days'] != 'Birthdays' && $campaign['days'] != 'Bookings' &&!isset($campaign['holiday'])){
            if (in_array($currentDayOfWeek, $campaign['days'])) {
                if (!$template_by_group[$i]['sendsms']) {
                    $currentTime = new DateTime();
                    $currentTime->setTimezone($timezone);
                    $currentTime->format('H:i');
                        foreach ($users as $user) {
                            if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            sendSMSToUser($user, $template_by_group[$i],$campaign);
                            sendWhatsappToUser($user, $template_by_group[$i],$campaign);
                        }
                        }
                        //update sendEmail attribut to true
                        $templateData;
                        $position = (array_search($template_by_group[$i], $templateData));
                        $template_by_group[$i]['sendsms'] = true;
                        $templateData[$position] = $template_by_group[$i];

                        if ($i == count($template_by_group) - 1) {
                            foreach ($template_by_group as $key => $temp) {
                                # code...
                                $position = (array_search($temp, $templateData));
                                $temp['sendsms'] = false;
                                $templateData[$position] = $temp;
                            }
                        }

                        //var_dump($templateData);
                        file_put_contents(adminTemplatesFile, json_encode($templateData));
            
                    break;
                }else {

                    if (count($template_by_group) == 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendsms'] = false;
                            $templateData[$position] = $temp;
                            file_put_contents(adminTemplatesFile, json_encode($templateData));
                        }
                    }
                }
           }
         }

         else{
            if (!$template_by_group[$i]['sendsms']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                if ($currentTime->format('H:i') == $campaign['time']) {
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                            
                        $today = date('d-m');

                        $birthday = $user['birthday'];

                        if (date('d-m', strtotime($birthday)) === $today) {
                            sendSMSToUser($user, $template_by_group[$i],$campaign); 
                        }
                                }
                    }
                   //update sendEmail attribut to true
                    $templateData;
                    $position = (array_search($template_by_group[$i], $templateData));
                    $template_by_group[$i]['sendsms'] = true;
                    $templateData[$position] = $template_by_group[$i];

                    if ($i == count($template_by_group) - 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendsms'] = false;
                            $templateData[$position] = $temp;
                        }
                    }

                    file_put_contents(adminTemplatesFile, json_encode($templateData));
                }
                break;
            } else {

                if (count($template_by_group) == 1) {
                    foreach ($template_by_group as $key => $temp) {
                        # code...
                        $position = (array_search($temp, $templateData));
                        $temp['sendsms'] = false;
                        $templateData[$position] = $temp;
                        file_put_contents(adminTemplatesFile, json_encode($templateData));
                    }
                }
            }


          }


           //holiday
           if(isset($campaign['holiday'])){
                
            if (!$template_by_group[$i]['sendsms']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                    foreach ($users as $user) {
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
                        
                            sendSMSToUser($user, $template_by_group[$i],$campaign); 
                                }
                    
                   //update sendEmail attribut to true
                    $templateData;
                    $position = (array_search($template_by_group[$i], $templateData));
                    $template_by_group[$i]['sendsms'] = true;
                    $templateData[$position] = $template_by_group[$i];

                    if ($i == count($template_by_group) - 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendsms'] = false;
                            $templateData[$position] = $temp;
                        }
                    }

                    file_put_contents(adminTemplatesFile, json_encode($templateData));
                }
                break;
            } else {

                if (count($template_by_group) == 1) {
                    foreach ($template_by_group as $key => $temp) {
                        # code...
                        $position = (array_search($temp, $templateData));
                        $temp['sendsms'] = false;
                        $templateData[$position] = $temp;
                        file_put_contents(adminTemplatesFile, json_encode($templateData));
                    }
                }
            }
        
     }

  //weather
           if(isset($campaign['forecast'])){
                
            if (!$template_by_group[$i]['sendsms']) {
                $currentTime = new DateTime();
                $currentTime->setTimezone($timezone);
                $currentTime->format('H:i');
                    foreach ($users as $user) {
                        $city = explode('/',$user['location'])[0];
                        if(in_array($template_by_group[$i]['group'],$user['groups'])){
    
                            $location_info = getlocationinfo($city);
                            $longitude = $location_info[1];
                            $latitude= $location_info[0];
                            echo $longitude .' '. $latitude;
                            $weathers = getWeather($latitude,$longitude);
                            $currentweather = '';
                              if($campaign['days']=='before')
                              {
                                  $currentweather=$weathers[1];
                              }
                               if($campaign['days']=='same')
                              {
                                   $currentweather=$weathers[0];
                              }
                              if (compareStrings($campaign['forecast'],  $currentweather)) {
                                  
                              sendSMSToUser($user, $template_by_group[$i],$campaign); 
      
                              }
                        
                                }
                    
                   //update sendEmail attribut to true
                    $templateData;
                    $position = (array_search($template_by_group[$i], $templateData));
                    $template_by_group[$i]['sendsms'] = true;
                    $templateData[$position] = $template_by_group[$i];

                    if ($i == count($template_by_group) - 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendsms'] = false;
                            $templateData[$position] = $temp;
                        }
                    }

                    file_put_contents(adminTemplatesFile, json_encode($templateData));
                }
                break;
            } else {

                if (count($template_by_group) == 1) {
                    foreach ($template_by_group as $key => $temp) {
                        # code...
                        $position = (array_search($temp, $templateData));
                        $temp['sendsms'] = false;
                        $templateData[$position] = $temp;
                        file_put_contents(adminTemplatesFile, json_encode($templateData));
                    }
                }
            }
        
     }
        }

        //push 
        if ($campaign['type'] == 'Push') {

            
            if($campaign['days'] != 'Birthdays' && $campaign['days'] != 'Bookings'){
                $pushData = [];
                if (in_array($currentDayOfWeek, $campaign['days'])) {
                    if (!$template_by_group[$i]['sendpush']) {
                        $currentTime = new DateTime();
                        $currentTime->setTimezone($timezone);
                        $currentTime->format('H:i');
                        if ($currentTime->format('H:i') == $campaign['time']) {
                            foreach ($users as $user) {
                                if(in_array($template_by_group[$i]['group'],$user['groups'])){

                                    //get content of push with the user device;
                                    $pushjson = getPushContent($user, $template_by_group[$i],$campaign);                                   
                                    array_push($pushData,$pushjson);
                            }
                            }
                            //update sendpush attribut to true
                            $templateData;
                            $position = (array_search($template_by_group[$i], $templateData));
                            $template_by_group[$i]['sendpush'] = true;
                            $templateData[$position] = $template_by_group[$i];
    
                            if ($i == count($template_by_group) - 1) {
                                foreach ($template_by_group as $key => $temp) {
                                    # code...
                                    $position = (array_search($temp, $templateData));
                                    $temp['sendpush'] = false;
                                    $templateData[$position] = $temp;
                                }
                            }
    
                            //var_dump($templateData);
                            file_put_contents(adminTemplatesFile, json_encode($templateData));
                        }
                       
                        if(count($pushData)>0)
                        {
                            // send sendPushToUsers
                            sendPushToUsers($pushData);
                            $pushData=[];
                        }
                        break;
                    }else {
    
                        if (count($template_by_group) == 1) {
                            foreach ($template_by_group as $key => $temp) {
                                # code...
                                $position = (array_search($temp, $templateData));
                                $temp['push'] = false;
                                $templateData[$position] = $temp;
                                file_put_contents(adminTemplatesFile, json_encode($templateData));
                            }
                        }
                    }
               }
             }
             else{
                $pushData = [];
                if (!$template_by_group[$i]['push']) {
                    $currentTime = new DateTime();
                    $currentTime->setTimezone($timezone);
                    $currentTime->format('H:i');
                    if ($currentTime->format('H:i') == $campaign['time']) {
                        foreach ($users as $user) {
                            if(in_array($template_by_group[$i]['group'],$user['groups'])){
                                
                            $today = date('m/d');
    
                            $birthday = $user['birthday'];
    
                            if (date('m/d', strtotime($birthday)) === $today) {
                                //get content of push with the user device;
                                $pushjson = getPushContent($user, $template_by_group[$i],$campaign);                                   
                                array_push($pushData,$pushjson);
                            }
                                    }
                        }

                        if(count($pushData)>0)
                        {
                            // send sendPushToUsers
                            sendPushToUsers($pushData);
                            $pushData=[];
                        }
                       //update sendpush attribut to true
                        $templateData;
                        $position = (array_search($template_by_group[$i], $templateData));
                        $template_by_group[$i]['sendpush'] = true;
                        $templateData[$position] = $template_by_group[$i];
    
                        if ($i == count($template_by_group) - 1) {
                            foreach ($template_by_group as $key => $temp) {
                                # code...
                                $position = (array_search($temp, $templateData));
                                $temp['sendpush'] = false;
                                $templateData[$position] = $temp;
                            }
                        }
    
                        file_put_contents(adminTemplatesFile, json_encode($templateData));
                    }
                    break;
                } else {
    
                    if (count($template_by_group) == 1) {
                        foreach ($template_by_group as $key => $temp) {
                            # code...
                            $position = (array_search($temp, $templateData));
                            $temp['sendpush'] = false;
                            $templateData[$position] = $temp;
                            file_put_contents(adminTemplatesFile, json_encode($templateData));
                        }
                    }
                }
    
    
              }

            //Bookings
            if($campaign['days'] == 'Bookings'){
                $pushData = [];
                if (in_array($currentDayOfWeek, $campaign['days'])) {
                    if (!$template_by_group[$i]['sendpush']) {
                        $currentTime = new DateTime();
                        $currentTime->setTimezone($timezone);
                        $currentTime->format('H:i');
                        if ($currentTime->format('H:i') == $campaign['time']) {
                            foreach ($users as $user) {
                                if(in_array($template_by_group[$i]['group'],$user['groups'])){
                                    if($bookings!=null){
                                        foreach ($bookings as $booking){
                                            if ($booking['id'] == $user['id']) {
                                                $Appointment = $booking['dateofbooking'];
                                                echo $Appointment."<br>";
                                                $dateTime = DateTime::createFromFormat('d-m-Y/H:i', $Appointment);
                                                $dateTime->sub(new DateInterval('PT'.$campaign['time'].'M'));
                                                $cronTime = $dateTime->format('Y-m-d H:i');
                                                $currentDateTime = new DateTime();
                                                $currentDateTime = $currentDateTime->format('Y-m-d H:i');
                                                echo "User: ".$user['fullName']." - Booking Time: ".$Appointment." - Cron Time: ".$cronTime." - Current Time: ".$currentDateTime."<br>";
                                                if($cronTime==$currentDateTime){
                                                    $pushjson = getPushContent($user, $template_by_group[$i],$campaign);
                                                    array_push($pushData,$pushjson);
                                                    echo " >> Pushed";
                                                }
                                            }
                                        }
                                    }
                                    //get content of push with the user device;
                                }
                            }
                            //update sendpush attribut to true
                            $templateData;
                            $position = (array_search($template_by_group[$i], $templateData));
                            $template_by_group[$i]['sendpush'] = true;
                            $templateData[$position] = $template_by_group[$i];

                            if ($i == count($template_by_group) - 1) {
                                foreach ($template_by_group as $key => $temp) {
                                    # code...
                                    $position = (array_search($temp, $templateData));
                                    $temp['sendpush'] = false;
                                    $templateData[$position] = $temp;
                                }
                            }

                            //var_dump($templateData);
                            file_put_contents(adminTemplatesFile, json_encode($templateData));
                        }

                        if(count($pushData)>0)
                        {
                            // send sendPushToUsers
                            sendPushToUsers($pushData);
                            $pushData=[];
                        }
                        break;
                    }else {

                        if (count($template_by_group) == 1) {
                            foreach ($template_by_group as $key => $temp) {
                                # code...
                                $position = (array_search($temp, $templateData));
                                $temp['push'] = false;
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

// Tableau d'utilisateurs



// Search RSS Feed Admin Cron

// Get Cron Data File
function getCronFile()
{
    $file = getcwd() . "/db/cron_time.json";

    if (!file_exists($file)) {
        file_put_contents($file, []);
    }

    return $file;
}

// Get Cron Data
function getCronData(){
    $filePath = getCronFile();
    $jsonData = file_get_contents($filePath);
    $data = $jsonData && json_decode($jsonData, true) != null ? json_decode($jsonData, true) : [];
    return $data;
}

// Update Cron Data
function updateCronData(){
    $filePath = getCronFile();
    $data = array(
        'cron_time' => date('Y-m-d')
    );
    file_put_contents($filePath, json_encode($data));
    return true;
}

// Check if Request Need
function checkRequestNeed(){
    $cronData = getCronData();
    $is_needed = false;

    if(count($cronData)){
        $currentDate = date('Y-m-d');
        $currentDateTime = new DateTime($currentDate);

        $cronDate = $cronData['cron_time'];
        $cronDateTime = new DateTime($cronDate);

        if ($currentDateTime > $cronDateTime) {
            updateCronData();
            $is_needed = true;
        }
    }else{
        updateCronData();
        $is_needed = true;
    }

    return $is_needed;
}

// Send Request
function sendRequest(){
    $search_url = constant('domain') . 'search/saveSearchData.php';
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $search_url);
    curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_exec($ch);
    curl_close($ch);
}

if(checkRequestNeed()){
    sendRequest();
}
?>