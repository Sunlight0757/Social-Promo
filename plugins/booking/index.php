<?php
 $data = file_get_contents('../../db/services.json');
 $books = json_decode($data, true);

 ?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Booking Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,500,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="wrap">
  <div class="instructions">
    <div class="first">Select service</div>
  </div>
  <div class="staff">
    <?php foreach ($books as $key => $book) : ?>
      <?php foreach ($book['services'] as $ky => $service) : ?>
      <div class="member" value='<?=$ky?>'> 
      <div class="avatar" style="background-image: url(<?=$service['url']?>)"></div>
      <div class="name"><span class="service"><?=$service['name']?></span><span class="price"> - <?=$service['price']?></span></div>
      <div class="deselect-member">change</div>
        <?php if ($book['type'] != 'event') : ?>
      <div class="deselect-date">change</div>
      <div class="deselect-slot"> <div class=""></div>change</div>
        <?php endif;?>
      <div class="calendar"></div>
      <div class="slots flex-wrap">
           
       <!--  <div class="slots-container"> </div>-->
      </div>    
    </div>
    <?php endforeach;?>
<?php endforeach;?>
<form class="form" style="z-index: 2;">
        <!-- <label>Name</label>
        <input type="text" name="name" id='name' required="required"/>
        <label>Email</label>
        <input type="email" name="email"id='email' required="required"/>
        <label>Phone</label>
        <input type="text" name="phone"id='phone' required="required"/>
        <label>Profile link</label>
        <input type="text" name="profile_link"id='profile_link' required="required"/> !-->
        <input type="submit" class="submit" value="Confirm Booking"/>
      <div class="confirm-message">Booking Complete!<span class="restart">Book Again?</span></div>
      </form>
    <!--
    <div class="member"> 
      <div class="avatar" style="background-image: url(https://randomuser.me/api/portraits/women/<?php $min=1; $max=100; echo rand($min,$max);?>.jpg)"></div>
      <div class="name">Service 2</div>
      <div class="deselect-member">change</div>
      <div class="deselect-date">change</div>
      <div class="deselect-slot">change</div>
      <div class="calendar"></div>
      <ul class="slots"></ul>
      <form class="form">
        <label>Name</label>
        <input type="text" name="name" required="required"/>
        <label>Email</label>
        <input type="email" name="email" required="required"/>
        <label>Phone</label>
        <input type="text" name="phone" required="required"/>
        <input type="submit" value="Confirm Booking"/>
      </form>
      <div class="confirm-message">Booking Complete!<span class="restart">Book Again?</span></div>
    </div>
    <div class="member"> 
      <div class="avatar" style="background-image: url(https://randomuser.me/api/portraits/women/<?php $min=1; $max=100; echo rand($min,$max);?>.jpg)"></div>
      <div class="name">Service 3</div>
      <div class="deselect-member">change</div>
      <div class="deselect-date">change</div>
      <div class="deselect-slot">change</div>
      <div class="calendar"></div>
      <ul class="slots"></ul>
      <form class="form">
        <label>Name</label>
        <input type="text" name="name" required="required"/>
        <label>Email</label>
        <input type="email" name="email" required="required"/>
        <label>Phone</label>
        <input type="text" name="phone" required="required"/>
        <input type="submit" value="Confirm Booking"/>
      </form>
      <div class="confirm-message">Booking Complete!<span class="restart">Book Again?</span></div>
    </div>
    <div class="member"> 
      <div class="avatar" style="background-image: url(https://randomuser.me/api/portraits/women/<?php $min=1; $max=100; echo rand($min,$max);?>.jpg)"></div>
      <div class="name">Service 4</div>
      <div class="deselect-member">change</div>
      <div class="deselect-date">change</div>
      <div class="deselect-slot">change</div>
      <div class="calendar"></div>
      <ul class="slots"></ul>
      <form class="form">
        <label>Name</label>
        <input type="text" name="name" required="required"/>
        <label>Email</label>
        <input type="email" name="email" required="required"/>
        <label>Phone</label>
        <input type="text" name="phone" required="required"/>
        <input type="submit" value="Confirm Booking"/>
      </form>
      <div class="confirm-message">Booking Complete!<span class="restart">Book Again?</span></div>
    </div>
  </div>
    -->
</div>
<!-- partial -->
<script>
  
  var bookingdata = <?=$data?>;

</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script  src="./script.js"></script>
  
<script type="text/javascript" src="https://socialpromo.biz/src/js/iframeResizer.contentWindow.min.js" defer></script>

<script>
var level = document.location.search.replace(/\?/,'') || 0;
$('#nested').attr('href','frame.nested.html?'+(++level));		

var iFrameResizer = {
	messageCallback: function(message){
		alert(message,parentIFrame.getId());
	}
}
</script>

</body>
</html>
