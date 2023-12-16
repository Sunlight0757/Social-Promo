<!DOCTYPE html>
<?php require 'config.php'; ?>
<?php
  $linkdata = file_get_contents(adminClientLinksFile);
  $clientlinks = json_decode($linkdata, true);
?>
<?php
	/// WEBSITE
	$websiteURL = 'https://socialpromo.biz';

// Current domain
$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$current_group = "";

  $linkFound = false;
  foreach ($clientlinks as $link) {
      if (str_replace("\\", "", $link['link']) === $current_url) {
          $current_group = $link['group'];
          $dataID = str_split($link['key']);
          $linkFound = true;
          break;
      }
  }

  if (!$linkFound) {
      header('Location: ' . $websiteURL);
      exit();
  }
?>
<?php
// Get Search Data
$search_data = getSearchData();

$groups = [];
$data = file_get_contents(adminTemplatesFile);

$data =json_decode($data,true);


	foreach ($data as $key => $value) {
   // array_push($groups,$value['group']);
    if (!in_array($value['group'], $groups) and $value['group'] != '') {
      array_push($groups, $value['group']);
		
	}
	}
  $quest = file_get_contents(adminQuestionsFile);
  $quest =json_decode($quest,true);
  $nbq = count($quest);
?>

<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="src/fonts/fontawesome/css/all.min.css">
<!-- Watermark -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Material+Icons" rel="stylesheet">
<!-- iCheck -->
<link rel="stylesheet" href="src/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="src/plugins/select2/css/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="src/plugins/dist/css/adminlte.min.css">
<!-- summernote -->
<link rel="stylesheet" href="src/plugins/summernote/summernote-bs4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="src/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Social -->
<link rel="stylesheet" href="src/css/social-buttons.css">
<link rel="stylesheet" href="src/css/social-colors.css">
<!-- Grid -->
<link rel="stylesheet" href="src/css/grid.css">
<!-- Booking -->
<link rel="stylesheet" href="plugins/booking/hours/css/scheduler.css">

<style>
.container {
 max-width: 100% !important;
}

.btn-social.btn-lg :first-child {
    line-height: 45px;
}

.loader-parent{
  position: fixed;
  inset: 0;
  z-index: 1111;
  display: none;
  justify-content: center;
  align-items: center;
}

/**************************************** WATERMARK ****************************************/

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

/**************************************** GALLERY ****************************************/

.direct-chat-messages {
    height: 500px;
}

</style>

</head>

<script>
const domain = '<?=domain?>';
const nbquestion = <?=$nbq?>;
const search_data = <?=json_encode($search_data)?>;
const current_group = '<?=$current_group?>';
const dataID = <?=json_encode($dataID)?>;
</script>

<body class="hold-transition layout-top-nav">

<div class="wrapper">
	
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="https://socialpromo.biz/images/favicon/icon_100px.png" alt="Logo" height="100" width="100">
  </div>
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white pt-0 pb-0">
    <div class="container">
      <a href="https://socialpromo.biz" class="navbar-brand">
		<img style="background-image: linear-gradient(45deg, #21a56e 0%, #9adc5f 100%); padding:10px;border-radius:10px" alt="Social Promo Logo" height="50px" src="https://socialpromo.biz/images/logo.png">
      </a>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Menu</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="https://socialpromo.biz" target="_blank" class="dropdown-item">Management</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="https://socialpromo.biz" target="_blank" class="dropdown-item">Marketing</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="https://socialpromo.biz" target="_blank" class="dropdown-item">Messaging</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="https://socialpromo.biz/dashboard" target="_blank" class="dropdown-item">Monitoring</a></li>
              <li class="dropdown-divider"></li>
              <li><a href="https://socialpromo.biz/api" target="_blank" class="dropdown-item">API</a></li>
            </ul>
          </li>		
	
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-envelope"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="https://suite.social/contact_e.php" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> Email us
              <span class="float-right text-muted text-sm">1-3 days reply</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="https://suite.social/contact_w.php" class="dropdown-item">
              <i class="fab fa-whatsapp mr-2"></i> WhatsApp us
              <span class="float-right text-muted text-sm">1-2 days reply</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="https://suite.social/contact_p.php" class="dropdown-item">
              <i class="fas fa-phone mr-2"></i> Phone us
              <span class="float-right text-muted text-sm">Instant reply</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="https://suite.social/contact_w.php" class="dropdown-item">
              <i class="fas fa-mobile mr-2"></i> Text us
              <span class="float-right text-muted text-sm">1-2 days reply</span>
            </a>		
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-2">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
	  
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number" id="template_pending_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-square-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Approved</span>
                <span class="info-box-number" id="template_approved_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-thumbs-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                <span class="info-box-number" id="template_rejected_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

	  <div class="row">
		<div class="col-lg-12"><!-- /.col-lg-12 -->
		
            <div class="card card-info">
			
			<div class="card-header">
			  <h3 class="card-title">All templates</h3>
			</div>
			<!-- /.card-header -->
				 
				 <div class="card-body p-0">
				 
			<div class="table-responsive">				 				 
                 <table id="example1" class="table table-bordered table-striped">
                  <thead id="templateth">
                  <tr>
                  <th><input type="checkbox" id="alltemplate" name="delete-all" value="template" id="" title="select all"></th>
                    <th>No</th>
					<th>Image</th>
					<th>Link</th>
                    <th>Title</th>
                    <th>Content</th>					
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody id="templateBody">			  
                  </tbody>
                  <tfoot>
                  <tr> 
                    <th> </th>
                    <th>No</th>
					<th>Image</th>
					<th>Link</th>
                    <th>Title</th>
                    <th>Content</th>					
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>			  
			</div>				 

			</div><!-- /.card-body -->
		
            </div><!-- /.card -->

		</div><!-- /.col-md-12 -->
	  </div><!-- /.row -->  

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
	
<!--================================================================================ MODELS ================================================================================-->
	
<!-------------- POST -------------->

	<div class="modal fade" id="post">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Share post</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">


<a href="https://www.facebook.com/share.php?u={TITLE}" id="fb" class="btn-lg btn-block btn-social btn-facebook">
	<i class="fab fa-facebook fa-2x"></i> Facebook Post
</a>

<a href="https://www.blogger.com/blog-this.g?u={LINK}&n={TITLE}&t={LINK}" id="blogger" class="btn-lg btn-block btn-social btn-blogger">
	<i class="fab fa-blogger fa-2x"></i> Blogger Post
</a>

<a href="https://www.linkedin.com/sharing/share-offsite/?url={LINK}" id="insta" class="btn-lg btn-block btn-social btn-instagram">
	<i class="fab fa-instagram fa-2x"></i> Instagram Post
</a>

<a href="https://www.linkedin.com/sharing/share-offsite/?url={LINK}" id="linkedin" class="btn-lg btn-block btn-social btn-linkedin">
	<i class="fab fa-linkedin fa-2x"></i> Linkedin Post
</a>

<a href="https://www.facebook.com/dialog/send?link={LINK}&app_id=291494419107518&redirect_uri={LINK}" id="messenger" class="btn-lg btn-block btn-social btn-messenger">
	<i class="fab fa-facebook-messenger fa-2x"></i> Messenger Post
</a>

<a href="http://pinterest.com/pin/create/button/?url={LINK}&media={IMAGE}&description={TITLE}" id="pinterest" class="btn-lg btn-block btn-social btn-pinterest">
	<i class="fab fa-pinterest fa-2x"></i> Pinterest Post
</a>

<a href="https://reddit.com/submit?url={LINK}" id="reddit" class="btn-lg btn-block btn-social btn-reddit">
	<i class="fab fa-reddit fa-2x"></i> Reddit Post
</a>

<a href="https://t.me/share/url?url={LINK}&text={TITLE}-%20{LINK}" id="telegram" class="btn-lg btn-block btn-social btn-telegram">
	<i class="fab fa-telegram fa-2x"></i> Telegram Post
</a>

<a href="https://twitter.com/share?text={LINK}-%20{TITLE}" id="twitter" class="btn-lg btn-block btn-social btn-twitter">
	<i class="fab fa-twitter fa-2x"></i> Twitter Post
</a>

<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl={URL}&title={TITLE}&caption={LINK}" id="tumblr" class="btn-lg btn-block btn-social btn-tumblr">
	<i class="fab fa-tumblr fa-2x"></i> Tumblr Post
</a>


<a href="https://api.whatsapp.com/send?text={URL}" id="whatsapp" class="btn-lg btn-block btn-social btn-whatsapp">
	<i class="fab fa-whatsapp fa-2x"></i> WhatsApp Post
</a>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" id="editsubmit" class="btn btn-primary ">Save changes
			  <span id="spinner" class="spinner-border text-light" style="width: 20px; height: 20px; display: none;" ; role="status">
			  </span>
			</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

<!-------------- TEMPLATE -------------->

<div class="modal fade" id="edit-template">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit template</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form>
			
                  <div class="form-group">
                    <label for="InputGroup">Group</label>
				    <input id="editTemplateGroup" type="text" name="group" class="form-control form-control-lg" placeholder="Enter group">
                  </div>
                  <div class="form-group">
                    <label for="InputImage">Image</label>
				    <p><input id="editTemplateImage" type="url" name="image" class="form-control form-control-lg" placeholder="Enter image"></p>
					
					<p>
					<a href="#watermark" data-toggle="collapse" class="btn btn-success"><i class="fas fa-image"></i> WATERMARK IMAGE</a>
					<a href="#gallery2" data-toggle="collapse" class="btn btn-primary"><i class="fas fa-images"></i> FIND IMAGE</a>
					</p>

					<div id="watermark" class="collapse">
	  
		<div class="form-group">
		<p><label>1.Select logo</label></p>

<p>
<div class="select-dropdown">
	<div id="js-ddInput"><img class="img-fluid" src="https://hostessjobs.uk/images/logo.png" /></div>
	<i class="material-icons">keyboard_arrow_down</i>
	<ul>
		<li class="select-dropdown__item"><img class="img-fluid" src="https://hostessjobs.uk/images/logo_dark.png" /></li>
	</ul>
</div>
</p>

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
    <button class="btn btn-block btn-primary generateWatermark" type="button">SUBMIT</button>
    <br>
    <div id="resultWrap">
      <p><img src="" id="resultImg" height="200" width="320"/></p>
      <input type="hidden" id="watermarkImage" value=""/>
      <p><button class="btn btn-lg btn-success updateImageUrl" type="button">Update Image</button></p>
    </div>
					</div>	
					
					<div id="gallery2" class="collapse">
					
			<div class="card direct-chat direct-chat-primary">
              <div class="card-body"> 
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" style="overflow:hidden">

                <p><iframe src="plugins/gallery/" style="border: 0" width="100%" height="550px" scrolling="auto" frameborder="0">Your browser does not support iFrame</iframe></p>

                </div>
                <!--/.direct-chat-messages-->
				
              </div>
              <!-- /.card-body -->
            </div>

					</div>
					
                  </div>
                  <div class="form-group">
                    <label for="editTemplateLink">URL</label>
				    <input id="editTemplateLink" type="url" name="url" class="form-control form-control-lg" placeholder="Enter URL">
                  </div>
                  <div class="form-group">
                    <label for="InputTitle">Title</label>
				    <input id="editTemplateTitle" type="text" name="title" class="form-control form-control-lg" placeholder="Enter title">
                  </div>				
                  <div class="form-group">
                    <label for="InputContent">Content</label>					
					<textarea id="editTemplateContent" class="form-control form-control-lg" rows="3" placeholder="Enter query"></textarea>
                </div>
                <!-- /.card-body -->
              </form>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="btnEditTemp">Save changes</button>
			  <!--<button type="button" class="btn btn-primary" id="btnEditBooking"></button>-->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal --> 

 
    </div>
  <!-- /.content -->
  
 
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
	Version 2.0
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2023.</strong> All rights reserved.
</footer>
<div class="loader-parent">
  <img src="<?php echo domain . 'src/img/loader.svg'; ?>" alt="Loader">
</div>
</div>
<!-- ./wrapper -->
	
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="src/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="src/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="src/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap Switch -->
<script src="src/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="src/plugins/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="src/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="src/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="src/plugins/dist/js/pages/dashboard.js"></script>
<!-- Grid -->
<script  src="src/js/grid.js"></script>
<script  src="src/js/actions.js"></script>
<script  src="src/js/secret.js"></script>
<!-- Sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

<script>
let templatests= <?=(templatestatus)?>;
let datafile = "<?=datafile?>";
</script>

<script src="src/js/admin.js"></script>

<!-- Make sure to include jQuery as shown above -->

<script>
	
// WATERMARK

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
    document.querySelector('#editTemplateImage').value = document.querySelector('#watermarkImage').value;
    toggleSideNav();
  }
});

document.addEventListener( 'click',function(e) {
  if (e.target.matches('.generateWatermark')) {
    var logoImage = document.querySelector('#js-ddInput img.img-fluid').src;
    var position = document.querySelector('#position').value;
    var image_url = document.querySelector('#editTemplateImage').value;

    var watermarkSrc = "plugins/watermark/watermark.php?image="+image_url+"&watermark="+logoImage+"&is_ready=true&place="+position;

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

<script>
  // Function to handle messages received from the iframe
  function handleMessage(event) {
    // Check data for security
    if (typeof event.data !== 'string') return;

    // Assuming the data passed is a value to update
    const valueToUpdate = event.data;

    // Update the value outside the iframe
    document.getElementById('templateImage').value = valueToUpdate;
    document.getElementById('editTemplateImage').value = valueToUpdate;
  }

  // Event listener for messages sent from the iframe
  window.addEventListener('message', handleMessage);
</script>

</body>
</html>
