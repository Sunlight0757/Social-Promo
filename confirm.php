<!DOCTYPE html>
<html lang="en">

<?php
require 'config.php';
$userdata = null;
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

}
$jsonData = $userdata;
$questionsdata = file_get_contents('db/questions_bookings.json');
$questionS=json_decode($questionsdata,true);


if($jsonData){
$id = $jsonData['id'];
$fullName = $jsonData['fullName'];
$website = $jsonData['website'];
$number = $jsonData['number'];
$email = $jsonData['email'];
$date = $jsonData['date'];
$statut = $jsonData['statut'];
$questions = $jsonData['question'];}
?>

<head>
	
<!-- Title -->
<title>Social Promo - All-in-one Rewards, Booking, Referrals & Marketing Platform.</title>

<!-- Meta Data -->
<meta charset="utf-8">
<meta name="title" content="Social Promo - All-in-one Rewards, Booking, Referrals & Marketing Platform.">
<meta name="description" content="Triple your traffic, leads & referrals while you focus on running your business and serving customers">
<meta name="author" content="SocialPromo | https://socialpromo.biz">
<meta name="keywords" content="Amazon Promotion, Blog Promotion, Etsy Promotion, Facebook Promotion, Instagram Promotion, Linkedin Promotion, Pinterest Promotion, Reddit Promotion, Snapchat Promotion, Social Media Promotion, Social Media Marketing, Soundcloud Promotion, TikTok Promotion, Tumblr Promotion, Twitter Promotion, Vimeo Promotion, Vk Promotion, WhatsApp Promotion, Wordpress Promotion, XING Promotion, YouTube Promotion, Email Marketing, SMS Marketing, WhatsApp Marketing, Push Notifications, Birthday Promotions, Holiday Promotions, Weather Promotions, Location Marketing, Kiosk Promotion, Social Screen, Social Wall, Reward Card">
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="language" content="English">
<meta name="revisit-after" content="7 days">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />	

<!-- Google -->
<!-- Update your html tag to include the itemscope and itemtype attributes. -->
<!-- html itemscope itemtype="//schema.org/{CONTENT_TYPE}" -->
<meta itemprop="name" content="Social Promo - All-in-one Rewards, Booking, Referrals & Marketing Platform.">
<meta itemprop="description" content="Triple your traffic, leads & referrals while you focus on running your business and serving customers">
<meta itemprop="image" content="https://socialpromo.biz/images/meta.jpg">

<!-- Twitter -->
<meta name="twitter:card" content="https://socialpromo.biz/images/meta.jpg"> <!-- to have large image post format in Twitter -->
<meta name="twitter:site" content="@socialsuite">
<meta name="twitter:title" content="Social Promo - All-in-one Rewards, Booking, Referrals & Marketing Platform.">
<meta name="twitter:description" content="Triple your traffic, leads & referrals while you focus on running your business and serving customers">
<meta name="twitter:creator" content="@socialsuite">
<meta name="twitter:image:src" content="https://socialpromo.biz/images/meta.jpg">

<!-- OG Meta Tags to improve the way the post looks when you share the page on Facebook, Twitter, LinkedIn -->
<meta property="og:site_name" content="Social Promo" /> <!-- website name -->
<meta property="og:site" content="https://socialpromo.biz" /> <!-- website link -->
<meta property="og:title" content="Social Promo - All-in-one Rewards, Booking, Referrals & Marketing Platform."/> <!-- title shown in the actual shared post -->
<meta property="og:description" content="Save time, money and resources and GROW traffic, customers & sales 24-7, 365 days a year!" /> <!-- description shown in the actual shared post -->
<meta property="og:image" content="https://socialpromo.biz/images/meta.jpg" /> <!-- image link, make sure it's jpg -->
<meta property="og:url" content="https://socialpromo.biz" /> <!-- where do you want your post to link to -->
<meta property="og:type" content="product">
<meta property="og:locale" content="en_UK">
<meta property="fb:app_id" content="291494419107518" />

<!-- Open Graph Article (Facebook & Pinterest) -->
<meta property="article:section" content="Marketing">
<meta property="article:tag" content="Marketing">		

<!-- Mobile Specific Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" />
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />	
<meta name="HandheldFriendly" content="true" />

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="https://socialpromo.biz/images/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="https://socialpromo.biz/images/favicon/icon_32px.png">
<link rel="icon" type="image/png" sizes="16x16" href="https://socialpromo.biz/images/favicon/icon_16px.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://socialpromo.biz/images/favicon/apple-touch-icon_180px.png">
<link rel="apple-touch-icon" sizes="72x72" href="https://socialpromo.biz/images/favicon/apple-touch-icon_72px.png">
<link rel="apple-touch-icon" sizes="114x114" href="https://socialpromo.biz/images/favicon/apple-touch-icon_114px.png">
<link rel="apple-touch-icon" sizes="144x144" href="https://socialpromo.biz/images/favicon/apple-touch-icon_144px.png">
<link rel="apple-touch-icon" sizes="256x256" href="https://socialpromo.biz/images/favicon/apple-touch-icon_256px.png" />
<meta name="msapplication-TileImage" content="https://socialpromo.biz/images/favicon/mstile_150px.png">

<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Theme style -->
<link rel="stylesheet" href="src/plugins/dist/css/adminlte.min.css">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-P9Z3B2EPNB"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-P9Z3B2EPNB');
</script>

<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "he81yhlb93");
</script>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <p class="text-center"><a href="https://socialpromo.biz"><img style="background-image: linear-gradient(45deg, #21a56e 0%, #9adc5f 100%); padding:10px;border-radius:10px" class="img-fluid" width="219px" src="https://socialpromo.biz/images/logo.png"></a></p>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">
          <!-- /.col-md-6 -->
          <div class="col-lg-7">
            <div class="card card-dark">
              <div class="card-body">
			  
<?php if (isset($_GET['index']) and $jsonData):?>
<p>Hi <?=$fullName?>,</p>

<p>Thanks for your submission, review your answers below, if any are incorrect, please re-take the form.</p>

<b>Your Website/Profile:</b><br>
<?=$website?><br><br>

<b>Your Mobile Number:</b><br>
<?=$number?><br><br>

<?php foreach ($questions as $key => $questionvalue):?> 
<b><span style="color:#00b878"><?=($key+1)?> ) </span><?=$questionS[$key]['question']?></b><br>

<p><?php foreach ($questionvalue['answers'] as $keya => $answer) :?></p>

<?=$answer?>
<?php endforeach ;?>

<?=$questionvalue['comment']?><br><br>

<?php endforeach ;?> 
<!--Last updated file-->

<a class="btn btn-block btn-danger btn-lg" href="<?=domain?>?index=<?=$id?>&id=<?=confirmSlide?>">Confirm answers</a>

<hr>
<?php endif;?>

<p><b>We will send you new offers and reminders.</b>

<p>Best regards,</p>

<p>Social Promo</p>

              </div>
            </div>
			
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid --> 
	  
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="src/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="src/plugins/dist/js/adminlte.min.js"></script>

</body>
</html>
