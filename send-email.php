<?php
require 'config.php';
require  "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$questionsdata = file_get_contents('db/questions.json');
$questionS=json_decode($questionsdata,true);
if(isset($_POST['jsonData']))
{
$jsonData = $_POST['jsonData'];
$jsonData = json_decode($jsonData, true);


$id = $jsonData['id'];
$fullName = $jsonData['fullName'];
$website = $jsonData['website'];
$number = $jsonData['number'];
$email = $jsonData['email'];
$date = $jsonData['date'];
$statut = $jsonData['status'];
$questions = $jsonData['question'];

require emailFile;
 //echo $message;

 
//Server settings
$mail = new PHPMailer(true);
try {
  $mail->SMTPDebug = SMTP::DEBUG_OFF;
  $mail->isSMTP();
  $mail->Host       = host;
  $mail->SMTPAuth   = true;
  $mail->Username   = username;
  $mail->Password   = password;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = port;
  $mail->isHTML(true);
  $mail->Encoding = "base64";
  $mail->CharSet = "UTF-8";

  //Recipients
  $mail->setFrom(address, name);

  $mail->addAddress($email, $fullName);

  //Content
  $mail->isHTML(true);
  $mail->Subject = subject;
  $mail->Body = $message;
  
  if ($mail->send()) {
    
    echo 'success';
  } else {
   
    echo 'error';
  }
} catch (Exception $e) {
  var_dump($e);
  die();
}

}


if(isset($_POST['alert'])) 
$name = $_POST['name'];
$fullName = 'Admin';
{

foreach (email_address as $key => $adminEmail) {
  # code... 
  require 'adminAlert.php';
  $email = $adminEmail;

  
//Server settings
$mail = new PHPMailer(true);
try {
  $mail->SMTPDebug = SMTP::DEBUG_OFF;
  $mail->isSMTP();
  $mail->Host       = host;
  $mail->SMTPAuth   = true;
  $mail->Username   = username;
  $mail->Password   = password;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = 465;
  $mail->isHTML(true);
  $mail->Encoding = "base64";
  $mail->CharSet = "UTF-8";

  //Recipients
  $mail->setFrom(address, name);

  $mail->addAddress($email, $fullName);

  //Content
  $mail->isHTML(true);
  $mail->Subject = subject;
  $mail->Body = $message;
  
  if ($mail->send()) {
    
    echo 'success';
  } else {
   
    echo 'error';
  }
} catch (Exception $e) {
  var_dump($e);
  die();
}
}

}