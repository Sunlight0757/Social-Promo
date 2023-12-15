<!DOCTYPE html>
<html lang="en">
	
<?php 
require 'config.php'; 

// QUESTIONS
$question_json = file_get_contents('db/demo_questions.json');
$questions = json_decode($question_json, true);


function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

($ip = getIp());
?>
<?php

$id='false';
if (isset($_GET['id'])) {

	$id = $_GET['id'];

}
// foreach ($variable as $key => $value) {
// 	# code...
// }
$confirm='false';
if (isset($_GET['index'])) {
	$index = $_GET['index'];
	$data_json = file_get_contents(datafile);
	$data = json_decode($data_json, true);
	$userdata = null;
	$position = null;
	foreach ($data as $key => $value) {
		# code...
		if ($value['id'] == $index ) {
			$userdata = $value;
			$position = $key;
		}
	}

	if ($userdata) {
		$userdata['verified'] = 'true';
		$data[$position] = $userdata;
		$data_json = json_encode($data);
		file_put_contents(datafile, $data_json);
		$confirm=true;
	}

	$data_json = file_get_contents(bookingdatafile);
	$data = json_decode($data_json, true);
	$userdata = null;
	$position = null;
	foreach ($data as $key => $value) {
		# code...
		if ($value['id'] == $index ) {
			$userdata = $value;
			$position = $key;
		}
	}

	if ($userdata) {
		$userdata['verified'] = 'true';
		$data[$position] = $userdata;
		$data_json = json_encode($data);
		file_put_contents(bookingdatafile, $data_json);
		$confirm=true;
	}
}

$isgift= false;
if (isset($_GET['gifter'])) {
	$id_gifter = $_GET['gifter'];
	$data_json = file_get_contents(datafile);
	$data = json_decode($data_json, true);
	$gifter = null;
	foreach ($data as $key => $value) {
		# code...
		if ($value['id'] == $id_gifter ) {
			$gifter = $value;
		}
	}

	if ($gifter) {
		$isgift=true;
	}
}
 
$tag = null;
if (isset($_GET['p'])) {
	$tagid = $_GET['p'];
	$urldata_json = file_get_contents('create/data.json');
	$urldata = json_decode($urldata_json, true);
	
	//$position = null;
	foreach ($urldata as $key => $value) {
		# code...
		if ($value['id'] == $tagid ) {
			$tag = $value;
			//$position = $key;
		}
	}
}

/*if(!$tag){
	header("Location: https://socialpromo.biz/create");
}*/
?>

<?php
	
	/// WEBSITE
	$websiteURL = 'https://socialpromo.biz';

	if (isset($_GET['p']) and $tag) { 
		$websiteURL=$tag['url'];
	}
	
	/// COLORS
	$brandColor = '#9adc5f';
	$surveyColor = '#21a56e';
	$buttonColor = 'background-image: linear-gradient(45deg, #21a56e 0%, #9adc5f 100%)';	
	
	$_SESSION['websiteURL'] = $websiteURL;
	$_SESSION['brandColor'] = $brandColor;
	$_SESSION['surveyColor'] = $surveyColor;
	$_SESSION['buttonColor'] = $buttonColor;	

?>

<head>
	
<?php require 'meta.php';?>

<!--====================== PLUGINS ======================-->

<!-- Slideform -->
<link href="src/css/table.css" rel="stylesheet">
<link rel="stylesheet" href="src/css/slideform.css">

<!-- Social Buttons -->
<link rel="stylesheet" href="src/css/social-buttons.css">

<!-- Coupon -->
<link rel="stylesheet" href="plugins/coupon/style.css">

<!-- Badge -->
<link rel="stylesheet" href="plugins/badge/style.css">

<!-- iFrame -->
<link rel="stylesheet" href="plugins/iframe/dist/lazyembed.css" />

<style>
	
/**************************************** HEADER ****************************************/

.header {
    background-color: #181314 !important;
	background: linear-gradient( rgba(24, 19, 20, 0.8), rgba(65, 60, 61, 0.8) ), url(<?php echo $image; ?>) !important;
    background-repeat: no-repeat;	
    background-position: center top;
    background-size: cover !important;
    -moz-background-size: cover !important;	
    background-attachment: fixed !important;
}

.navbar .logo-image img {
    width: 219px;
    height: auto;
}

.navbar .nav-item .nav-link {
	color: #f7f7f7;
}

.navbar .nav-item.dropdown.show .nav-link, .navbar .nav-item .nav-link:hover, .navbar .nav-item .nav-link.active {
    color: #fff;
}

/**************************************** BODY ****************************************/

html, body {
	height: 100%;
	width: 100%;
	padding: 0;
	margin: 0;
	overflow: hidden;
	position: fixed;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
}

body, h1, h2, h3, p, button, input, select, textarea {
	font-family: 'Roboto', Arial, sans-serif;
}

hr {
    border-top: 1px solid rgba(255,255,255,.2);
}

label {
	display: block;
	font-size: 17px;
	margin-bottom: 10px;
	letter-spacing: .5px;
	font-weight: 600;
	font-family: Roboto;
}

.gist .gist-file {
	margin-top: 40px;
}

.gist .gist-meta {
	display: none !important;
}

.info-box .info-box-number {
    font-weight: normal;
}

.widget-user .widget-user-header {
    height: auto;
}

/**************************************** TEXT ****************************************/

h1 {
	letter-spacing: .5px;
	font-weight: 600;
}

h2, h3 {
	margin-top: 0;
}

h2 {
	font-size: 28px;
	margin: 0 0 15px;
	font-weight: bold;
}

h3 {
	font-size: 20px;
	line-height: 1.4em;
	font-weight: bold;
	margin-bottom: 20px;
	margin-top: 20px;
}

h4 {
	font-size: 16px;
	font-weight: bold;
	margin: 20px 0 10px;
}

p {
	font-size: 16px;
	line-height: 1.6em;
	margin-bottom: 15px;
}

a {
    text-decoration: none !important;
}

/**************************************** FORM ****************************************/

input {
	font-size: 16px;
}

select {
	width: 100%;
	padding: 15px;
	font-size: 20px;
	box-sizing: border-box;
	border: 1px solid #E0E0CE;
	outline: none;
	border-radius: none;
	background: #f6f6f6;
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
}

form {
	opacity: 0;
	transition: all .3s ease;
}

form.slideform-form {
	opacity: 1;
}

form.slideform-form .slideform-btn {
    height: 50px;
    padding: 0 15px;
    font-size: 18px;
    font-weight: bold;
    color: #1c1c1c;
    background-color: #fff;
    border: 0px solid #fff;
    float: right;
    cursor: pointer;
}

form.slideform-form .slideform-slide {
	display: grid;
}

form.slideform-form .slideform-progress-bar span {
	background: <?php echo $brandColor; ?>;
}

form.slideform-form input:not([type=checkbox]):not([type=radio]):not([type=submit]), form.slideform-form textarea {
	font-size: 25px;
}

form.slideform-form .slideform-group {
    padding: 15px 15px;
}

form.slideform-form .options-list input[type=checkbox] + span:after, form.slideform-form .options-list input[type=radio] + span:after {
    color: <?php echo $surveyColor; ?>;
}

#slideform-background {
	color:#fff;
    background-color: #21a56e;
	background: linear-gradient( rgba(24, 19, 20, 0.8), rgba(65, 60, 61, 0.9) ), url(<?php echo $image; ?>);
    background-repeat: no-repeat;	
    background-position: center top;
    background-size: cover;
    -moz-background-size: cover;		
    background-attachment: fixed;
}

/**************************************** IFRAME ****************************************/

.iframe-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    padding-top: 56.25%;
}

.iframe-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/**************************************** BUTTONS & BADGES ****************************************/

.btn-social.btn-lg :first-child {
	line-height: 45px;
}

.btn-group-lg>.btn, .btn-lg {
    border-radius: 0rem;
}

.button.button-primary {
    color: #000;
    background: #fff;
}

.button {
    font-size: 20px;
}

.badge {
    font-size: 150%;
}

/**************************************** TIMER ****************************************/

.tick {
  font-size:1rem; white-space:nowrap; font-family:arial,sans-serif;
  margin: auto;
  width: 95%;
}

@media screen and (max-width: 735px){
.tick {
  font-size:1rem; white-space:nowrap; font-family:arial,sans-serif;
  margin: auto;
  width: 95% !important;
}
  }

.tick-flip,.tick-text-inline {
  font-size:2.5em;
}

.tick-label {
  margin-top:1em;font-size:1em;
}

.tick-char {
  width:1.5em;
}

.tick-text-inline {
  display:inline-block;text-align:center;min-width:1em;
}

.tick-text-inline+.tick-text-inline {
  margin-left:-.325em;
}

.tick-group {
  margin:0 .5em;text-align:center;
}

.tick-flip-panel-text-wrapper {
   line-height: 1.45 !important; 
}

.tick-flip {
   border-radius:0.12em !important; 
}

/*.tick-flip-panel {
  color: #19232a;
  background-color: #e0e0e0; 
 }*/

/**************************************** USER ****************************************/

.lockscreen-wrapper {
    margin-top: 2%;
}

.lockscreen {
    background-color: #181314 !important;
    background-image: linear-gradient(45deg, #181314 0%, #413c3d 100%) !important;
}

.direct-chat-messages {
    height: 350px;
    padding: 0px;
}

.dynamic-content {
    display:none;
}

/**************************************** TABLE ****************************************/

.wrap table td:nth-child(3), .wrap table th:nth-child(3) {
    box-shadow: 2px 20px 20px 0px rgba(0, 0, 0, 0.3) !important;
}

.wrap table td, .wrap table th {
    position: inherit !important;
}

.wrap table td {
    overflow: inherit !important;
}

/**************************************** VIDEO ****************************************/

video {
    width: 100%;
    height: auto;
}

/**************************************** SLIDES ****************************************/

.mySlides {
	display:none;
}

#divB { 
    display : none; 
}

/**************************************** COLUMNS ****************************************/

@media only screen and (min-device-width : 320px) and (max-device-width : 480px){ 
    .card-columns {
        -moz-column-count: 1;
        -webkit-column-count: 1;
        column-count: 1;
    }
}

@media only screen and (min-width: 600px) and (max-width: 1200px){
    .card-columns {
        -moz-column-count: 2;
        -webkit-column-count: 2;
        column-count: 2;
    }
}

@media only screen and (min-width: 1200px) {
    .card-columns {
        -moz-column-count: 2;
        -webkit-column-count: 2;
        column-count: 2;
    }
}

/**************************************** RATING ****************************************/

.rating > .fas {
    display: inline-block;
    position: relative;
    width: 1.1em;
    color: white;
    font-size:40px;
    cursor:pointer;
}

/**************************************** COUPON ****************************************/

.coupon {
  border: 5px dotted #bbb;
  width: 100%;
  border-radius: 15px;
  margin: 0 auto;
  max-width: 600px;
}

.coupon-container {
  padding: 2px 16px;
  background-color: #f1f1f1;
}

.promo {
  background: #ccc;
  padding: 3px;
}

.expire {
  color: red;
}

.card {
  border-radius: 15px;
}

/**************************************** LEADS ****************************************/

.lockscreen-wrapper {
    margin-top: 2%;
}

.lockscreen {
    background-color: #181314 !important;
    background-image: linear-gradient(45deg, #181314 0%, #413c3d 100%) !important;
}

/**************************************** MODAL ****************************************/

.modal-dialog-slideout {min-height: 100%; margin: 0 0 0 auto;}
.modal.fade .modal-dialog.modal-dialog-slideout {-webkit-transform: translate(100%,0)scale(1);transform: translate(100%,0)scale(1);}
.modal.fade.show .modal-dialog.modal-dialog-slideout {-webkit-transform: translate(0,0);transform: translate(0,0);display: flex;align-items: stretch;-webkit-box-align: stretch;height: 100%;}
.modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body{overflow-y: auto;overflow-x: hidden;}
.modal-dialog-slideout .modal-content{border: 0;}
.modal-dialog-slideout .modal-header, .modal-dialog-slideout .modal-footer {height: 69px; display: block;} 
.modal-dialog-slideout .modal-header h5 {float:left;}

.btn-social.btn-lg :first-child {
    line-height: 45px;
}

</style>

</head>

<body>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="https://socialpromo.biz/images/favicon/icon_100px.png" alt="Logo" height="100" width="100">
	<p class="text-muted">Loading...</p>
  </div>
  
<form action="">

<!--- ID 0 (Bookings) / Value 1 --->
<div class="slideform-slide">
    <div class="slideform-group text-center text-dark">
        <div class="col-md-12">
		
		<!-- Coupon -->
<div class="c-container card">
	<div style="background:#f8f8f8" class="coupon-card">
	    <img style="border-top-right-radius: 15px;;border-top-left-radius: 15px;" class="img-fluid" src="<?php echo isset($_GET['b']) ? $_GET['b'] : 'https://socialpromo.biz/images/demo/booking_facebook.jpg';?>" alt="Social Promo">
		<h3 style="display:<?php echo isset($_GET['rh']) ? $_GET['rh'] : '';?>"><b>20-50% BOOKING DISCOUNT!</b></h3>
		<span class="text-muted"><small>Click to share and reveal discount code to add to your booking!</small></span>
		
		<a href="#share" data-toggle="collapse" class="coupon-row text-dark pb-5" id="div1" style="display:block" onclick="replace()">
			<span style="background:#fff" id="shareCode">XXXXXXXXXXXX</span>
			<span" id="shareBtn">Reveal</span>
		</a>
		
		<div class="coupon-row" id="div2" style="display:none">
			<span id="cpnCode"><?php echo isset($_GET['c']) ? $_GET['c'] : 'STEALDEAL';?></span>
			<a href="javascript:void(0);" id="cpnBtn"><i class="fas fa-link"></i> Copy</a>
		</div>		
		
		<div style="background:#fff" class="circle1"></div>
		<div style="background:#fff" class="circle2"></div>	
		
<div id="share" class="collapse p-2">
							
<div class="btn-group btn-block" style="display:<?php echo isset($_GET['fb']) ? $_GET['fb'] : '';?>">
<a href="https://www.facebook.com/share.php?u=<?php echo $websiteURL; ?>" id="fbshare" onclick="popup('fbshare','s',true)"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-facebook rounded">
	<i class="fab fa-facebook fa-2x"></i> Facebook share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['ln']) ? $_GET['ln'] : '';?>">
<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $websiteURL; ?>" id="linkedin" onclick="popup('linkedin','s')"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-linkedin rounded">
	<i class="fab fa-linkedin fa-2x"></i> LinkedIn Share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['ig']) ? $_GET['ig'] : '';?>">
<a href="https://socialpromo.biz/plugins/instagram/share/index.php?p=<?php echo $websiteURL; ?>" id="instashare" onclick="popup('instashare','s')"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-instagram">
	<i class="fab fa-instagram fa-2x"></i> Instagram Share
	</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['mg']) ? $_GET['mg'] : '';?>">
<a href="https://www.facebook.com/dialog/send?link=<?php echo $websiteURL; ?>&app_id=291494419107518&redirect_uri=<?php echo $websiteURL; ?>" id="messenger" onclick="popup('messenger','s')"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-messenger">
	<i class="fab fa-facebook-messenger fa-2x"></i> Messenger Share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['pn']) ? $_GET['pn'] : '';?>">
<a href="http://pinterest.com/pin/create/button/?url=<?php echo $websiteURL; ?>&media=<?php echo isset($_GET['b']) ? $_GET['b'] : 'https://socialpromo.biz/images/demo/booking_facebook.jpg';?>&description=Social-Promo" id="pinterest" onclick="popup('pinterest','s')"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-pinterest rounded">
	<i class="fab fa-pinterest fa-2x"></i> Pinterest Share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['tk']) ? $_GET['tk'] : '';?>">
<a href="https://www.tiktok.com/" id="tiktok" onclick="popup('tiktok','s',true)" target="_blank" class="btn-lg btn-block btn-social linkpoint btn-tiktok">
	<i class="fab fa-tiktok fa-2x"></i> TikTok Follow</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['tw']) ? $_GET['tw'] : '';?>">
<a href="https://twitter.com/share?text=Checked-in%20at:%20<?php echo $websiteURL; ?>" id="twitter" onclick="popup('twitter','s',true)"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-twitter rounded">
	<i class="fab fa-twitter fa-2x"></i> Twitter Share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['wp']) ? $_GET['wp'] : '';?>">
<a href="https://api.whatsapp.com/send?text=Check%20out:<?php echo $websiteURL; ?>" id="whatsApp" onclick="popup('whatsApp','s',true)"  target="_blank" class="btn-lg btn-block btn-social linkpoint btn-whatsapp">
	<i class="fab fa-whatsapp fa-2x"></i> WhatsApp Share
</a>
</div>

<div class="btn-group btn-block" style="display:<?php echo isset($_GET['yt']) ? $_GET['yt'] : '';?>">
<a href="https://www.youtube.com/" id="youtube" onclick="popup('youtube','s',true)" target="_blank" class="btn-lg btn-block btn-social linkpoint btn-youtube">
	<i class="fab fa-youtube fa-2x"></i> YouTube Subscribe</a>
</div>

</div>

	</div>
</div>	  	
		
            <div class="card card-widget ">
                <div class="widget-user-header bg-light p-0" style="border-radius: 15px; box-shadow: 0 10px 10px 0 rgba(0,0,0,0.15);">   

					<p><iframe width="100%" height="600px" id="booking-iframe" class="embed-responsive-item" src="plugins/booking/index.php" frameborder="0"></iframe></p>			
			
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <button class="text-white btn bg-gradient-dark btn-lg mt-0 slideform-btn slideform-btn-next">NEXT</button>
    </div>
</div>

<!--- ID 1 (Questions) / Value 2 --->
<?php foreach($questions as $key => $question): ?>

<div class="slideform-slide">
	<div class="slideform-group">
	
	<div class="col-md-12">
            
            <div class="card card-widget widget-user shadow">        
              <div class="widget-user-header bg-light">
			  <img class="img-fluid" src="<?php echo isset($_GET['b']) ? $_GET['b'] : 'https://socialpromo.biz/images/demo/booking_facebook.jpg';?>" alt="Social Promo">
				<h2 class="pt-3"><?php echo isset($_GET['h']) ? $_GET['h'] : 'Get regular deals in your inbox!';?></h2>	
                <p class="text-dark">Complete the short survey so we can send you relevant promotions.</p>
				
				<hr style="border-top: 1px solid #ddd;">

	<h2 class="question text-center"><!--<span style="color:#00b878"><small><b><?=$key+1?>/2 </b></small></span>--><span class="question<?=$key+1?>"><?=$question['question']?></span></h2>
	<?php if($question['image'] ): ?>
		<p><img style="border-radius: 15px" class="img-fluid" src="<?=$question['image']?>"></p>
		<?php endif;?>		
	<?php if( count($question['options'])>0): ?>
		<div class="options options-list text-left">
		<?php foreach($question['options'] as $keyo => $option): ?>
			<label for=""><input type="checkbox" name="group<?=$key+1?>" class="myCheckbox myQuestion<?=$key+1?>" >
			<span>
			<span class="option"><?php if(count(explode('; ',$option))==1): ?><?=$option?></span><span class="group"  style="display: none;">null</span>
			<?php else:?><?=explode('; ',$option)[0]; ?></span><span class="group"  style="display: none;"><?=explode('; ',$option)[1]; ?></span>
			<?php endif;?>
			</span>
			</label>
		<?php endforeach;?>
	</div>
		
		<?php endif;?>

		<input type="text" class="form-control form-control-lg" <?php if (isset($_GET['p']) and $tag and $key ==0) : ?> value="<?=$tag['promo']?>" <?php endif; ?> id="comment<?=$key+1?>" placeholder="Something else?" />
				
              </div>
			  
            </div>
            <!-- /.widget-user -->
          </div>

		<button style="background:#00b878;color:#fff" class="slideform-btn slideform-btn-next">NEXT</button>

	</div>
</div>

<?php endforeach;?>
	
<!--- ID 2 / Value 3 --->
<div class="slideform-slide">
	<div class="slideform-group text-dark">
		
		<p><img style="border-radius:15px;border: 4px solid white;" class="img-fluid" width="100%" src="<?php echo isset($_GET['b']) ? $_GET['b'] : 'https://socialpromo.biz/images/demo/booking_facebook.jpg';?>"></p>
	
		<h2 class="text-center">Enter your details to confirm your booking.</span></h2>
	
		<div class="bookingData" style="display: none;">
		<hr>
			<h3 class="text-dark text-danger">Booking details</h3>
			<b>DATE: </b><span class="bookingdate"></span><br>
			<b>TIME: </b><span class="bookingtime"></span>
		</div>

		<hr>
		
		<label for="input">Your Social Profile <small>- Optional</small></label>
		<p id='website'><input  type="text" name="website" placeholder="Enter social profile..."></p>

		<label for="input">Your Full Name</label>
		<p id='fullname'><input type="text" name="fullname" placeholder="Enter full name..."></p>

		<label for="input">Your Mobile Number</label>
		<p id='number'><input type="text" name="number" placeholder="Enter mobile number..."></p>
		<span id="nberror" class="text-danger" style=" color: #F93943; display: none;  font-size: 14px; letter-spacing: .5px; font-weight: 600; font-family: Roboto; margin-bottom:5px;    text-transform: none;">Please error</span>

		<label for="input">Your Email</label>
		<p id='email'><input type="email" name="email" placeholder="Enter email address..."></p>

		<button type="submit" id="submit" class="text-white btn bg-gradient-dark btn-lg slideform-btn">
			<div id="spinner" class="spinner-border text-light" style="width: 20px; height: 20px; display: none;" ; role="status">
				<span class="sr-only">Loading...</span>
			</div> SUBMIT
		</button>
		<!--<button class="slideform-btn slideform-btn-prev">BACK</button>-->

	</div>
</div>

<!--- ID 3 --->
<div class="slideform-slide">
	<div class="slideform-group">

		<p><img class="img-fluid" style="border-radius:15px;border: 5px solid white;" width="100%" src="<?php echo isset($_GET['b']) ? $_GET['b'] : 'https://socialpromo.biz/images/demo/booking_facebook.jpg';?>"></p>
		
		<div class="form-group">			
		<label>Enter date of birth:</label>
               <input name="birthdate" id="date" value="" type="date"  class="form-control date" id="exampleInputEmail1" placeholder="Entrer une date">                                     
		</div>
		
		<!--div class="form-group">
				<input id="txtDOB" runat="server" name=""  CssClass="form-control form-control-small col-md-3 birthdate" placeholder="dd/mm/yyyy" autocomplete="off"/>
		</div-->
		
            <p>
                <asp:Label ID="lblAgeValue" CssClass="age" runat="server" />
            </p>		
		
		<button style="background:#00b878" type="submit" id="submitBirthday" class="slideform-btn">
			<div id="spinner" class="spinner-border text-light" style="width: 20px; height: 20px; display: none;" ; role="status">
				<span class="sr-only">Loading...</span>
			</div> SUBMIT
		</button>
		
		<button class="slideform-btn slideform-btn-prev">BACK</button>	
		<button class="slideform-btn slideform-btn-next">NEXT</button>

	</div>
</div>

<!--- ID 4 --->
<div class="slideform-slide" id="slideform-background">
	<div class="slideform-group" id="end">

		<p class="text-center"><img class="img-fluid" width="220px" src="https://socialpromo.biz/images/logo.png"></p>
		
		<hr>
		<h2>Great, you have completed the promotion!</h2>
		<p><b>We will contact you soon with your offer.</b></p>

		<hr>

		<h2>Want alerts of:</h2>
		<p><i class="fa-solid fa-check"></i> New deals</p>
		<p><i class="fa-solid fa-check"></i> New discounts</p>
		<p><i class="fa-solid fa-check"></i> New rewards</p>
		<button style="background:#00b878;color:#fff" id="allowpushNotification" class="slideform-btn "><i class="fa-solid fa-arrow-right fa-beat-fade"></i> ALLOW PUSH NOTIFICATIONS</button>
		<br><br><br><br><br>
		<p class="text-center"><img class="img-fluid" src="src/img/push.png"></p>
		
	</div>
</div>

<!--- ID 5 --->
<div class="slideform-slide" id="slideform-background">
	<div class="slideform-group text-center" >
	
		<p class="text-center"><img class="img-fluid" width="220px" src="https://socialpromo.biz/images/logo.png"></p>
		
		<hr>

		<h2 class="pr-5 pl-5">Thanks for confirming your details. The business will contact you soon!</h2>
		<p class="pr-5 pl-5"><b>Look out in your email inbox or SMS message with the offer.</b></p>
		<p><img style="border-radius:15px;border: 4px solid white;" class="img-fluid" src="images/banner/reward_rewards.jpg"></p>

	</div>
</div>

</form>

<!--================================================================================= MODALS =================================================================================-->

<!------------------------------------- BADGE ------------------------------------->

	<div class="modal fade" id="badges">
	  <div class="modal-dialog modal-dialog-slideout modal-sm">
		<div class="modal-content">
		  <div class="modal-header">
			<h2 class="modal-title text-dark">Badges earned</h1>
			<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>-->
		  </div>
		  <div class="modal-body">

<div class="main-wrapper">
  <div id="badge1"class="reward-badge teal" style="opacity: 0.2 !important;">
    <div class="circle"> <i class="fa-solid fa-person-hiking"></i></div>
    <div class="ribbon">Adventurer</div>
  </div>
  <div id="badge2"class="reward-badge orange" style="opacity: 0.2 !important;">
    <div class="circle"> <i class="fa-solid fa-bag-shopping"></i></div>
    <div class="ribbon">Shopaholic</div>
  </div>
  <div id="badge3"class="reward-badge red" style="opacity: 0.2 !important;">
    <div class="circle"> <i class="fa-solid fa-tag"></i></div>
    <div class="ribbon">Hunter</div>
  </div>
  <div id="badge4"class="reward-badge gold" style="opacity: 0.2 !important;">
    <div class="circle"> <i class="fa-solid fa-heart"></i></div>
    <div class="ribbon">Loyalist</div>
  </div>
</div>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale" class="btn btn-dark" data-dismiss="modal">Close</button>
			<a href="#leaderboard" data-toggle="modal" data-dismiss="modal" class="btn btn-danger"> Leaderboard </a>
			</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

<!--================================================================================= SCRIPTS =================================================================================-->

<!-- jQuery -->
<script src="src/plugins/jquery/jquery.min.js"></script>

<!-- Slideform -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<script src="src/js/slideform.js"></script>

<!-- Bootstrap 4 -->
<script src="src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Birthday -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<!-- Firebase-->
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>

<!-- AdminLTE App -->
<script src="src/plugins/dist/js/adminlte.min.js"></script>

<!-- Scripts -->
<script>
	//console.log(apiKey);
	const api_location = '<?=api_location?>';
	const send_email_verification = '<?=send_email_verification?>';
	const send_booking_verification = '<?=send_booking_verification?>';
	const send_sms = '<?=send_sms?>';
	const smsMessage = '<?=smsMessage?>';
	const smsbookingMessage = '<?=smsbookingMessage?>';
	const domain = '<?=domain?>';
	let download = <?=download?>;
	let visitpoint = <?=visit?>;
	let puzzle = <?=puzzle?>;
	let game = <?=game?>;
	let memory = <?=memory?>;
	let survey = <?=survey?>;
	let video = <?=video?>; 
	let share = <?=share?>; 
	let delay = <?=shareDelay?>; 
	let delay2 = <?=shareDelay2?>; 
	let videoid = '<?=videoid?>'; 
	let videoDelay = <?=videoDelay?>;
	let gameDelay = <?=gameDelay?>;
	const  send_email_alert = '<?=send_email_alert?>';
	const  adminalert = '<?=adminalert?>';
	const  adminbookingalert = '<?=adminbookingalert?>';
	const  adminbookingreminder = '<?=adminbookingreminder?>';
	const  send_sms_alert = '<?=send_sms_alert?>';
	const  sms_phoneNumber = '<?=json_encode(sms_phoneNumber)?>';
	let ip = '<?=$ip?>';
	let visitDelay = <?=visitDelay?>;
	const allow_push = '<?=allow_push?>';
	const iconNotification = '<?=iconNotification?>';
	const imageNotification = '<?=imageNotification?>';
	const bodyNotification = '<?=bodyNotification?>';
	const confirmSlidePosition = '<?=confirmSlide?>';
	const bookingslide = '<?=bookingslide?>';
	const afterbookingslide = '<?=afterbookingslide?>';
	const giftslide = '<?=giftslide?>';
	let badge1 = '<?=badge1?>'; 
	let badge2 = '<?=badge2?>'; 
	let badge3 = '<?=badge3?>'; 
	let badge4 = '<?=badge4?>';
	let alerttitle ='<?=alerttitle?>';
	let alerttext ='<?=alerttext?>';
	let st= <?=(status)?>;
	let firstElement = st[0];
	let stDefaut = Object.keys(firstElement)[0];
	let confirmFile ='<?=confirmFile?>';
	let sendemailFile ='<?=sendemailFile?>';
	let emailFile ='<?=emailFile?>';

	sendemailBookingFile  = '<?=sendemailBookingFile?>';
    emailBookingFile  = '<?=emailBookingFile?>';
    confirmBookingFile  = '<?=confirmBookingFile?>';
</script>

<!-- Promo-->
<script src="src/js/promo.js"></script>
<script type="module" src="src/js/script.js"></script>

<!-- iFrames -->
<script src="plugins/iframe/dist/lazyembed.js"></script>
<script>
	new LazyEmbed();
</script>

<script type="text/javascript" src="src/js/iframeResizer.min.js"></script>  
<script type="text/javascript">

/*
* If you do not understand what <p>The code below does, <p>Then please just use <p>The
* following call in your own code.
*
*   iFrameResize({log:true});
*
* Once you have it working, set <p>The log option to false.
*/

iFrameResize({
log                     : true,                  // Enable console logging
enablePublicMethods     : true,                  // Enable methods within iframe hosted page
enableInPageLinks       : true,
resizedCallback         : function(messageData){ // Callback fn when resize is received
	$('p#callback').html(
		'<b>Frame ID:</b> '    + messageData.iframe.id +
		' <b>Height:</b> '     + messageData.height +
		' <b>Width:</b> '      + messageData.width +
		' <b>Event type:</b> ' + messageData.type
	);
},
messageCallback         : function(messageData){ // Callback fn when message is received
	$('p#callback').html(
		'<b>Frame ID:</b> '    + messageData.iframe.id +
		' <b>Message:</b> '    + messageData.message
	);
	alert(messageData.message + ' (' + messageData.iframe.id + ')' );
},
closedCallback         : function(id){ // Callback fn when iFrame is closed
	$('p#callback').html(
		'<b>IFrame (</b>'    + id +
		'<b>) removed from page.</b>'
	);
}
});

//MDN PolyFil for IE8 (This is not needed if you use <p>The jQuery version)
if (!Array.prototype.forEach){
Array.prototype.forEach = function(fun /*, thisArg */){
"use strict";
if (this === void 0 || this === null || typeof fun !== "function") throw new TypeError();

var
t = Object(this),
len = t.length >>> 0,
thisArg = arguments.length >= 2 ? arguments[1] : void 0;

for (var i = 0; i < len; i++)
if (i in t)
	fun.call(thisArg, t[i], i, t);
};
}				
</script>

<script  src="plugins/booking/script.js"></script>

<script>
var level = document.location.search.replace(/\?/,'') || 0;
$('#nested').attr('href','frame.nested.html?'+(++level));		

var iFrameResizer = {
	messageCallback: function(message){
		alert(message,parentIFrame.getId());
	}
}
</script>

<script type="text/javascript">
	
/* If you've ever had the need to link directly to an open modal window with Bootstrap, here's a quick and easy way to do it:
Make sure your modal has an id:
<div class="modal" id="myModal" ... >
 */

$(document).ready(function() {

  if(window.location.href.indexOf('#sent-gift') != -1) {
    $('#sent-gift').modal('show');
  }

});

</script>

<script>
// Gifts - change image on click
	const change = src => { 
    document.getElementById('main').src = src 
}
</script>

<script>
(function($) {
jQuery.validator.addMethod("equals", function(value, element, param) {
	return this.optional(element) || value === param;
});

$(document).ready(function() {

var $form = $('form');
var submit = $('input[type="submit"]');
// alert(valid);

$form.slideform({
	validate: {
		rules: {
			group7: {
				required: true,
				equals: "valid"
			}
		},
		messages: {
			group7: {
				required: 'Please select an option',
				equals: 'You must select valid!'
			}
		}
	},
	submit: function(event, form) {
		alert(valid);

		if (valid) {
			$form.trigger('goForward');
		} else {
			event.preventDefault();
			alert('Please fill in all required fields correctly.');
		}
	}
});

var confirm = <?=$confirm?>;
const slides = document.getElementsByClassName('slideform-slide');
    const slidenb = slides.length;

// if(confirm){
// 	$form.trigger('goTo', [(slidenb-1)]); 

// }
var id = <?=$id?>;
var count=  0;
if(id){
	//$form.trigger('goTo', [id]);

 	
 			for (let index = 0; index <= id; index++) {
		
			$('.slideform-btn-next')[0].click();
		count++;
		//console.log($('.slideform-btn-next')[0]);
if (count == id) {
			break;
		}
		//alert('ok');
		
	}
}

let gotform = null;

gotform =  setInterval(()=>{
	if(typeof reachCent !== 'undefined')
{
	if(reachCent)
	{
		$('#last').show()
		//$form.trigger('goTo', [(slidenb-3)]);
		clearInterval(gotform);
	}
	else{
	$('#last').hide()
}
}
else{
	$('#last').hide()
}
},1000)
$form.removeAttr('novalidate');
});
}(jQuery))
</script>

<script>
$(function () {
// $("#txtDOB").datepicker({
// 	autoclose: true,
// 	todayHighlight: true,
// 	showAnim: 'slideDown',
// 	dateFormat: 'dd/mm/yyyy'
	
// })

$("#date").on('change', function () {
	
	var age = getAge(this);
	$('#lblAgeValue').text(age);
});
function getAge(dateVal) {
	var
		birthday = new Date(dateVal.value),
		today = new Date(),
		ageInMilliseconds = new Date(today - birthday),
		years = ageInMilliseconds / (24 * 60 * 60 * 1000 * 365.25),
		months = 12 * (years % 1),
		days = Math.floor(30 * (months % 1));
	return Math.floor(years) + ' years ' + Math.floor(months) + ' months ' + days + ' days';
}
});
</script>

<script>
// COUPON

//Copy
var cpnBtn = document.getElementById("cpnBtn");
var cpnCode = document.getElementById("cpnCode");

cpnBtn.onclick = function(){
	navigator.clipboard.writeText(cpnCode.innerHTML);
	cpnBtn.innerHTML ="COPIED";
	setTimeout(function(){
		cpnBtn.innerHTML="COPY CODE";
	}, 3000);
}

//Copy
var shareBtn = document.getElementById("shareBtn");
var shareCode = document.getElementById("shareCode");

shareBtn.onclick = function(){
	navigator.clipboard.writeText(shareCode.innerHTML);
	shareBtn.innerHTML ="SHARE FIRST!";
	setTimeout(function(){
		shareBtn.innerHTML="COPY CODE";
	}, 3000);
}


//Replace
function replace() {
document.getElementById("div1").style.display="none";
setTimeout( function(){
document.getElementById("div2").style.display="block";}, 10000); // 10 seconds
}

//Replace
function replace2() {
document.getElementById("div3").style.display="none";
setTimeout( function(){
document.getElementById("div4").style.display="block";}, 10000); // 10 seconds
}

//Replace
function replace3() {
document.getElementById("div5").style.display="none";
setTimeout( function(){
document.getElementById("div6").style.display="block";}, 10000); // 10 seconds
}

</script>

<script>
var count = 1;
//var query = 'frequency=common';
var query = 'with_surname=true&frequency=common';
if (count > 0) {
	query += '&count=' + count
};
$(document).ready(function() {
	var female = '&type=female';
	var male = '&type=male';


	var femaleNames = [];
	var maleNames = [];


	for (var i = 0; i < count; i++) {
		$(".females").append("<div class='female'></div>");
		$(".males").append("<div class='male'></div>");
	}

	$.ajax({
		url: "https://namey.muffinlabs.com/name.json?" + query + female,
		method: "GET",
		success: function(response) {
			femaleNames = response;

			if (maleNames.length == count) {
				$(".female").each(function(i) {
					$(this).text(femaleNames[i]);
				});
				$(".male").each(function(i) {
					$(this).text(maleNames[i]);
				});
			}
		}
	});

	$.ajax({
		url: "https://namey.muffinlabs.com/name.json?" + query + male,
		method: "GET",
		success: function(response) {
			maleNames = response;

			if (femaleNames.length == count) {
				$(".female").each(function(i) {
					$(this).text(femaleNames[i]);
				});
				$(".male").each(function(i) {
					$(this).text(maleNames[i]);
				});
			}
		}
	});
});
</script>

<script type="text/javascript">

function popupGallery(url)
{
var w = 1024;
var h = 768;
var title = 'Gallery';
var left = (screen.width / 2) - (w / 2);
var top = (screen.height / 2) - (h / 2);
window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}
	
</script>

</body>
</html>