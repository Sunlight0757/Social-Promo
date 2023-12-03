<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Auto Watermark mockup</title>

  <!-- Theme style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Material+Icons" rel="stylesheet">

<style>
	
.select-dropdown {
  display: inline-block;
  position: relative;
  color: #53565a;
  background-color: white;
  border-radius: 4px;
}
.select-dropdown * {
  -webkit-touch-callout: none;
  /* iOS Safari */
  -webkit-user-select: none;
  /* Safari */
  -khtml-user-select: none;
  /* Konqueror HTML */
  -moz-user-select: none;
  /* Firefox */
  -ms-user-select: none;
  /* Internet Explorer/Edge */
  user-select: none;
}
.select-dropdown.is-active input[type=text] {
  border-color: #00aeef;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}
.select-dropdown.is-active i {
  top: 6px;
  transform: rotate(180deg);
  color: #00aeef;
}
.select-dropdown.is-active ul {
  display: block;
}
.select-dropdown #js-ddInput {
  position: relative;
  z-index: 1;
  color: #53565a;
  border-radius: 4px;
  border: 1px solid #c4d2e1;
  outline: none !important;
  padding: 10px 12px;
  padding-right: 30px;
  font-size: 13px;
  text-overflow: ellipsis;
  background: transparent;
  cursor: pointer;
  user-select: none !important;
}
.select-dropdown i {
  position: absolute;
  top: 6.5px;
  right: 5px;
}
.select-dropdown ul {
  display: none;
  position: absolute;
  z-index: 999;
  background: white;
  width: calc(100% - 2px);
  list-style-type: none;
  border: 1px solid #b1babf;
  border-top: 0;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 4px;
  padding: 0;
  margin: 0;
}
.select-dropdown ul li {
  cursor: pointer;
  padding: 10px 14px;
  font-size: 13px;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.select-dropdown ul li:hover {
  background-color: #effbff;
}
.select-dropdown ul li * {
  pointer-events: none;
}

body .modal-dialog { /* Width */
    max-width: 100%;
    width: auto !important;
    display: inline-block;
}

body .modal-dialog { /* Width */
    max-width: 100%;
    width: auto !important;
    display: inline-block;
}

.modal {
  z-index: -1;
  display: flex !important;
  justify-content: center;
  align-items: center;
}

.modal.show {
   z-index: 1050;
}
</style>

</head>

<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Auto</b>Watermark</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Add watermark logo to image</p>

      <form action="#" method="post">
	  
		<div class="form-group">
		<label>1.Select logo</label>

<div class="select-dropdown">
	<div id="js-ddInput"><img class="img-fluid" src="https://hostessjobs.uk/images/logo.png" /></div>
	<i class="material-icons">keyboard_arrow_down</i>
	<ul>
		<li class="select-dropdown__item"><img class="img-fluid" src="https://hostessjobs.uk/images/logo_dark.png" /></li>
	</ul>
</div>

        </div>
	 
		<div class="form-group">
		<label>2. Select position</label>
		<select class="form-control" name="position" id="position">
		  <option value="TOP_RIGHT">Top right</option>
		  <option value="TOP_LEFT">Top left</option>
		  <option value="BOTTOM_RIGHT">Bottom right</option>
		  <option value="BOTTOM_LEFT">Bottom left</option>
		</select>
	  </div> 
	  
		<div class="form-group">
		<label>3. Enter image URL</label>
		<input type="text" class="form-control" placeholder="Image URL" id="image_url">
	  </div> 
    <button class="btn btn-block btn-primary generateWatermark" type="button">SUBMIT</button>
    <br>
    <div id="resultWrap">
      <img src="" id="resultImg" height="200" width="320"/>
      <input type="hidden" id="watermarkImage" value=""/>
      <br>
      <button class="btn btn-block btn-primary updateImageUrl" type="button">Update</button>
    </div>
      </form>
    
      

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<!-- REQUIRED SCRIPTS -->

<script>

// selector for select-dropdown list

const selectDropdown = document.querySelector('.select-dropdown'); 
var outPutWrap = document.getElementById("resultWrap"),
outPutWrapVisible = true;
outPutWrap.style.cssText = "-webkit-transition: 0.5s;display:none";


function toggleSideNav() {
  if (outPutWrapVisible) {
    outPutWrap.style.cssText = "-webkit-transition: 0.5s;display:block";
  } else {
    outPutWrap.style.cssText = "-webkit-transition: 0.5s;display:none";
  }
  outPutWrapVisible = !outPutWrapVisible;
}
document.addEventListener( 'click', function(e) {
	if (e.target.matches('.select-dropdown__item')) {
		selectDropdown
			.querySelector('#js-ddInput')
			.innerHTML = e.target.innerHTML;
	}
});

// remove all active classes on the other select-dropdowns

selectDropdown.addEventListener('click', function(e) {
	if (selectDropdown !== e.target) {
			e.target.classList.remove("is-active");
	}
	selectDropdown.classList.toggle("is-active");
});



// this event is to close all open select-options when the user clicks off.

document.body.addEventListener('click', function(e) {
	if(!e.target.closest('.select-dropdown')) {
		selectDropdown.classList.remove("is-active");
	}
});

document.addEventListener( 'click',function(e) {
  if (e.target.matches('.updateImageUrl')) {
    document.querySelector('#image_url').value = document.querySelector('#watermarkImage').value;
    toggleSideNav();
  }
});

document.addEventListener( 'click',function(e) {
  if (e.target.matches('.generateWatermark')) {
    var logoImage = document.querySelector('#js-ddInput img.img-fluid').src;
    var position = document.querySelector('#position').value;
    var image_url = document.querySelector('#image_url').value;

    var watermarkSrc = "watermark.php?image="+image_url+"&watermark="+logoImage+"&is_ready=true&place="+position;

    // Creating Our XMLHttpRequest object 
    let xhr = new XMLHttpRequest();
    
    // Making our connection  
    let url = watermarkSrc;
    xhr.open("GET", url, true);
 
    // function execute after request is successful 
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText){
              document.querySelector('#resultImg').src = this.responseText;
              document.querySelector('#watermarkImage').value = this.responseText;
              toggleSideNav();
            }
        }
    }
    // Sending our request 
    xhr.send();
    
    //document.querySelector('#resultImg').src = watermarkSrc;
  }
});

</script>
</body>
</html>
