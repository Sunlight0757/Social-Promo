<?php
$message='
<!DOCTYPE html>
<html lang="en">

<head>

<!-- Title -->
<title>Social Promo - All-in-one Reward, Booking and Marketing Platform.</title>

<!-- Meta Data -->
<meta charset="utf-8">
<meta name="title" content="Social Promo - All-in-one Reward, Booking and Marketing Platform">
<meta name="description" content="Triple your traffic, leads & referrals while you focus on running your business and serving customers">

<style>

body, h1, h2, h3, p, button, input, select, textarea {
	font-family: Arial, sans-serif;
}

</style>

</head>

<body>
	
<p>Hi '.$fullName.',</p>

<p>Congratulations for earning 100 points in the promotion, please review your answers, if any are incorrect, re-take the promotion so we can send you the offer.</p>

<b>Your Social Profile:</b><br>
'.$website.'<br><br>

<b>Your Mobile Number:</b><br>
'.$number.'<br><br>';

foreach ($questions as $key => $questionvalue) {
$message.='<b><span style="color:#00b878">'.($key+1).') </span> '.$questionS[$key]['question'].'</b><br>';

foreach ($questionvalue['answers'] as $keya => $answer) {
	# code...
	$message.=$answer.'<br>';
}

$message.=$questionvalue['comment'].'<br><br>';
}
// foreach ($question2 as $key => $value) {
// 	# code...
// 	$message.=$value.'<br>';
// }

$message.='

<hr>

<p><b>Click below to confirm your answers to get regular rewards!</b>

<p><a href="'.domain.'?index='.$id.'&id='.confirmSlide.'">'.domain.'?index='.$id.'&id='.confirmSlide.'</a></p>

<p>Best regards,</p>

<p>Social Promo</p>

</body>
</html>';

