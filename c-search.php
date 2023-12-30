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

.loader-parent{
  position: fixed;
  inset: 0;
  z-index: 1111;
  display: none;
  justify-content: center;
  align-items: center;
}
</style>

</head>

<script>
const domain = '<?=domain?>';
const nbquestion = <?=$nbq?>;
var search_data = <?=json_encode($search_data)?>;
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
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fa-solid fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending</span>
                <span class="info-box-number" id="search_pending_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fa-solid fa-triangle-exclamation"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Contacted</span>
                <span class="info-box-number" id="search_contacted_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-fire"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Replied</span>
                <span class="info-box-number" id="search_replied_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                <span class="info-box-number" id="search_rejected_stat"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

	  <div class="row">
		<!-- /.col-md-12 -->
		<div class="col-lg-12">
		  <div class="card card-info">
			<div class="card-header">
			  <h3 class="card-title mt-1">Social Leads</h3>
		  <form class="float-right" action="">
			<input type="text" placeholder="Start typing..." name="keyword" id="keyword2" oninput="search2(this.value)">
			<button class="btn-dark">Search</button>
		  </form>			  
			</div>
			<!-- /.card-header -->
              <div class="card-body">		  
			
			<div class="card-footer p-0 mb-3">
                <ul class="nav nav-pills flex-column search-params-list">
                  <?php 
                  $search_params = getSearchParams();
                  if(!empty($search_params)){
                    foreach ($search_params as $search_param) {
                      $search_param_id = $search_param['id'];
                      $search_url = $search_param['search_url'];
                      $search_category = isset($search_param['category'])?$search_param['category']:"";
                      $search_type = isset($search_param['type'])?$search_param['type']:"";
                      $search_network = isset($search_param['network'])?$search_param['network']:"";
                      $search_keyword = isset($search_param['keyword'])?$search_param['keyword']:"";
                      if($search_category==$current_group) {
                  ?>
                      <li class="nav-item" data-searchParamId="<?php echo $search_param_id; ?>">
                          <a href="#" class="nav-link">
                            <?php echo $search_keyword=="" ? "{$search_url}" : "{$search_keyword} ({$search_type}, {$search_network})"; ?>
                            <span onclick="deleteSearchParam(event)" class="float-right btn btn-sm btn-danger btn-flat">Delete</span>
                          </a>
                    </li>
                      <?php
                        }
                          }
                        }
                      ?>
                    
                </ul>
              </div>

              <div class="overflow-auto w-100">
                <table class="table table-bordered table-hover search-data-table">
                  <thead id="searchth">
                    <tr>
                      <th>#</th>
					  <th>Picture</th>
                      <th>Title</th>
                      <th>Settings</th>
                      <th>Date</th>
                      <th>Status</th>
					  <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="data-table">
                  </tbody>
                </table>
                <div id="modal-switch" tabindex="-1" role="dialog" aria-labelledby="modal-switch-label" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST" id="select_template_form">
                        <input type="hidden" id="post_id" />
                        <div class="modal-header">
                          <div id="modal-switch-label" class="modal-title">Template</div>
                          <button type="button" data-dismiss="modal" class="close">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <select class="form-control select2" style="width: 100%;" id="template_group" name="template_group">
                            <?php foreach ($groups as $key => $group):?>
                              <option value="<?=$group?>"><?=$group?></option>
                            <?php endforeach;?> 
                          </select>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="select_template_btn">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                  </div>
              </div>
		  </div>
		  <!-- /.card -->

		</div>
		<!-- /.col-md-12 -->
	  </div>
	  <!-- /.row -->	  

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
	
<!--================================================================================ MODELS ================================================================================-->
  
<!-------------- SOCIAL -------------->

	<div class="modal fade" id="edit-social">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Edit Search</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
      <form method="POST" class="search-url-modal">
        ``<div class="modal-body">

          <div class="card-body">
          <div class="form-group">
            <label for="search-url-picture">Picture</label>
            <input id="search-url-picture" type="url" name="search-url-picture" class="form-control form-control-lg form-control-border" placeholder="Enter picture URL" value="">
          </div>
          <div class="form-group">
            <label for="search-url-title">Title</label>
            <input id="search-url-title" type="text" name="search-url-title" class="form-control form-control-lg form-control-border" placeholder="Enter title" value="">
          </div>
          <div class="form-group">
            <label for="search-url-contact">Contact</label>
            <input id="search-url-contact" type="url" name="search-url-contact" class="form-control form-control-lg form-control-border" placeholder="Enter contact link" value="">
          </div>
          <div class="form-group">
            <label for="search-url-description">Description</label>
            <textarea id="search-url-description" name="search-url-description" class="form-control form-control-lg form-control-border" rows="4" placeholder="Enter note">Enter any description</textarea>
          </div>
          <div class="form-group">
            <label for="search-url-notes">Notes</label>
            <textarea id="search-url-notes" name="search-url-notes" class="form-control form-control-lg form-control-border" rows="4" placeholder="Enter note">Enter any note</textarea>
          </div>
                  <!-- /.form-group -->															
          </div>
          <!-- /.card-body -->
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" id="closeSocialmodal" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="submitSearchEditForm()" class="btn btn-primary ">Save changes
          <span id="spinner" class="spinner-border text-light" style="width: 20px; height: 20px; display: none;" ; role="status">
          </span>
        </button>
        </div>
      </form>
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
$(function () {
  // Summernote
  $('#InputNote').summernote()
})

$(function () {
//Initialize Select2 Elements
$('.select2').select2()
})

function popupSocial(url)
{
var absoluteURL = new URL(url).href;
var w = 1024;
var h = 768;
var title = 'Social';
var left = (screen.width / 2) - (w / 2);
var top = (screen.height / 2) - (h / 2);
window.open(absoluteURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

let searchsts= <?=(searchstatus)?>;
let datafile = "<?=datafile?>";
</script>

<script src="src/js/admin.js"></script>
</body>
</html>
