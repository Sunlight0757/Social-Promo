<!DOCTYPE html>
<?php require 'config.php'; ?>
<?php
  $linkdata = file_get_contents('db/clientlinks.json');
  $clientlinks = json_decode($linkdata, true);
?>
<?php

  // Current domain
  $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $linkFound = false;
  foreach ($clientlinks as $link) {
      if (str_replace("\\", "", $link['link']) === $current_url) {
          $linkFound = true;
          break;
      }
  }

  if (!$linkFound) {
      header('Location: ' . domain);
      exit();
  }
?>
<?php
// Get Search Data
$search_data = getSearchData();

$groups = [];
$data = file_get_contents('db/templates.json');

$data =json_decode($data,true);


	foreach ($data as $key => $value) {
   // array_push($groups,$value['group']);
    if (!in_array($value['group'], $groups) and $value['group'] != '') {
      array_push($groups, $value['group']);
		
	}
	}
  $quest = file_get_contents('db/questions.json');
  $quest =json_decode($quest,true);
  $nbq = count($quest);


  $bookingdata = file_get_contents('db/services.json');
  $books = json_decode($bookingdata, true);

  $categorydata = file_get_contents('db/search_categories.json');
  $categories = json_decode($categorydata, true);

  $dataID = $_GET['id'];
?>

<?php
	
	/// WEBSITE
	$websiteURL = 'https://socialpromo.biz';

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
.badge {
  font-size: 100%;
}
.container {
 max-width: 100% !important;
}

table.dataTable td {
  word-break: break-word;
}
.weekDays-selector input {
  display: none!important;
}

.weekDays-selector input[type=checkbox] + label {
  display: inline-block;
  border-radius: 6px;
  background: #dddddd;
  height: 40px;
  width: 30px;
  margin-right: 3px;
  line-height: 40px;
  text-align: center;
  cursor: pointer;
}

.weekDays-selector input[type=checkbox]:checked + label {
  background: #dc3545;
  color: #ffffff;
}

.widget-user-2 .widget-user-desc, .widget-user-2 .widget-user-username {
    margin-left: auto;
}

.btn-social.btn-lg :first-child {
    line-height: 45px;
}

.nav-tabs {
    border-bottom: 0px solid #dee2e6;
}

.description-image{
  width: 50px;
}

.loader-parent{
  position: fixed;
  inset: 0;
  z-index: 1111;
  display: none;
  justify-content: center;
  align-items: center;
}

h5.search-url-table-notes-label{
  padding: 0 0.75rem;
}

/**************************************** CAROUSEL ****************************************/

.carousel {
    margin: 0px auto;
    padding: 0 30px;
}

.carousel-control-prev, .carousel-control-next {
	height: 44px;
	width: 40px;
	background: #21a56e;	
	margin: auto 0;
	border-radius: 4px;
	opacity: 0.8;
}

.carousel-control-prev:hover, .carousel-control-next:hover {
	background: #21a56e;
	opacity: 1;
}

.cards-wrapper {
  display: flex;
  justify-content: center;
}

.carousel-card {
  margin: 0 0.5em;
  /*box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);*/
  border: none;
  border-radius: 0;
}

.carousel-inner {
  padding: 1em;
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
const search_data = <?=json_encode($search_data)?>
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
                <span class="info-box-text">Warm</span>
                <span class="info-box-number">10</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-triangle-exclamation"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                <span class="info-box-number">10</span>
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
              <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-fire"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Hot</span>
                <span class="info-box-number">10</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fa-solid fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Contacted</span>
                <span class="info-box-number">10</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

	  <div class="row">
		<!-- /.col-md-6 -->
		<div class="col-lg-12">
		  <div class="card card-white">
			<div class="card-header">
			  <h3 class="card-title">All leads</h3>
		  <form class="float-right" action="">
			<input type="text" placeholder="Start typing..." name="keyword" id="keyword">
			<button class="btn-dark" id="search">Search</button>
		  </form>
  	  
			</div>
			<!-- /.card-header -->
			<div class="card-body p-0">
			  <!--<button class="m-3 btn btn btn-danger float-right" id="deleteLead"><i class="fa-solid fa-trash"></i> Delete</button>
			  <button class="m-3 btn btn btn-success float-right" id="csv"><i class="fa-solid fa-file-csv"></i> Export CSV</button>
			  <button data-toggle="modal" data-target="#import" class="m-3 btn btn btn-primary float-right" id="csv-import"><i class="fa-solid fa-file-import"></i> Import CSV</button>           
			  <button data-toggle="modal" data-target="#voting" class="m-3 btn btn btn-dark float-right" id="vote"><i class="fa-solid fa-users"></i> Voting</button>-->  
				
			<div class="table-responsive">
			
			  <table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
              <th><input type="checkbox" id="allleads" name="delete-all" value="lead" title="select all"></th> 
					<th>#</th>
					<td>Name</td>
					<td>Age</td>
					<td>Website</td>
					<td>Phone (+Area Code)</td>
					<td>Email</td>
					<td>Location</td>
					<td>Date</td>
					<td>Confirmed</td>
					<td>Status</td>
					<td>Actions</td>
				  </tr>
				</thead>
				<tbody>
				</tbody>
			  </table>
			  
			</div>

			</div>
			<!-- /.card-body -->
		  </div>
		  <!-- /.card -->

		</div>
		<!-- /.col-md-6 -->
	  </div>
	  <!-- /.row -->	  

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
	
<!--================================================================================ MODELS ================================================================================-->

<!-------------- CLIENT -------------->

	<div class="modal fade" id="client">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Client Link</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  
            <form>	
			  
                <div class="form-group">
				<label for="InputGroup">1. Select Group</label>
                <select style="width:100%" class="form-control select2" id="filtergroup">
                    <?php
        
					sort($groups);
									   
					foreach ($groups as $key => $group):
					?>
					<option value="<?= $group ?>"><?= $group ?></option>
					<?php endforeach; ?>		
                  </select>
                </div>
                <!-- /.form-group -->
			  
			  <label for="InputData">2. Select data to include</label>
			  <p><small>Only select the data you want to show to client</small></p>
			  
			  <p>
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="name" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
                    <span class="text">Name</span>					
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="website" id="todoCheck2">
                      <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Website</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="phone" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Phone</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="email" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Email</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="location" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Location</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="booking" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Booking</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="status" id="todoCheck7">
                      <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Status</span>
                  </li>
                  <li>
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="group" id="todoCheck8">
                      <label for="todoCheck7"></label>
                    </div>
                    <span class="text">Actions </span>					
                  </li>
                </ul>
				</p>
				
			  <div class="card-footer clearfix">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
              </div>
			  
			  <hr>
				
			  <div class="form-group">			  
				  
			   <div class="input-group input-group-lg pb-3">
                  <input type="text" value="<?php echo $websiteURL; ?>/client.php?id=1234567890qwertyuiop" class="form-control">
                  <span class="input-group-append">
                    <a href="<?php echo $websiteURL; ?>/client.php?id=1234567890qwertyuiop" target="_blank" class="btn btn-info btn-flat">COPY</a>
					<a href="<?php echo $websiteURL; ?>/client.php?id=1234567890qwertyuiop" class="btn btn-danger btn-flat">DELETE</a>
                  </span>
                </div>				  
             </div>
				
            </form>		  
		  
		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>	</div>
	<!-- /.modal -->

<!-------------- VOTING -------------->

	<div class="modal fade" id="voting">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Voting</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  
		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale" class="btn btn-default" data-dismiss="modal">Close</button>
			
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>	</div>
	<!-- /.modal -->
	
<!-------------- LEADS -------------->

	<div class="modal fade" id="edit">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Edit lead</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">

			<form>
			  <div class="card-body">
				<div class="form-group">
				  <label for="InputName_fck">Name</label>
				  <input id="InputName_fck" type="text" name="name" class="form-control form-control-lg form-control-border" placeholder="Enter name" value="Name">
				</div>
				<div class="form-group">
				  <label for="InputBirthday">Birthday</label>
				  <input id="InputBirthday" type="text" name="birthday" class="form-control form-control-lg form-control-border" placeholder="Enter birthday" value="">
				</div>
				<div class="form-group">
				  <label for="InputWebsite">Website</label>
				  <input id="InputWebsite" type="url" name="website" class="form-control form-control-lg form-control-border" placeholder="Enter website" value="Website">
				</div>
				<div class="form-group">
				  <label for="InputPhone">Phone</label>
				  <input id="InputPhone" type="url" name="tel" class="form-control form-control-lg form-control-border" placeholder="Enter phone" value="">
				</div>
				<div class="form-group">
				  <label for="InputEmail">Email</label>
				  <input id="InputEmail" type="email" name="email" class="form-control form-control-lg form-control-border" placeholder="Enter email" value="">
				</div>
				<div class="form-group">
				  <label for="InputLocation">Location</label>
				  <input id="InputLocation" type="text" name="location" class="form-control form-control-lg form-control-border" placeholder="Enter location" value="">
				</div>
				<div class="form-group" id="question">
         
			</div>
     
				<div class="form-group note-group">
				  <label for="InputNote">Notes</label>
				  <textarea id="InputNote" class="form-control form-control-lg form-control-border" rows="4" placeholder="Enter note">Enter any note</textarea>
				</div>
                <div class="form-group">
                  <label>Drip Campaign</label>
                  <select class="select2" id="editgroup" multiple="multiple" data-placeholder="Select Group" style="width: 100%;">
                  <?php foreach ($groups as $key => $group):?>
                    <option value="<?=$group?>"><?=$group?></option>
                   <?php endforeach;?> 
                  </select>
                </div>
                <!-- /.form-group -->															
			  </div>
			  <!-- /.card-body -->
			</form>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale1" class="btn btn-default" data-dismiss="modal">Close</button>
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
	
<!-------------- BOOKINGS -------------->

	<div class="modal fade" id="booking">
	  <div class="modal-dialog modal-xl">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Edit Bookings</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  <?php
			$type 		= '';
			try {
				$type 	= isset($books[0]["type"]) ? $books[0]["type"] : '';
			} 
			catch (\Exception $th) {}
		?>

<h5 class="text-muted">Select type</h5>
	
	<div class="form-group">
	<select id="type_booking" class="form-control">
	  <option value="booking" <?php if($type == 'booking'){echo 'selected';}?> >Bookings</option>
	  <option value="event" <?php if($type == 'event'){echo 'selected';}?> >Event</option>
	</select>
  </div>


 <h5 class="text-muted users_booking">Number of users for slot?</h5>
  <div class="form-group users_booking">
      <input type="number" id="user_per_slot" class="form-control">
  </div>


    <div class="form-group" id="slot">
	<label>Select slot</label>
	<select id="slot_booking" class="form-control">
	  <option value="00:15">15 mins</option>
	  <option value="00:30">30 mins</option>
	  <option value="01:00">1 hour</option>
	  <option value="1:30">1.5 hours</option>
	  <option value="02:00">2 hours</option>
	</select>
  </div>


<p class="test1"><h5 class="text-muted test1">Select booking days/times</h5></p>

  <div class="main">
  
    <table id="test1"></table>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="plugins/booking/hours/js/scheduler.js"></script>

      <script>
        $('#test1').scheduler({
        });
      </script>

  </div>
  
<p><h5 class="text-muted">Select services</h5></p>

<div class="container">
    <table id="myTable" class=" table order-list">
    <thead>
      
        <tr>
            <td>Name</td>
            <td>Price (optional)</td>
            <td>Picture URL</td>
            <td class="event" style="display: none;">Date event</td>
            <td class="event" style="display: none;">Time event</td>
            <td class="event" style="display: none;">Tickets</td>
        </tr>
    </thead>
    <tbody>
      <?php foreach($books[0]['services'] as $key => $service):?>
		<?php
			$dateString 	= '';
			try {
				$arr 		= explode('-', $service['dateevent']);
				$day 		= $arr[0];
				$month 		= $arr[1];
				$year 		= $arr[2];
				$dateString = "{$year}-{$month}-{$day}";

			} catch (\Exception$th) {}
		?>
        <tr>
            <td class="col-sm-4">
                <input type="text" name="name" class="form-control name" value="<?=$service['name']?>"/>
            </td>
            <td class="col-sm-4">
                <input type="text" name="price"  class="form-control price" value="<?=$service['price']?>"/>
            </td>
            <td class="col-sm-3">
                <input type="text" name="picture"  class="form-control picture" value="<?=$service['url']?>"/>
            </td>
            <td class="col-sm-3 event"
            style="display: none;" >
                    <input name="date" value="<?= $dateString ?>" type="date"
                     class="form-control dateevent" 
                     placeholder="Enter the date">
            </td> 
            <td class="col-sm-3 event"
            style="display: none;">
            <input name="begin" value="<?= $service['timeevent'] ?>" type="time"
        class="form-control timeevent" 
        placeholder="Enter the heure">
            </td>
            <td class="col-sm-3 event" style="display: none;">
                <input name="tickets" style="width: 100px;" value="<?= $service['ticketsevent'] ?>" type="number" class="form-control ticketsevent" placeholder="Tickets">
            </td>
            <td class="col-sm-2"><a class="deleteRow"></a>
            <?php if($key !=0):?>
           <input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete">
           <?php endif; ?>
            </td>
        </tr>
         <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="text-align: left;">
                <input type="button" class="btn btn-light btn-lg btn-block " id="addrow" value="Add Row" />
            </td>
        </tr>
        <tr>
        </tr>
    </tfoot>
</table>
</div>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale1" class="btn btn-default" data-dismiss="modal">Close</button>
			<button class="btn btn-primary" id="btnBooking" type="submit">Submit</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

<!-------------- EDIT USER BOOKING -------------->

<div class="modal fade" id="edituserbooking">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Edit Booking</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
        
			<form>
			  <div class="card-body">
				<div class="form-group">
				  <label for="InputbookName_fck">Name</label>
				  <input id="InputbookName_fck" type="text" name="name" class="form-control form-control-lg form-control-border" placeholder="Enter name" value="">
				</div>
				<div class="form-group">
				  <label for="InputbookWebsite">Website</label>
				  <input id="InputbookWebsite" type="url" name="website" class="form-control form-control-lg form-control-border" placeholder="Enter website" value="">
				</div>
				<div class="form-group">
				  <label for="InputbookPhone">Phone</label>
				  <input id="InputbookPhone" type="url" name="tel" class="form-control form-control-lg form-control-border" placeholder="Enter phone" value="">
				</div>
				<div class="form-group">
				  <label for="InputbookEmail">Email</label>
				  <input id="InputbookEmail" type="email" name="email" class="form-control form-control-lg form-control-border" placeholder="Enter email" value="">
				</div>
				<div class="form-group">
				  <label for="InputbookLocation">Location</label>
				  <input id="InputbookLocation" type="text" name="location" class="form-control form-control-lg form-control-border" placeholder="Enter location" value="">
				</div>     
       <!-- /.form-group -->															
			  </div>
			  <!-- /.card-body -->
			</form>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale1" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" id="editbookingsubmit" class="btn btn-primary ">Save changes
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
        <button type="submit" id="editSocialsubmit" class="btn btn-primary ">Save changes
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
	
<!-------------- POSTING -------------->

	<div class="modal fade" id="posting">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Facebook Profile</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
      <form>
          <div class="modal-body">

          <div class="form-group">
            <label for="clientLink">Client Link</label>
            <input id="clientLink" type="url" name="client-link" class="form-control form-control-lg" placeholder="Client URL" value="https://socialpromo.biz/connect.php?=NETWORK-NAME&r=REDIRECT-LINK">
          </div>		  
         <!-- /.form-group -->	
		 
		 <p>- OR CONNECT NOW - </p>
		 
		<a href="https://facebook.com" class="btn-lg btn-block btn-social btn-facebook">
			<i class="fab fa-facebook fa-2x"></i> Facebook Pages
		</a>

        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
  
  <!-------------- CAMPAIGN -------------->

	<div class="modal fade" id="edit-campaign">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Edit campaign</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">

			<form>
			  <div class="card-body">
        <div class="form-group">
                   <label for="InputTime">Select Type</label>
                  <select class="form-control" id="edit-type">
                    <option>Email</option>
                    <option>SMS</option>
                    <option>Push</option>
                    <option>Whatsapp</option>				
                  </select>
                </div>
                <!-- /.form-group -->				
				
                  <div class="form-group">
                    <label for="InputGroup">Select Days</label>
					
					<div class="weekDays-selector">
					  <input type="checkbox" name="editdays" id="edit-weekday-mon" value="Monday" class="weekday" />
					  <label for="edit-weekday-mon">M</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-tue" value="Tuesday" class="weekday" />
					  <label for="edit-weekday-tue">T</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-wed" value="Wednesday" class="weekday" />
					  <label for="edit-weekday-wed">W</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-thu" value="Thursday" class="weekday" />
					  <label for="edit-weekday-thu">T</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-fri" value="Friday" class="weekday" />
					  <label for="edit-weekday-fri">F</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-sat" value="Saturday" class="weekday" />
					  <label for="edit-weekday-sat">S</label>
					  <input type="checkbox" name="editdays" id="edit-weekday-sun" value="Sunday" class="weekday" />
					  <label for="edit-weekday-sun">S</label>
					</div>							
				
                <div class="form-group">
                   <label for="InputTime">Select Time</label>
                  <select class="form-control" id="edit-time">
                    <option value="09:00">9am - Morning</option>
                    <option value="13:00">1pm - Lunch</option>
                    <option value="17:00">5pm - Afternoon</option>
                    <option value="20:00">8pm - Evening</option>					
                  </select>
                </div>	
                
    <div class="form-group">
                   <label for="InputTime">Select Group</label>
                  <select class="form-control" id="edit-group">
                  <?php foreach ($groups as $key => $group):?>
                    <option><?=$group?></option>
                   <?php endforeach;?> 				
                  </select>
                </div>	

								
			  </div>
			  <!-- /.card-body -->
			</form>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" id="editCampaignsubmit" class="btn btn-primary ">Save changes
			  <span id="spinner" class="spinner-border text-light" style="width: 20px; height: 20px; display: none;" ; role="status">
			  </span>
			</button>
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>	</div>
	<!-- /.modal -->

	 <!--------------STATUS CAMPAIGN -------------->

	<div class="modal fade" id="status-campaign">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title">Status campaign</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">

			  <!--<div class="card-body">
      <p id="status-camp"></p>
			  </div>-->

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Sent at</th>
                    <th>Response</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="status_table">
                  <tr>
                    <td>Mark Smith</td>
                    <td>mark@mail.com</td>
                    <td>Jul 8th 23, 21:00</td>
                    <td><small class="badge badge-warning"><i class="fas fa-clock"></i> Pending</small></td>
					<td><button class="btn btn btn-light btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>
                  </tr>
                  <tr>
                    <td>Jon Smith</td>
                    <td>jon@mail.com</td>
                    <td>Jul 8th 23, 21:00</td>
                    <td><small class="badge badge-success"><i class="fas fa-check"></i> Submitted</small></td>
					<td><button class="btn btn btn-light btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>
                  </tr>
                  <tr>
                    <td>Sam Smith</td>
                    <td>sam@mail.com</td>
                    <td>Jul 8th 23, 21:00</td>
                    <td><small class="badge badge-danger"><i class="fas fa-xmark"></i> Failure</small></td>
					<td><button class="btn btn btn-primary btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>
                  </tr>
                  <tr>
                    <td>Kelly Smith</td>
                    <td>kelly@mail.com</td>
                    <td>Jul 8th 23, 21:00</td>
                    <td><small class="badge badge-success"><i class="fas fa-check"></i> Submitted</small></td>
					<td><button class="btn btn btn-light btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Sent at</th>
                    <th>Response</th>
					<th>Action</th>
                  </tr>
                  </tfoot>
                </table>

		  </div>
		  <div class="modal-footer justify-content-between">
			<button type="button" id="closemodale" class="btn btn-default" data-dismiss="modal">Close</button>
			
		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>	</div>
	<!-- /.modal -->
	
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
  
<!-------------- IMPORT -------------->

<div class="modal fade" id="import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Import</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
			<form action="process_csv.php" method="post" enctype="multipart/form-data">
			<div class="card-body">
      
                  <div class="form-group">
                    <label for="exampleInputFile">Upload CSV - <a href="example.csv">See example<a></label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="csvFile" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
      </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default clos" data-dismiss="modal">Close</button>
              <button type="submit" id="importcsv" class="btn btn-primary">Import CSV</button>
            </div>
          </div>
          </form>
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

<script>
// Taken from : https://www.w3schools.com/howto/howto_js_copy_clipboard.asp
// I renamed functions for better code clarity/readability

function copyText() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");
  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  /* Copy the text inside the text field */
  document.execCommand("copy");

  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied: " + copyText.value;
}

function updateText() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy to clipboard";
}
</script>

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
const dataID = getInfoFromKey('<?=$dataID?>')
</script>

<script>
$(document).ready(function(){
  $("#filterNetwork").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script>
 
$(function () {
  // Summernote
  $('#summernote').summernote()
 $('#InputNote').summernote()
  // CodeMirror
  CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
    mode: "htmlmixed",
    theme: "monokai"
  });
})

//Bootstrap Duallistbox
$('.duallistbox').bootstrapDualListbox()

$(function () {
//Initialize Select2 Elements
$('.select2').select2()
})

$("input[data-bootstrap-switch]").each(function(){
  $(this).bootstrapSwitch('state', $(this).prop('checked'));
})

</script>

<script type="text/javascript">

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

let sts= <?=(status)?>;
let bookingsts= <?=(bookingstatus)?>;
let datafile = "<?=datafile?>";
var calendar_api_key = '<?=calendar_api_key?>';
var country = '<?=country?>';

</script>

<style>
  .delete-template{
    /* margin: -20px -20px; */
    position: relative;
    top: 50px;
    padding-left: 20px;
    padding-right: 20px;
  }
</style>

<script src="src/js/admin.js"></script>

<!-- Make sure to include jQuery as shown above -->

<script>
  $(document).ready(function() {
    // Listen to the click event of the "Import CSV" submit button
    $('#importcsv').click(function(event) {
      event.preventDefault(); // Prevent the default form submission behavior

      // Create a FormData object
      var formData = new FormData();

      // Get the file input element
      var fileInput = $('#exampleInputFile')[0];

      // Check if a file is selected
      if (fileInput.files.length > 0) {
        // Append the uploaded file to the FormData object
        formData.append('csvFile', fileInput.files[0]);
      } else {
        // Handle the case where no file is selected
        Swal.fire({
          icon: 'error',
          title: 'Alert',
          text: 'No file selected',
        });
        return;
      }

      // Send the form data via AJAX
      $.ajax({
        url: 'process_csv.php', // Replace with the URL of your CSV processing PHP script
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Handle the server response on success
          console.log('Server Response:', response);
          $('.btn.btn-default.clos').click();
          // setTimeout()
          Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: response,
        });
          
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.log('AJAX Error:', error);
         
        }
      });
    });
  });
</script>

<script>
 $(document).ready(function() {
    // Listen to the change event of the file input
    $('#exampleInputFile').change(function() {
      // Get the file name from the file input
      var fileName = $(this).val().split('\\').pop();

      // Display the file name in the custom file label
      $(this).next('.custom-file-label').text(fileName);
    });
  });
</script>

<script>

// BOOKINGS

$(document).ready(function () {
    var counter = 1;

    $("#addrow").on("click", function () {
     
    var type_booking =  $('#type_booking').val();
  
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td><input type="text" class="form-control name" name="name' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control price" name="price' + counter + '"/></td>';
        cols += '<td><input type="text" class="form-control picture" name="picture' + counter + '"/></td>';
      
        if (type_booking === 'event') {
        cols += '<td class="col-sm-3 event" ><input name="date" value="" type="date"class="form-control dateevent" id="" placeholder="Enter the date"></td>';
        cols += '<td class="col-sm-3 event" ><input name="time" value="" type="time"class="form-control timeevent" id="timeevent"placeholder="Enter the heure"> </td>';
        cols += '<td class="col-sm-3 event"><input name="tickets" style="width: 100px;" value="" type="number" class="form-control ticketsevent" placeholder="No. of Tickets"></td>';
        }
        else{
           cols += '<td class="col-sm-3 event" style="display: none;"><input name="date" value="" type="date"class="form-control dateevent" id="" placeholder="Enter the date"></td>';
        cols += '<td class="col-sm-3 event" style="display: none;"><input name="time" value="" type="time"class="form-control timeevent" id="timeevent"placeholder="Enter the heure"> </td>';
            cols += '<td class="col-sm-3 event" style="display: none;"><input name="tickets" style="width: 100px;" value="" type="number" class="form-control ticketsevent" placeholder="No. of Tickets"></td>';
        }
        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});

function calculateRow(row) {
    var price = +row.find('input[name^="price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.order-list").find('input[name^="price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}

</script>

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
