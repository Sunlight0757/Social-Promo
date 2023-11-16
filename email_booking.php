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

<p>Congratulations for been register to a'.$service.' \'s booking, please review your booking data, if any are incorrect, re-take the promotion so we can send you the offer.</p>

<b>Your Social Profile:</b><br>
'.$website.'<br><br>

<b>Your Mobile Number:</b><br>
'.$number.'<br><br>

<b>Your Booking Date and Time :</b><br>
'.$dateofbooking.'<br><br>';

$message.='

<hr>

<p><b>Click below to confirm your answers to get regular rewards!</b>

<p><a href="'.domain.'?index='.$id.'&id='.confirmSlide.'">'.domain.'?index='.$id.'&id='.confirmSlide.'</a></p>

<p>Best regards,</p>

<p>Social Promo</p>

</body>
</html>';

