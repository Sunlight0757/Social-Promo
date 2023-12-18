<!DOCTYPE html>
<?php require 'config.php'; 

// Current domain
$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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


  $bookingdata = file_get_contents(adminServicesFile);
  $books = json_decode($bookingdata, true);

  $categorydata = file_get_contents(adminSearchCategoriesFile);
  $categories = json_decode($categorydata, true);

  $linkdata = file_get_contents(adminClientLinksFile);
  $clientlinks = json_decode($linkdata, true);

  $datagroups = [];
  $ddata = file_get_contents(datafile);

  $ddata =json_decode($ddata,true);
  foreach ($ddata as $dkey => $dvalue) {
    // array_push($groups,$dvalue['group']);
    if (count(array_diff($dvalue['groups'], $datagroups))!=0 and $dvalue['groups'] != '') {
      $datagroups = array_merge($datagroups, $dvalue['groups']);
    }
  }
?>

<?php
	
/// WEBSITE
$websiteURL = 'https://socialpromo.biz';

?>

<html lang="en">

<head>
	
<?php require 'meta.php';?>

<!-------- PLUGINS -------->

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
<!--<link rel="stylesheet" href="src/css/social-colors.css">-->
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
var search_data = <?=json_encode($search_data)?>;
var data_groups = <?=json_encode($datagroups)?>;
var categories = <?=json_encode($categories)?>;
var tempate_groups = <?=json_encode($groups)?>;
var client_links = <?=json_encode($clientlinks)?>;
const dataID = [];
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
  <div class="content">
	<div class="container">
	
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="0">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="cards-wrapper">
      <div class="carousel-card" style="width: 100%;">
	  <div class="card-header bg-info">
		<h3 class="card-title"><i class="fa-solid fa-address-book"></i>  Leads</h3>
	  </div>  
	  
		  <ul class="list-group list-group-flush" id="leads_stats">
			<li class="list-group-item">Total <span class="float-right badge bg-info" id="total_stat">0</span></li>
			<li class="list-group-item">Warm <span class="float-right badge bg-info" id="warm_stat">0</span></li>
			<li class="list-group-item">Hot <span class="float-right badge bg-info" id="hot_stat">0</span></li>
		  </ul>	  
		  
      </div>
      <div class="carousel-card d-none d-md-block" style="width: 100%;">
	  <div class="card-header bg-info">
		<h3 class="card-title"><i class="fa-solid fa-search"></i>  Search</h3>
	  </div>
				
		  <ul class="list-group list-group-flush" id="search_stats">
			<li class="list-group-item">Total <span class="float-right badge bg-info" id="total_search_status">0</span></li>
			<li class="list-group-item">Contacted <span class="float-right badge bg-info" id="total_search_contacted_status">0</span></li>
			<li class="list-group-item">Replied <span class="float-right badge bg-info" id="total_search_replied_status">0</span></li>
		  </ul>
	  
      </div>
      <div class="carousel-card d-none d-md-block" style="width: 100%;">
	  <div class="card-header bg-info">
		<h3 class="card-title"><i class="fa-solid fa-calendar"></i>  Bookings</h3>
	  </div>  
	  
		  <ul class="list-group list-group-flush" id="booking_stats">
      <li class="list-group-item">Total <span class="float-right badge bg-info" id="total_booking_status">0</span></li>
			<li class="list-group-item">Pending <span class="float-right badge bg-info" id="warm_stat">0</span></li>
			<li class="list-group-item">Attended <span class="float-right badge bg-info" id="hot_stat">0</li>
		  </ul>
		  	  
      </div>
    </div>
    </div>
    <div class="carousel-item">
      <div class="cards-wrapper">
        <div class="carousel-card" style="width: 100%;">
	  <div class="card-header bg-info">
		<h3 class="card-title"><i class="fa-solid fa-square-check"></i>  Confirmed</h3>
	  </div>  
	  
		  <ul class="list-group list-group-flush">
			<li class="list-group-item">Pending <span class="float-right badge bg-info" id="pending_stat">0</span></li>
			<li class="list-group-item">Confirmed <span class="float-right badge bg-info" id="confirmed_stat">0</span></li>
			<li class="list-group-item">Unsubscribed <span class="float-right badge bg-info" id="unsubscribed_stat">0</span></li>
		  </ul>
		    
        </div>
        <div class="carousel-card d-none d-md-block" style="width: 100%;">
	  <div class="card-header bg-info">
		<h3 class="card-title"><i class="fa-solid fa-envelope"></i>  Messages</h3>
	  </div>  
	  
		  <ul class="list-group list-group-flush">
			<li class="list-group-item">Templates <span class="float-right badge bg-info" id="templates_stat">0</span></li>
			<li class="list-group-item">Campaigns <span class="float-right badge bg-info" id="campaigns_stat">0</span></li>
			<li class="list-group-item">Sent <span class="float-right badge bg-info" id="sent_stat">0</span></li>	
			
		  </ul>
        </div>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

			<div class="input-group input-group-sm pb-3">
                  <input type="text" value="<?php echo $websiteURL; ?>/index.php" class="form-control">
                  <span class="input-group-append">
                    <a href="index.php" target="_blank" class="btn btn-info btn-flat">VIEW PROMOTION</a>
                  </span>
                </div>
				
            <div class="card card-dark card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-leads-tab" data-toggle="pill" href="#custom-tabs-one-leads" role="tab" aria-controls="custom-tabs-one-leads" aria-selected="true">Leads</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-bookings-tab" data-toggle="pill" href="#custom-tabs-one-bookings" role="tab" aria-controls="custom-tabs-one-bookings" aria-selected="true">Bookings</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-promo-tab" data-toggle="pill" href="#custom-tabs-one-promo" role="tab" aria-controls="custom-tabs-one-promo" aria-selected="true">Promotions</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-search-tab" data-toggle="pill" href="#custom-tabs-one-search" role="tab" aria-controls="custom-tabs-one-search" aria-selected="true">Search</a>
                  </li> 
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-social-tab" data-toggle="pill" href="#custom-tabs-one-social" role="tab" aria-controls="custom-tabs-one-social" aria-selected="true">Social</a>
                  </li>				  
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-templates-tab" data-toggle="pill" href="#custom-tabs-one-templates" role="tab" aria-controls="custom-tabs-one-templates" aria-selected="false">Templates</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-campaigns-tab" data-toggle="pill" href="#custom-tabs-one-campaigns" role="tab" aria-controls="custom-tabs-one-campaigns" aria-selected="false">Campaigns</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-plugins-tab" data-toggle="pill" href="#custom-tabs-one-plugins" role="tab" aria-controls="custom-tabs-one-plugins" aria-selected="false">Plugins</a>
                  </li>			  
                </ul>
              </div>
              <div class="card-body p-0">		  
                <div class="tab-content" id="custom-tabs-one-tabContent">			
				
                  <div class="tab-pane fade show active" id="custom-tabs-one-leads" role="tabpanel" aria-labelledby="custom-tabs-one-leads-tab">

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
		  <br><br>

                <div class="form-group">
                  <select class="form-control select2" id="filtergroup">
                    <option value="">- SELECT GROUP OR RESET-</option>
                    <?php
        
        sort($datagroups);
        
       
        foreach ($datagroups as $key => $group):
        ?>
        <option value="<?= $group ?>"><?= $group ?></option>
        <?php endforeach; ?>
                  </select>
                </div>
                <!-- /.form-group -->			  
		  
			</div>
			<!-- /.card-header -->
			<div class="card-body p-0">
			  <button class="m-3 btn btn btn-danger float-right" id="deleteLead"><i class="fa-solid fa-trash"></i> Delete</button>
			  <button class="m-3 btn btn btn-success float-right" id="csv"><i class="fa-solid fa-file-csv"></i> Export CSV</button>
			  <button data-toggle="modal" data-target="#import" class="m-3 btn btn btn-primary float-right" id="csv-import"><i class="fa-solid fa-file-import"></i> Import CSV</button>             
			  <button data-toggle="modal" data-target="#voting" class="m-3 btn btn btn-dark float-right" id="vote"><i class="fa-solid fa-users"></i> Voting</button>
			  <button data-toggle="modal" data-target="#client" class="m-3 btn btn btn-warning float-right" id="lead-client-link"><i class="fa-solid fa-link"></i> Client Link</button>
				
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
				<tbody id="leadtab">
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

                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-one-bookings" role="tabpanel" aria-labelledby="custom-tabs-one-bookings-tab">

	  <div class="row">
		<!-- /.col-md-6 -->
		<div class="col-lg-12">
		  <div class="card card-white">
			<div class="card-header">
			  <h3 class="card-title">All Bookings</h3>
		  <form class="float-right" action="">
			<input type="text" placeholder="Start typing..." name="booking_keyword" id="booking_keyword">
			<button class="btn-dark" id="booking_search">Search</button>
		  </form>
		  <br><br>

                <div class="form-group">
                  <select class="form-control select2" id="bookingfiltergroup" style="width: 100%;" >
                    <option value="">- SELECT GROUP OR RESET-</option>
                    <?php
        
        sort($datagroups);
        
       
        foreach ($datagroups as $key => $group):
        ?>
        <option value="<?= $group ?>"><?= $group ?></option>
        <?php endforeach; ?>
                  </select>
                </div>
                <!-- /.form-group -->			  
		  
			</div>
			<!-- /.card-header -->
			<div class="card-body p-0">
			  <button class="m-3 btn btn btn-danger float-right" id="deleteBooking"><i class="fa-solid fa-trash"></i> Delete</button>
			  <button class="m-3 btn btn btn-success float-right" id="csv"><i class="fa-solid fa-file-csv"></i> Export CSV</button>
			  <button data-toggle="modal" data-target="#import" class="m-3 btn btn btn-primary float-right" id="csv-import"><i class="fa-solid fa-file-import"></i> Import CSV</button>
			  <button data-toggle="modal" on data-target="#booking" class="m-3 btn btn btn-dark float-right"><i class="fa-solid fa-clock"></i> Create Booking</button>
        <button data-toggle="modal" data-target="#client" class="m-3 btn btn btn-warning float-right" id="booking-client-link"><i class="fa-solid fa-link"></i> Client Link</button>
			<div class="table-responsive">
          
			
			  <table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
              <th><input type="checkbox" id="allbookings" name="delete-all" value="bookings" title="select all"></th> 
					<th>#</th>
					<td>Name</td>					
					<td>Website</td>
					<td>Phone</td>
					<td>Email</td>
					<td>Location</td>
					<td>Booking</td>
					<td>Confirmed</td>
					<td>Status</td>
					<td>Actions</td>
				  </tr>
				</thead>
				<tbody id="bookingtab">
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

                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-one-promo" role="tabpanel" aria-labelledby="custom-tabs-one-promo-tab">

        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
	
			<div class="card card-white">
              <div class="card-header">
                <h3 class="card-title">Create Promotion</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="PromoGroup">Name</label>
				    <input id="PromoGroup" type="text" name="name"  class="form-control form-control-lg" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <label for="PromoLogo">Logo</label>
				    <input id="PromoLogo" type="url" name="logo" class="form-control form-control-lg" placeholder="Enter logo">
                  </div>
                  <div class="form-group">
                    <label for="PromoPassword">Password</label>
				    <input id="PromoPassword" type="password" name="password" class="form-control form-control-lg" placeholder="Enter password">
                  </div>				            
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" id="btnPromo" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>			
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">All promotions</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
			 			  			  
                 <button class="m-3 btn btn btn-danger float-right" id="deletePromo"><i class="fa-solid fa-trash"></i> Delete</button>			 
				 
			<div class="table-responsive">				 				 
                 <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th><input type="checkbox" id="alltpromotions" name="promo" value="promo" id="" title="select all"></th>
                    <th>No</th>
                    <th>Name</th>
					<th>Logo</th>
					<th>Password</th>					
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>			  
                  </tbody>
                  <tfoot>
                  <tr> 
                    <th> </th>
                    <th>No</th>
                    <th>Name</th>
					<th>Logo</th>
					<th>Password</th>					
                    <th>Actions</th>
                  </tr>
                  </tfoot>
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

                  </div>	
                  <div class="tab-pane fade show" id="custom-tabs-one-search" role="tabpanel" aria-labelledby="custom-tabs-one-search-tab">

	  <div class="row">
		<!-- /.col-md-6 -->
		<div class="col-lg-12">
		  <div class="card card-info">
			<div class="card-header">
			  <h3 class="card-title mt-1">Social Leads</h3>
		  <form class="float-right" action="">
			<input type="text" placeholder="Start typing..." name="keyword" id="keyword2">
			<button class="btn-dark" id="search2">Search</button>
		  </form>			  
			</div>
			<!-- /.card-header -->
              <div class="card-body">
			  
			  <p><a href="#search_settings" data-toggle="collapse" class="btn btn-success"><i class="fas fa-cogs"></i> VIEW SETTINGS </a></p>

			<div id="search_settings" class="collapse">

              <form method="POST" id="category_create_form">
			  
                <div class="form-group">
                   <label for="search_type">1. Category</label>
				   
			  <div class="input-group mb-3">
                  <div class="input-group">
                    <input id="search_category" name="search_category" type="text" class="form-control" placeholder="Enter category">
                    <span class="input-group-append">
					  <button id="category_create_btn" class="btn btn-success btn-flat" type="button">SUBMIT</button>
                    </span>
                  </div>
			  </div>			   
              </form>

              <form method="DELETE" id="category_delete_form">
                  <p><select class="form-control" id="search_category_select" name="search_category_select">
                    <?php foreach ($categories as $key => $category): ?>
                      <option value="<?= $category ?>"><?= $category ?></option>
                    <?php endforeach; ?>
                  </select></p>
				  <p><button type="button" id="category_delete_btn" class="btn btn-secondary btn-xs search_category_delete">Delete selected category?</button></p>
               </form>
                </div>
                <!-- /.form-group -->			  

              <form method="POST" id="search_url_form">

                <div class="form-group">
                   <label for="search_type">2. Type</label>
                  <select class="form-control" id="search_type" name="search_type">
                    <option value="business">Business name</option>
                    <option value="competitor">Competitor</option>
                    <option value="product">Product</option>
					<option value="keyword">Keyword</option>
					<option value="rss">RSS</option>	
                  </select>
                </div>
                <!-- /.form-group -->
				
			  <div class="input-group mb-3" id="RSS_feed_field">
			   <label for="search_rss">Enter RSS feed</label>
				  <div class="input-group pb-3">
                    <input id="search_rss" name="search_rss" type="url" class="form-control" placeholder="Enter valid RSS feed">
                    <span class="input-group-append">
					  <button class="btn btn-success btn-flat" type="submit">SUBMIT</button>
                    </span>
                  </div>
				  
		  <div class="col-md-12">

				  <div class="row">
                  <div class="col-4">
                    <input name="rss_type" type="text" class="form-control" placeholder="Enter type for reference">
                  </div>
                  <div class="col-4">
                    <input name="rss_network" type="text" class="form-control" placeholder="Enter network for reference">
                  </div>
                  <div class="col-4">
                    <input name="rss_keyword" type="text" class="form-control" placeholder="Enter keyword for reference">
                  </div>
                </div>

          </div>
				  
			</div>
				
                <div class="form-group" id="network_field">
                   <label for="search_network">3. Network</label>
                  <select class="form-control" id="search_network" name="search_network">
                    <option>Facebook-Leads</option>
					<option>Instagram-Leads</option>
                    <option>Twitter-Leads</option>	
                    <option>Tiktok</option>
                  </select>
                </div>
                <!-- /.form-group -->
			  
			  <div class="input-group mb-3" id="keyword_field">
			   <label for="search_keyword">4. Keyword</label>
                  <div class="input-group">
                    <input id="search_keyword" name="search_keyword" type="text" class="form-control" placeholder="Enter business name, competitor or product keyword">
                    <span class="input-group-append">
					  <button class="btn btn-success btn-flat" type="submit">SUBMIT</button>
                    </span>
                  </div>

			</div>

              </form>

			</div>
			
			<div class="card-footer p-0 mb-3">
                <ul class="nav nav-pills flex-column search-params-list">
                  <?php 
                  $search_params = getSearchParams();
                  if(!empty($search_params)){
                    foreach ($search_params as $search_param) {
                      $search_param_id = $search_param['id'];
                      $search_url = $search_param['search_url'];
                      $search_type = isset($search_param['type'])?$search_param['type']:"";
                      $search_network = isset($search_param['network'])?$search_param['network']:"";
                      $search_keyword = isset($search_param['keyword'])?$search_param['keyword']:"";
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
                      ?>
                    
                </ul>
              </div>

              <button class="m-3 btn btn btn-danger float-right" id="search-data-table-delete"><i class="fa-solid fa-trash"></i> Delete</button>
              <button data-toggle="modal" data-target="#client" class="m-3 btn btn btn-warning float-right" id="search-client-link"><i class="fa-solid fa-link"></i> Client Link</button>
              
              <div class="overflow-auto w-100">
                <table class="table table-bordered table-hover search-data-table">
                  <thead id="searchth">
                    <tr>
                      <th><input type="checkbox" id="search-data-table-selectAll"></th>
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
		<!-- /.col-md-6 -->
	  </div>
	  <!-- /.row -->

                  </div>				  
				  				  
                  <div class="tab-pane fade show" id="custom-tabs-one-social" role="tabpanel" aria-labelledby="custom-tabs-one-social-tab">
				  
		<div class="row p-3">
          <div class="col-lg-6">
            <div class="card card-info">
              <div class="card-header">
                <h5 class="card-title m-0">Social Networks</h5>
              </div>
              <div class="card-body">
			  
<a href="#posting" data-toggle="modal" class="btn-lg btn-block btn-social btn-blogger">
	<i class="fab fa-blogger fa-2x"></i> Blogger
</a>

<a href="#posting" data-toggle="modal" class="btn-lg btn-block btn-social btn-facebook">
	<i class="fab fa-facebook fa-2x"></i> Facebook Groups
</a>
			  
<a href="#posting" data-toggle="modal" class="btn-lg btn-block btn-social btn-facebook">
	<i class="fab fa-facebook fa-2x"></i> Facebook Pages
</a>

<a href="https://www.google.com/" id="gb" class="btn-lg btn-block btn-social btn-google">
	<i class="fab fa-google fa-2x"></i> Google My Business
</a>

<a href="https://www.instagram.com" id="insta" class="btn-lg btn-block btn-social btn-instagram">
	<i class="fab fa-instagram fa-2x"></i> Instagram Business Profile
</a>

<a href="https://www.linkedin.com/" id="lnProfile" class="btn-lg btn-block btn-social btn-linkedin">
	<i class="fab fa-linkedin fa-2x"></i> Linkedin Profile
</a>

<a href="https://www.linkedin.com/" id="lnCompany" class="btn-lg btn-block btn-social btn-linkedin">
	<i class="fab fa-linkedin fa-2x"></i> Linkedin Companies
</a>

<a href="http://medium.com/" id="medium" class="btn-lg btn-block btn-social btn-medium">
	<i class="fab fa-medium fa-2x"></i> Medium
</a>

<a href="http://pinterest.com/" id="pinterest" class="btn-lg btn-block btn-social btn-pinterest">
	<i class="fab fa-pinterest fa-2x"></i> Pinterest
</a>

<a href="https://reddit.com/" id="reddit" class="btn-lg btn-block btn-social btn-reddit">
	<i class="fab fa-reddit fa-2x"></i> Reddit
</a>

<a href="https://t.me/" id="telChannels" class="btn-lg btn-block btn-social btn-telegram">
	<i class="fab fa-telegram fa-2x"></i> Telegram Channels
</a>

<a href="https://t.me/" id="telGroups" class="btn-lg btn-block btn-social btn-telegram">
	<i class="fab fa-telegram fa-2x"></i> Telegram Groups
</a>

<a href="https://tiktok.com/" id="tiktok" class="btn-lg btn-block btn-social btn-tiktok">
	<i class="fab fa-tiktok fa-2x"></i> TikTok
</a>

<a href="https://www.tumblr.com/" id="tumblr" class="btn-lg btn-block btn-social btn-tumblr">
	<i class="fab fa-tumblr fa-2x"></i> Tumblr
</a>

<a href="https://twitter.com/" id="twitter" class="btn-lg btn-block btn-social btn-twitter">
	<i class="fab fa-twitter fa-2x"></i> Twitter
</a>

<a href="https://vk.com/" id="vkProfile" class="btn-lg btn-block btn-social btn-twitter">
	<i class="fab fa-vk fa-2x"></i> VK Accounts
</a>

<a href="https://vk.com/" id="vkCommunity" class="btn-lg btn-block btn-social btn-twitter">
	<i class="fab fa-vk fa-2x"></i> VK Communities
</a>

<a href="https://wordpress.com" id="wordpress" class="btn-lg btn-block btn-social btn-wordpress">
	<i class="fab fa-wordpress fa-2x"></i> Wordpress.com
</a>

<a href="https://youtube.com" id="youtube" class="btn-lg btn-block btn-social btn-youtube">
	<i class="fab fa-youtube fa-2x"></i> YouTube
</a>

              </div>
            </div>

			
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card card-info">
              <div class="card-header">
                <h5 class="card-title m-0">Accounts</h5>
              </div>
              <div class="card-body p-0">
			  
			  <table class="table">
                <thead>
                  <tr>
                    <th>Network</th>
                    <th>Name</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td>Facebook</td>
                    <td>Starbucks</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-link"></i></a>					  
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr><tr>
                    <td>Instagram</td>
                    <td>Starbucks</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-link"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr><tr>
                    <td>Twitter</td>
                    <td>Starbucks</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-link"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr><tr>
                    <td>Pinterest</td>
                    <td>Starbucks</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-link"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr><tr>
                    <td>LinkedIn</td>
                    <td>Starbucks</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-info"><i class="fas fa-link"></i></a>
                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>

                </tr></tbody>
              </table>

              </div>
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>

                  </div>
				  				  
                  <div class="tab-pane fade" id="custom-tabs-one-templates" role="tabpanel" aria-labelledby="custom-tabs-one-templates-tab">

	  <div class="row">
		<div class="col-lg-12"><!-- /.col-lg-12 -->
		
            <div class="card card-info collapsed-card">
              <div class="card-header pt-2 pb-2">
                <h3 class="card-title mt-2">Create Template</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <!-- form start -->
              <form>
                  <div class="form-group">
                    <label for="templateGroup">Group</label>
				    <input id="templateGroup" type="text" name="group"  class="form-control form-control-lg" placeholder="Enter group">
                  </div>
                  <div class="form-group">
                    <label for="templateImage">Image</label>
				    <p><input id="templateImage" type="url" name="image" class="form-control form-control-lg" placeholder="Enter image"></p>
					
					<p><a href="#gallery" data-toggle="collapse" class="btn btn-success"><i class="fas fa-images"></i> FIND IMAGE</a></p>					

					<div id="gallery" class="collapse">					
					
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
                    <label for="templateLink">URL</label>
				    <input id="templateLink" type="url" name="link" class="form-control form-control-lg" placeholder="Enter link">
                  </div>
                  <div class="form-group">
                    <label for="templateTitle">Title</label>
				    <input id="templateTitle" type="text" name="title" class="form-control form-control-lg" placeholder="Enter title">
                  </div>				
                  <div class="form-group">
                    <label for="templateContent">Content</label>
<textarea id="summernote">
Place <em>some</em> <u>text</u> <strong>here</strong>
</textarea>
				
                  </div>
				  
				  <p>
				  <b>Shortcodes</b><br>
{NAME} - Replaces name.<br>
{WEBSITE} - Replaces website.<br>
{PHONE} - Replaces phone number.<br>
{EMAIL} - Replaces email.<br>
{LOCATION} - Replaces location.<br>
{BOOKING} - Replaces with booking details.<br>
                 </p>
                  

                <div class="card-footer">
                  <button type="submit" id="btnTemplate" class="btn btn-primary">Submit</button>
                </div>
              </form>

              </div>
              <!-- /.card-body -->
			  
            </div>
            <!-- /.card -->
			
            <div class="card card-info">
              <div class="card-header pt-2 pb-2">
                <h3 class="card-title mt-2">All templates</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
			<div class="card-body">
				
			  <form class="float-right" action="">
				<input type="text" placeholder="Start typing..." name="temp_keyword" id="temp_keyword">
				<button class="btn-dark" id="temp_search">Search</button>
			  </form>
			  <br><br>

				<div class="form-group">
    <select class="form-control select2 col-lg-12" style="width: 100%;" id="filtertemplategroup">
        <option value="">- SELECT GROUP OR RESET -</option>
        <?php
        
        sort($groups);
        
       
        foreach ($groups as $key => $group):
        ?>
        <option value="<?= $group ?>"><?= $group ?></option>
        <?php endforeach; ?>
    </select>
</div>

            <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                      Client Link
                    </button>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item"><a href="#">Client Link</a></li>
					  <li class="dropdown-divider"></li>
                      <li class="dropdown-item"><a href="#">RSS Feed</a></li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <input type="text" value="https://socialpromo.biz/client.php?id=123456780" class="form-control">
                  <span class="input-group-append">
                    <a href="https://socialpromo.biz/client.php?id=123456780" target="_blank" class="btn btn-dark btn-flat">VIEW NOW</a>
                  </span>
                </div>
                <!-- /.form-group -->
			
                 <button class="m-3 btn btn btn-danger float-right" id="deleteTemplate"><i class="fa-solid fa-trash"></i> Delete</button>		
				 
				 </div><!-- /.card-body -->

				 <div class="card-body p-0">
				 
			<div class="table-responsive">				 				 
                 <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th><input type="checkbox" id="alltemplate" name="delete-all" value="template" id="" title="select all"></th>
                    <th>No</th>
					<th>Group</th>
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
					<th>Group</th>
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

            </div>
            <!-- /.card -->

		</div><!-- /.col-md-12 -->
	  </div><!-- /.row -->

                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-one-campaigns" role="tabpanel" aria-labelledby="custom-tabs-one-campaigns-tab">

<div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
	
	       <!--------------------------------------------------------------------------- DRIP CAMPAIGN --------------------------------------------------------------------------->
	
			<div class="card card-white">
              <div class="card-header">
                <h3 class="card-title">Drip Campaigns</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
				
                <div class="form-group">
                   <label for="InputTime">Select Type</label>
                  <select class="form-control" id="type">
                    <option>Email</option>
                    <option>SMS</option>
                    <option>Push</option>	
                    <option>Whatsapp</option>
					<option>RSS</option>
					<option>Social</option>
                  </select>
                </div>
                <!-- /.form-group -->				
				
                  <div class="form-group">
                    <label for="InputGroup">Select Days</label>
					
					<div class="weekDays-selector">
					  <input type="checkbox" name="days" id="weekday-mon" value="Monday" class="weekday" />
					  <label for="weekday-mon">M</label>
					  <input type="checkbox" name="days" id="weekday-tue" value="Tuesday" class="weekday" />
					  <label for="weekday-tue">T</label>
					  <input type="checkbox" name="days" id="weekday-wed" value="Wednesday" class="weekday" />
					  <label for="weekday-wed">W</label>
					  <input type="checkbox" name="days" id="weekday-thu" value="Thursday" class="weekday" />
					  <label for="weekday-thu">T</label>
					  <input type="checkbox" name="days" id="weekday-fri" value="Friday" class="weekday" />
					  <label for="weekday-fri">F</label>
					  <input type="checkbox" name="days" id="weekday-sat" value="Saturday" class="weekday" />
					  <label for="weekday-sat">S</label>
					  <input type="checkbox" name="days" id="weekday-sun" value="Sunday" class="weekday" />
					  <label for="weekday-sun">S</label>
					</div>							
				
                  </div>
				  
                <div class="form-group">
                   <label for="InputTime">Select Time</label>
                  <select class="form-control" id="time">
                    <option value="09:00">9am - Morning</option>
                    <option value="13:00">1pm - Lunch</option>
                    <option value="17:00">5pm - Afternoon</option>
                    <option value="20:00">8pm - Evening</option>					
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group" id="selectContainer">
                   <label for="InputGroup">Select Group</label>
                  <select class="duallistbox" multiple="multiple">
                    <?php foreach ($groups as $key => $group):?>
                    <option><?=$group?></option>
                   <?php endforeach;?> 
                    <!--option>Promo</option>
                    <option>Bookings</option>
                    <option>Rewards</option-->
                  </select>
                </div>
                <!-- /.form-group -->
				  				
								</div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="btnCampaign">Submit</button>
                </div>
              </form>
            </div>
			
	       <!------------------------------------------------------------------------- BIRTHDAY CAMPAIGN ------------------------------------------------------------------------->	
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Birthday Campaigns</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">

                <div class="form-group">
                   <label for="InputTime">Select Type</label>
                  <select class="form-control" id="birthtype">
                    <option>Email</option>
                    <option>SMS</option>			
                    <option>Whatsapp</option>
                    <option>Push</option>
                  </select>
                </div>
                <!-- /.form-group -->	
			  
                <div class="form-group">
                   <label for="InputTime">Select Time</label>
                  <select class="form-control" id="birthtime">
                  <option value="09:00">9am - Morning</option>
                    <option value="13:00">1pm - Lunch</option>
                    <option value="17:00">5pm - Afternoon</option>
                    <option value="20:00">8pm - Evening</option>				
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group" id="birth-selectContainer">
                   <label for="InputGroup">Select Group</label>
                  <select class="duallistbox" multiple="multiple">
                  <?php foreach ($groups as $key => $group):?>
                    <option><?=$group?></option>
                   <?php endforeach;?> 
                  </select>
                </div>
                <!-- /.form-group -->
				  				
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="birtbtnCampaign">Submit</button>
                </div>
              </form>
            </div>
			
	       <!------------------------------------------------------------------------- BOOKING CAMPAIGN ------------------------------------------------------------------------->	
	
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Booking Reminders</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
				
                <div class="form-group">
                   <label for="InputTime">Select Type</label>
                  <select class="form-control" id="BookingRtype">
                    <option>Email</option>
                    <option>SMS</option>
                    <option>Push</option>	
                    <option>Whatsapp</option>
					<option>RSS</option>
					<option>Social</option>
                  </select>
                </div>
                <!-- /.form-group -->				
							  
                <div class="form-group">
                   <label for="InputBookingTime">Select Time</label>
                  <select class="form-control" id="BookingRTime">
                    <option value="1440">24 hours before</option>
                    <option value="720">12 hours before</option>
                    <option value="360">6 hours before</option>
                    <option value="180">3 hours before</option>
                    <option value="60">1 hour before</option>
                    <option value="30">30 mins before</option>
                    <option value="15">15 mins before</option>
                    <option value="5">5 mins before</option>				
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group" id="Booking_selectContainer">
                   <label for="InputGroup">Select Group</label>
                  <select class="duallistbox" multiple="multiple" id="BookingGroup">
                    <?php foreach ($groups as $key => $group):?>
                    <option><?=$group?></option>
                   <?php endforeach;?> 
                    <!--option>Promo</option>
                    <option>Bookings</option>
                    <option>Rewards</option-->
                  </select>
                </div>
                <!-- /.form-group -->
				  				
								</div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="btnBookingCampaign">Submit</button>
                </div>
              </form>
            </div>
				
	       <!------------------------------------------------------------------------- HOLIDAY CAMPAIGN ------------------------------------------------------------------------->	
					
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Holiday Campaigns</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
				
                <div class="form-group">
                   <label for="InputTime">Select Type</label>
                  <select class="form-control" id="holidaytype">
                    <option>Email</option>
                    <option>SMS</option>
                    <option>Push</option>
                    <option>Whatsapp</option>	
                  </select>
                </div>
                <!-- /.form-group -->	
			  
                <div class="form-group">
                   <label for="InputTime">Select Holiday</label>
                  <select class="form-control select2" id="holidaySelect" style="width: 100%;">
                  
                    <!--option>New Year's Day observed - 2023-01-02</option>
                    <option>2nd January (substitute day) (Scotland) - 2023-01-03</option>
                    <option>Twelfth Night - 2023-01-05</option>
                    <option>Valentine's Day - 2023-02-14</option>
                    <option>Carnival / Shrove Tuesday / Pancake Day - 2023-02-21</option>
                    <option>St Patrick's Day (Northern Ireland) - 2023-03-17</option>
                    <option>Mother's Day - 2023-03-19</option>
                    <option>Daylight Saving Time starts - 2023-03-26</option>
                    <option>Good Friday - 2023-04-07</option>
                    <option>Easter Sunday - 2023-04-09</option>
                    <option>Easter Monday (regional holiday) - 2023-04-10</option>
                    <option>St. George's Day - 2023-04-23</option>
                    <option>Early May Bank Holiday - 2023-05-01</option>
                    <option>Spring Bank Holiday - 2023-05-29</option>
                    <option>Father's Day - 2023-06-18</option>
                    <option>Battle of the Boyne (Northern Ireland) - 2023-07-12</option>
                    <option>Summer Bank Holiday (Scotland) - 2023-08-07</option>
                    <option>Summer Bank Holiday (regional holiday) - 2023-08-28</option>
                    <option>Daylight Saving Time ends - 2023-10-29</option>
                    <option>Halloween - 2023-10-31</option>
                    <option>Guy Fawkes Day - 2023-11-05</option>
                    <option>Remembrance Sunday - 2023-11-12</option>
                    <option>St Andrew's Day (Scotland) - 2023-11-30</option>
                    <option>Christmas Eve - 2023-12-24</option></option>
                    <option>Christmas Day - 2023-12-25</option>
                    <option>Boxing Day - 2023-12-26</option>
                    <option>New Year's Eve - 2023-12-31</option>
                    <option>New Year's Day - 2024-01-01</option>
                    <option>2nd January (Scotland) - 2024-01-02</option>
                    <option>Twelfth Night - 2024-01-05</option>
                    <option>Carnival / Shrove Tuesday / Pancake Day - 2024-02-13</option>
                    <option>Valentine's Day - 2024-02-14</option>
                    <option>Mother's Day - 2024-03-10</option>
                    <option>St Patrick's Day (Northern Ireland) - 2024-03-17</option>
                    <option>Day off for St Patrick's Day (Northern Ireland) - 2024-03-18</option>
                    <option>Good Friday - 2024-03-29</option>
                    <option>Easter Sunday - 2024-03-31</option>
                    <option>Daylight Saving Time starts - 2024-03-31</option>
                    <option>Easter Monday (regional holiday) - 2024-04-01</option>
                    <option>St. George's Day - 2024-04-23</option>
                    <option>Early May Bank Holiday - 2024-05-06</option>
                    <option>Spring Bank Holiday - 2024-05-27</option>
                    <option>Father's Day - 2024-06-16</option>
                    <option>Battle of the Boyne (Northern Ireland) - 2024-07-12</option>
                    <option>Summer Bank Holiday (Scotland) - 2024-08-05</option>
                    <option>Summer Bank Holiday (regional holiday) - 2024-08-26</option>
                    <option>Daylight Saving Time ends - 2024-10-27</option>
                    <option>Halloween - 2024-10-31</option>
                    <option>Guy Fawkes Day - 2024-11-05</option>
                    <option>Remembrance Sunday - 2024-11-10</option>
                    <option>St Andrew's Day (Scotland) - 2024-11-30</option>
                    <option>St Andrew's Day observed (Scotland) - 2024-12-02</option>
                    <option>Christmas Eve - 2024-12-24</option>
                    <option>Christmas Day - 2024-12-25</option>
                    <option>Boxing Day - 2024-12-26</option>
                    <option>New Year's Eve - 2024-12-31</option>
                    <option>The Coronation of King Charles III - 2023-05-06</option>
                    <option>Bank Holiday for the Coronation of King Charles III - 2023-05-08</option>
                    <option>King's Birthday - 2023-06-17</option>
                    <option>King's Birthday - 2024-06-15</option-->				
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="holidaytime">Select Time</label>
                  <select class="form-control" id="holidaytime">
                    <option value="09:00">9am - Morning</option>
                    <option value="13:00">1pm - Lunch</option>
                    <option value="17:00">5pm - Afternoon</option>
                    <option value="20:00">8pm - Evening</option>					
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="holidaymoment">When to send it?</label>
                  <select class="form-control" id="holidaymoment">
                    <option value="day_before">Day before</option>
                    <option value="same_day">Same day</option>
                    <option value="week_before">Week before</option>
                  </select>
                </div>
                <!-- /.form-group -->
				
                <div class="form-group">
                   <label for="holidaygroup">Select Group</label>
                  <select class="form-control select2" style="width: 100%;" id="holidaygroup">
                  <?php foreach ($groups as $key => $group):?>
                    <option value="<?=$group?>"><?=$group?></option>
                   <?php endforeach;?> 
                  </select>
                </div>
                <!-- /.form-group -->	
				  				
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" id="holidaysubmit">Submit</button>
                </div>
              </form>
            </div>
			
	       <!------------------------------------------------------------------------- WEATHER CAMPAIGN ------------------------------------------------------------------------->	
					
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Weather Campaigns</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                <div class="form-group">
                   <label for="weatherType">Select Type</label>
                  <select class="form-control" id="weatherType">
                    <option>Email</option>
                    <option>SMS</option>
                    <option>WhatsApp</option>	
					          <option>Push</option>
                  </select>
                </div>
                <!-- /.form-group -->	
			  
                <div class="form-group">
                   <label for="weatherForecast">Select Forecast</label>
                  <select class="form-control select2" id="weatherForecast" style="width: 100%;">			  
                    <option value="Sunny">Sunny</option>
                    <option value="Cloudy">Cloudy</option>
                    <option value="Rainy">Rainy</option>
                    <option value="Windy">Windy</option>
                    <option value="Snowy">Snowy</option>
                    <option value="Thunder">Thunder</option>
                    <option value="Sleet">Sleet</option>
                    <option value="Flog<">Flog</option>
                    <option value="Tornado">Tornado</option>
                    <option value="Storm">Storm</option>				
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="weatherTime">Select Time</label>
                  <select class="form-control" id="weatherTime">
                    <option value="09:00">9am - Morning</option>
                    <option value="13:00">1pm - Lunch</option>
                    <option value="17:00">5pm - Afternoon</option>
                    <option value="20:00">8pm - Evening</option>					
                  </select>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                   <label for="weatherday">When to send it?</label>
                  <select class="form-control" id="weatherday">
                    <option value="before">Day before</option>
                    <option value="same">Same day</option>
                  </select>
                </div>
                <!-- /.form-group -->
				
                <div class="form-group">
                   <label for="weatherGroup">Select Group</label>
                  <select class="form-control select2" style="width: 100%;" id="weatherGroup">
                  <?php foreach ($groups as $key => $group):?>
                    <option value="<?=$group?>"><?=$group?></option>
                   <?php endforeach;?> 
                  </select>
                </div>
                <!-- /.form-group -->	
				  				
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" id="weatherSubmit"class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
	       <!------------------------------------------------------------------------- ALL CAMPAIGNS ------------------------------------------------------------------------->	

            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">All Campaigns</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button class="mb-3 btn btn btn-danger float-right" id="deleteCampaign"><i class="fa-solid fa-trash"></i> Delete</button>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th><input type="checkbox" id="allcampaign" name="delete-all" title="select all"></th>
                    <th>No</th>
					<th>Type</th>
					<th>Days</th>
					<th>Time</th>
					<th>Group</th>					
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody id="campaignBody">			  
                  <tr>
                    <td>1</td>
					<td>Email</td>
					<td>Monday, Wednesday, Friday</td>
					<td>9am</td>
                    <td>Promo</td>
                    <td>
                          <button class="m-1 btn btn btn-info btn-sm" data-toggle="modal" data-target="#edit-template"><i class="fas fa-pencil-alt"></i> Edit</button>
                          <button class="m-1 btn btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>					
					</td>
                  </tr>
                  <tr>
                    <td>2</td>
					<td>SMS</td>
					<td>Monday, Wednesday, Friday</td>
					<td>1pm</td>
                    <td>Promo</td>
                    <td>
                          <button class="m-1 btn btn btn-info btn-sm" data-toggle="modal" data-target="#edit-template"><i class="fas fa-pencil-alt"></i> Edit</button>
                          <button class="m-1 btn btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>					
					</td>
                  </tr>
                  <tr>
                    <td>3</td>
					<td>Push</td>
					<td>Monday, Wednesday, Friday</td>
					<td>5pm</td>
                    <td>Promo</td>
                    <td>
                          <button class="m-1 btn btn btn-info btn-sm" data-toggle="modal" data-target="#edit-template"><i class="fas fa-pencil-alt"></i> Edit</button>
                          <button class="m-1 btn btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>					
					</td>
                  </tr>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>  </th>
                    <th>No</th>
					<th>Type</th>
					<th>Days</th>
					<th>Time</th>
					<th>Group</th>					
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->


                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">

        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
		  
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Promo Domain</h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>The base folder where all your plugins are stored.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputSocialSearchURL">Domain </label>
				    <input id="InputSocialSearchURL" type="url" name="Domain" class="form-control" placeholder="Enter Domain">
                  </div>				
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		  
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Social Search API - <a href="https://socialpromo.biz" target="_blank"><u>GET API KEY</u></a></h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Search social media sites using keywords.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputSocialSearchURL">Search API URL</label>
				    <input id="InputSocialSearchURL" type="url" name="URL" class="form-control" placeholder="Enter Search URL">
                  </div>				
                  <div class="form-group">
                    <label for="InputSocialSearchAPI">Search API Key</label>
				    <input id="InputSocialSearchAPI" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                  <div class="form-group">
                    <label for="InputSocialSearchKeywords">Search Max Keywords</label>
				    <input id="InputSocialSearchKeywords" type="number" min="1" max="5" name="Search Max Keywords" class="form-control" placeholder="Enter Search Max Keywords">
                  </div>				  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Location API - <a href="https://ipdata.co/" target="_blank"><u>GET API KEY</u></a></h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Gets users location from IP address.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputLocationAPI">API Key</label>
				    <input id="InputLocationAPI" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		  
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Numbervalidte API - <a href="https://numvalidate.com" target="_blank"><u>GET API KEY</u></a></h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Validate and format a phone number when user submits the form.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputNumbervalidte">API Key1</label>
				    <input id="InputNumbervalidte" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                  <div class="form-group">
                    <label for="InputNumbervalidte2">API Key2</label>
				    <input id="InputNumbervalidte2" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                  <div class="form-group">
                    <label for="InputNumbervalidte3">API Key3</label>
				    <input id="InputNumbervalidte3" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
	
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Email Settings </h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Sends email for user to verify their email address. Status changes to "Verified" in leads. It also allows you to send email campaigns.</small></h3>
              </div>
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputAddress">Address</label>
				    <input id="InputAddress" type="text" name="address" class="form-control" placeholder="Enter Address">
                  </div>
                  <div class="form-group">
                    <label for="InputName">Name</label>
				    <input id="InputName" type="text" name="name" class="form-control" placeholder="Enter Name">
                  </div>				  
                  <div class="form-group">
                    <label for="InputSubject">Subject</label>
				    <input id="InputSubject" type="text" name="subject" class="form-control" placeholder="Enter Subject">
                  </div>
                  <div class="form-group">
                    <label for="InpuUsername">Username</label>
				    <input id="InputUsername" type="text" name="username" class="form-control" placeholder="Enter Username">
                  </div>
                  <div class="form-group">
                    <label for="InputTitle">Password</label>
				    <input id="InputPassword" type="text" name="password" class="form-control" placeholder="Enter Password">
                  </div>
                  <div class="form-group">
                    <label for="InputTitle">Host</label>
				    <input id="InputHost" type="text" name="host" class="form-control" placeholder="Enter Host">
                  </div>
                  <div class="form-group">
                    <label for="InputTitle">Port</label>
				    <input id="InputPort" type="text" name="port" class="form-control" placeholder="Enter Port">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">SMS / WhatsApp Settings </h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Sends SMS for user to verify their phone number. Status changes to "Verified" in leads. It also allows you to send SMS and WhatsApp campaigns.</small></h3>
              </div>
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputTwilo_ssid">Twilio SSID</label>
				    <input id="InputTwilio_ssid" type="text" name="Twilio_ssid" class="form-control" placeholder="Enter Twilio SSID">
                  </div>
                  <div class="form-group">
                    <label for="InputTwilio_token">Twilio Token</label>
				    <input id="InputTwilio_token" type="text" name="Twilio_token" class="form-control" placeholder="Enter Twilio Token">
                  </div>				  
                  <div class="form-group">
                    <label for="InputTwilio_phoneNumber">Twilio Phone Number</label>
				    <input id="InputTwilio_phoneNumber" type="text" name="Twilio_phoneNumber" class="form-control" placeholder="Enter Twilio Phone Number">
                  </div>
                  <div class="form-group">
                    <label for="InpuTwilio_whatsapp_sender">Twilio Whatsapp Sender Number</label>
				    <input id="InputTwilio_whatsapp_sender" type="text" name="Twilio_whatsapp_sender" class="form-control" placeholder="Enter Twilio Whatsapp Sender Number">
                  </div>
                  <div class="form-group">
                    <label for="InpuTwilio_smsMessage">Twilio SMS Message</label>
				    <input id="InputTwilio_smsMessage" type="text" name="Twilio_smsMessage" class="form-control" placeholder="Enter SMS message">
                  </div>				  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Weather Promotions - <a href="https://api.api-ninjas.com" target="_blank"><u>GET API KEY</u></a></h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Get weather forecast to send promotions.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputWeatherAPI">API Key</label>
				    <input id="InputWeatherAPI" type="text" name="API Key" class="form-control" placeholder="Enter API Key">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Holiday Promotions (Google Calendar) - <a href="https://www.googleapis.com/calendar" target="_blank"><u>GET API KEY</u></a></h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Get holiday dates to send promotions.</small></h3>
              </div>
			  <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="calendar_api_key">Calendar API Key</label>
				    <input id="calendar_api_key" type="text" name="API Key" class="form-control" placeholder="Calendar API Key">
                  </div>
                  <div class="form-group">
                    <label for="country">Country</label>
				    <input id="country" type="text" name="API Key" class="form-control" placeholder="Country">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <!--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>-->
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
			  <!-- card-header -->
              <div class="card-header">
                <h3 class="card-title">User Alerts</h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Sends users SMS alert messages.</small></h3>
              </div>			  
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="smsMessage">SMS Message</label>
				    <input id="smsMessage" type="text" name="smsMessage" class="form-control" placeholder="Enter User SMS Message">
                  </div>
                  <div class="form-group">
                    <label for="emailMessage">User Email Message</label>
				    <textarea class="form-control form-control-lg" rows="5" placeholder="Enter email message">
<p>Hi {NAME}</p>

<p>Congratulations for earning 100 points in the promotion, please review your answers, if any are incorrect, re-take the promotion so we can send you the offer.</p>

<b>Your Social Profile:</b><br>
{WEBSITE}<br><br>

<b>Your Mobile Number:</b><br>
{PHONE}<br><br>';

{QUESTIONS}

<hr>

<p><b>Click below to confirm your answers to get regular rewards!</b>

<p>{CONFIRM SLIDE}</p>

<p>Best regards,</p>

<p>Social Promo</p>						
						
				   </textarea>
                  </div>				  				  
                  <div class="form-group">
                    <label for="smsbookingMessage">User Booking SMS Message</label>
				    <input id="smsbookingMessage" type="text" name="smsbookingMessage" class="form-control" placeholder="Enter User Booking SMS Message">
                  </div>
                  <div class="form-group">
                    <label for="smsbookingMessage">User Booking Email Message</label>
				    <textarea class="form-control form-control-lg" rows="5" placeholder="Enter email message">
<p>Hi {NAME}</p>

<p>Thanks for booking {SERVICE}, please review your booking data.</p>

<b>Your Social Profile:</b><br>
{WEBSITE}<br><br>

<b>Your Mobile Number:</b><br>
{PHONE}<br><br>';

<b>Your Booking Date and Time :</b><br>
{BOOKING}<br><br>';

<hr>

<p><b>Click below to confirm your booking!</b>

<p>{BOOKING CONFIRM SLIDE}</p>

<p>Best regards,</p>

<p>Social Promo</p>						
						
				   </textarea>
                  </div>
                  <div class="form-group">
                    <label for="alerttitle">Share Title Alert</label>
				    <input id="alerttitle" type="text" name="alerttitle" class="form-control" placeholder="Share Title">
                  </div>	
                  <div class="form-group">
                    <label for="alerttext">Share Text Alert</label>
				    <input id="alerttext" type="text" name="alerttext" class="form-control" placeholder="Share Text">
                  </div>				  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
			  <!-- card-header -->
              <div class="card-header">
                <h3 class="card-title">Admin Alert</h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Sends admin email and SMS of new leads.</small></h3>
              </div>			  
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <p><label for="InputSend_email_alert">Send Email Alert</label></p>
				    <p><input type="checkbox" name="my-checkbox" checked data-bootstrap-switch></p>
                  </div>
                  <div class="form-group">
                    <label for="InputEmail_address">Email Address</label>
				    <p><input id="InputEmail_address" type="text" name="email_address" class="form-control" placeholder="Enter Email Address"></p>
					<p><input id="InputEmail_address2" type="text" name="email_address" class="form-control" placeholder="Enter Email Address"></p>
					<p><input id="InputEmail_address3" type="text" name="email_address" class="form-control" placeholder="Enter Email Address"></p>
                  </div>				  
                  <div class="form-group">
                    <p><label for="InputTwilio_phoneNumber">Send SMS Alert</label></p>
				    <p><input type="checkbox" name="my-checkbox" checked data-bootstrap-switch></p>
                  </div>
                  <div class="form-group">
                    <label for="InpuSms_phoneNumber">SMS Phone Number</label>
				    <p><input id="InputSms_phoneNumber" type="text" name="sms_phoneNumber" class="form-control" placeholder="Enter SMS Phone Number"></p>
					<p><input id="InputSms_phoneNumber2" type="text" name="sms_phoneNumber2" class="form-control" placeholder="Enter SMS Phone Number"></p>
					<p><input id="InputSms_phoneNumber3" type="text" name="sms_phoneNumber3" class="form-control" placeholder="Enter SMS Phone Number"></p>
                  </div>
                  <div class="form-group">
                    <label for="InputAdmin_Message">Admin Alert Message</label>
				    <input id="InputAdmin_Message" type="text" name="InputAdmin_Message" class="form-control" placeholder="Enter Admin Alert Message">
                  </div>	
                  <div class="form-group">
                    <label for="InputAdmin_BookingMessage">Admin Booking Alert Message</label>
				    <input id="InputAdmin_BookingMessage" type="text" name="InputAdmin_BookingMessage" class="form-control" placeholder="Enter Admin Booking Alert Message">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->			
              <div class="card-header">
                <h3 class="card-title">Firebase Push Notifications </h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>Sends Firebase push notifications to verify their subscription. It also allows you to send push messages anytime.</small></h3>
              </div>
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputApiKey_PushNotification">ApiKey</label>
				    <input id="InputApiKey_PushNotification" type="text" name="ApiKey_PushNotification" class="form-control" placeholder="Enter ApiKey_PushNotification">
                  </div>
                  <div class="form-group">
                    <label for="InputAuthDomain">AuthDomain</label>
				    <input id="InputAuthDomain" type="text" name="AuthDomain" class="form-control" placeholder="Enter AuthDomain">
                  </div>				  
                  <div class="form-group">
                    <label for="InputProjectID">ProjectID</label>
				    <input id="InputProjectID" type="text" name="ProjectID" class="form-control" placeholder="Enter ProjectID">
                  </div>
                  <div class="form-group">
                    <label for="InpuStorageBucket">StorageBucket</label>
				    <input id="InputStorageBucket" type="text" name="StorageBucket" class="form-control" placeholder="Enter StorageBucket">
                  </div>
                  <div class="form-group">
                    <label for="InputMessagingSenderId">MessagingSenderId</label>
				    <input id="InputMessagingSenderId" type="text" name="MessagingSenderId" class="form-control" placeholder="Enter MessagingSenderId">
                  </div>
                  <div class="form-group">
                    <label for="InputAppId">AppId</label>
				    <input id="InputAppId" type="text" name="AppId" class="form-control" placeholder="Enter AppId">
                  </div>
                  <div class="form-group">
                    <label for="InputMeasuretId">MeasuretId</label>
				    <input id="InputMeasuretId" type="text" name="MeasuretId" class="form-control" placeholder="Enter MeasuretIdt">
                  </div>
                  <div class="form-group">
                    <label for="InputServerKey">ServerKey</label>
				    <input id="InputServerKey" type="text" name="ServerKey" class="form-control" placeholder="Enter ServerKey">
                  </div>
                  <div class="form-group">
                    <label for="InputKeyPair">KeyPair</label>
				    <input id="InputKeyPair" type="text" name="KeyPair" class="form-control" placeholder="Enter KeyPair">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<div class="card card-info">
              <!-- card-header -->
			  <div class="card-header">
                <h3 class="card-title">Push Settings</h3>
              </div>
              <!-- card-header -->
              <div class="card-header bg-light">
                <h3 class="card-title"><small>These are push content for first welcome message.</small></h3>
              </div>
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="titleNotification">Title Notification</label>
				    <input id="titleNotification" type="text" name="titleNotification" class="form-control" placeholder="Enter Title Notification">
                  </div>
                  <div class="form-group">
                    <label for="bodyNotification">Body Notification</label>
				    <input id="bodyNotification" type="text" name="bodyNotification" class="form-control" placeholder="Enter Body Notification">
                  </div>				  
                  <div class="form-group">
                    <label for="iconNotification">Icon URL</label>
				    <input id="iconNotification" type="text" name="iconNotification" class="form-control" placeholder="Enter Icon URL">
                  </div>
                  <div class="form-group">
                    <label for="imageNotification">Image URL</label>
				    <input id="imageNotification" type="text" name="imageNotification" class="form-control" placeholder="Enter Image URL">
                  </div>
                  <div class="form-group">
                    <label for="InputMessagingSenderId2">MessagingSenderId</label>
				    <input id="InputMessagingSenderId2" type="text" name="MessagingSenderId" class="form-control" placeholder="Enter MessagingSenderId">
                  </div>
                  <div class="form-group">
                    <label for="click_action">Click Action URL</label>
				    <input id="click_action" type="text" name="click_action" class="form-control" placeholder="Enter Click Action">
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			<!--<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Points & Delays</h3>
              </div>
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InpuDownloadPoints">Download Points</label>
				    <input id="InputDownloadPoints" type="number" min="1" max="50" name="Download" class="form-control" placeholder="Enter Download Points">
                  </div>
                  <div class="form-group">
                    <label for="InputVisitPoints">Visit Points</label>
				    <input id="InputVisitPoints" type="number" min="1" max="50" name="Visit" class="form-control" placeholder="Enter Visit Points">
                  </div>				  
                  <div class="form-group">
                    <label for="InputVisitDelay">Visit Delay</label>
					<input id="InputVisitDelay" type="number" min="1" max="50" name="VisitDelay" class="form-control" placeholder="Enter Visit Delay">					
                  </div>				  							  
                  <div class="form-group">
                    <label for="InputPuzzlePoints">Puzzle Points</label>
				    <input id="InputPuzzlePoints" type="number" min="1" max="50" name="Puzzle" class="form-control" placeholder="Enter Puzzle Points">
                  </div>
                  <div class="form-group">
                    <label for="InputVideoPoints">Video Points</label>
				    <input id="InputVideoPoints" type="number" min="1" max="50" name="Video" class="form-control" placeholder="Enter Video Points">
                  </div>
                  <div class="form-group">
                    <label for="InputVideoDelay">Video Delay</label>
				    <input id="InputVideoDelay" type="number" min="1" max="50" name="VideoDelay" class="form-control" placeholder="Enter Video Delay">
                  </div>	
                  <div class="form-group">
                    <label for="InputVideoYoutube">Video (YouTube)</label>
				    <input id="InputVideoYoutube" type="text" name="VideoYoutube" class="form-control" placeholder="Enter Youtube Video ID">
                  </div>
                  <div class="form-group">
                    <label for="InputVideoHTML5">Video (HTML5)</label>
				    <input id="InputVideoHTML5" type="text" name="VideoHTML5" class="form-control" placeholder="Enter HTML5 Video link">
                  </div>				  
                  <div class="form-group">
                    <label for="InpuSurveyPoints">Survey Points</label>
				    <input id="InputSurveyPoints" type="number" min="1" max="50" name="Survey" class="form-control" placeholder="Enter Survey Points">
                  </div>
                  <div class="form-group">
                    <label for="InputSharPointse">Share Points</label>
				    <p><input id="InputSharePoints" type="number" min="1" max="50" name="MessagingShare" class="form-control" placeholder="Enter Share Points"><p>
                  </div>			  
                  <div class="form-group">
                    <label for="InputSharPointse">Share Delay</label>
				    <input id="InputShareDelay" type="number" min="1" max="50" name="ShareDelay" class="form-control" placeholder="Enter Share Delay">
				  </div>			  			  
                </div>
                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>-->
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Confirm Slides</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="confirmSlide">Confirm Slide</label>
				    <input id="confirmSlide" type="number" min="1" max="50" name="confirmSlide" class="form-control" placeholder="Enter Confirm Slide">
                  </div>
                  <div class="form-group">
                    <label for="giftslide">Gift Slide</label>
				    <input id="giftslide" type="number" min="1" max="50" name="giftslide" class="form-control" placeholder="Enter Gift Slide">
                  </div>
                  <div class="form-group">
                    <label for="bookingslide">Booking Slide</label>
				    <input id="bookingslide" type="number" min="1" max="50" name="bookingslide" class="form-control" placeholder="Enter Booking Slide">
                  </div>
                  <div class="form-group">
                    <label for="afterbookingslide">After Booking Slide</label>
				    <input id="afterbookingslide" type="number" min="1" max="50" name="afterbookingslide" class="form-control" placeholder="Enter After Booking Slide">
                  </div>				  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
			
          </div>
          <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

                  </div>			  
				  
                  <div class="tab-pane fade" id="custom-tabs-one-plugins" role="tabpanel" aria-labelledby="custom-tabs-one-plugins-tab">

        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
	
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">API Key</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="InputAPI">Promo API Key</label>
				    <input id="InputAPI" type="text" name="group" class="form-control form-control-lg" placeholder="Enter API key">
					<p>Enter your API key to create actions for the promotion then select the action below for options. <a href="#">Get API key?</a></p>
                  </div>				  				
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
			
            <!-- TO DO List -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="ion ion-clipboard mr-1"></i>
                  Order Actions
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <p>Drag and move actions in the order you want them in the promotion.</p>
			  
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                  <li>
                    <!-- drag handle -->
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo1" id="todoCheck1">
                      <label for="todoCheck1"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">Download</span>
                    <!-- Emphasis label -->
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
					<!-- todo text --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo2" id="todoCheck2">
                      <label for="todoCheck2"></label>
                    </div>
					<!-- todo text -->
                    <span class="text">Puzzle</span>
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
					<!-- todo text --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo3" id="todoCheck3">
                      <label for="todoCheck3"></label>
                    </div>
					<!-- todo text -->
                    <span class="text">Video</span>
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
					<!-- todo text --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo4" id="todoCheck4">
                      <label for="todoCheck4"></label>
                    </div>
					<!-- todo text -->
                    <span class="text">Survey</span>
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
					<!-- todo text --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo5" id="todoCheck5">
                      <label for="todoCheck5"></label>
                    </div>
					<!-- todo text -->
                    <span class="text">Memory Game</span>
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                  <li>
                    <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
					<!-- todo text --
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo6" id="todoCheck6">
                      <label for="todoCheck6"></label>
                    </div>
					<!-- todo text -->
                    <span class="text">Embed Game</span>
                    <small class="badge badge-danger"><i class="fa-solid fa-trophy"></i> 10 Points</small>
                    <div class="tools">
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-trash"></i>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
            <!-- /.card -->		
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Actions & Plugins</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                <div class="card-body">
				<p>Limit actions to 5 only to encourage visitors to complete your promotion.</p>
				  
<div class="expanding-grid">
	
<input type="search" id="filterNetwork" class="form-control" placeholder="Filter action">

	<ul class="links" id="myList">
		<li><a class="rounded text-white" id="promo" href="#advert"><i class="fa-brands fa-adversal fa-2xl pb-4 mb-2"></i><br><small>Advert Visit</small></a></li>
		<li><a class="rounded text-white" id="amazon" href="#amazon-follow"><i class="fa-brands fa-amazon fa-2xl pb-4 mb-2"></i><br><small>Amazon Follow</small></a></li>
		<li><a class="rounded text-white" id="amazon" href="#amazon-review"><i class="fa-brands fa-amazon fa-2xl pb-4 mb-2"></i><br><small>Amazon Review</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#birthday-campaigns"><i class="fa-solid fa-cake-candles fa-2xl pb-4 mb-2"></i><br><small>Birthday Campaigns</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#download"><i class="fa-solid fa-download fa-2xl pb-4 mb-2"></i><br><small>Download</small></a></li>
		<li><a class="rounded text-white" id="ebay" href="#ebay-save"><i class="fa-brands fa-ebay fa-2xl pb-4 mb-2"></i><br><small>Ebay Save/Share</small></a></li>
		<li><a class="rounded text-white" id="ebay" href="#ebay-review"><i class="fa-brands fa-ebay fa-2xl pb-4 mb-2"></i><br><small>Ebay Review</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#email-campaigns"><i class="fa-solid fa-envelope fa-2xl pb-4 mb-2"></i><br><small>Email Campaigns</small></a></li>
		<li><a class="rounded text-white" id="etsy" href="#etsy-follow"><i class="fa-brands fa-etsy fa-2xl pb-4 mb-2"></i><br><small>Etsy Follow</small></a></li>
		<li><a class="rounded text-white" id="facebook" href="#facebook-checkin"><i class="fa-brands fa-facebook fa-2xl pb-4 mb-2"></i><br><small>Facebook Check-in</small></a></li>
		<li><a class="rounded text-white" id="facebook" href="#facebook-share"><i class="fa-brands fa-facebook fa-2xl pb-4 mb-2"></i><br><small>Facebook Share</small></a></li>		
		<li><a class="rounded text-white" id="facebook" href="#facebook-recommend"><i class="fa-brands fa-facebook fa-2xl pb-4 mb-2"></i><br><small>Facebook Recommend</small></a></li>
		<li><a class="rounded text-white" id="facebook" href="#facebook-follow"><i class="fa-brands fa-facebook fa-2xl pb-4 mb-2"></i><br><small>Facebook Like/Follow</small></a></li>
		<li><a class="rounded text-white" id="facebook" href="#facebook-comment"><i class="fa-brands fa-facebook fa-2xl pb-4 mb-2"></i><br><small>Facebook Comment</small></a></li>	
		<li><a class="rounded text-white" id="promo" href="#game"><i class="fa-solid fa-gamepad fa-2xl pb-4 mb-2"></i><br><small>Game</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#holiday-campaigns"><i class="fa-solid fa-calendar-days fa-2xl pb-4 mb-2"></i><br><small>Holiday Campaigns</small></a></li>
		<li><a class="rounded text-white" id="instagram" href="#instagram-follow"><i class="fa-brands fa-instagram fa-2xl pb-4 mb-2"></i><br><small>Instagram Follow</small></a></li>
		<li><a class="rounded text-white" id="instagram" href="#instagram-like"><i class="fa-brands fa-instagram fa-2xl pb-4 mb-2"></i><br><small>Instagram Like</small></a></li>
		<li><a class="rounded text-white" id="instagram" href="#instagram-comment"><i class="fa-brands fa-instagram fa-2xl pb-4 mb-2"></i><br><small>Instagram Comment</small></a></li>
		<li><a class="rounded text-white" id="instagram" href="#instagram-share"><i class="fa-brands fa-instagram fa-2xl pb-4 mb-2"></i><br><small>Instagram Share</small></a></li>	
		<li><a class="rounded text-white" id="linkedin" href="#linkedin-follow"><i class="fa-brands fa-linkedin fa-2xl pb-4 mb-2"></i><br><small>LinkedIn Follow</small></a></li>
		<li><a class="rounded text-white" id="linkedin" href="#linkedin-share"><i class="fa-brands fa-linkedin fa-2xl pb-4 mb-2"></i><br><small>LinkedIn Share</small></a></li>
		<li><a class="rounded text-white" id="pinterest" href="#pinterest-follow"><i class="fa-brands fa-pinterest fa-2xl pb-4 mb-2"></i><br><small>Pinterest Follow</small></a></li>
		<li><a class="rounded text-white" id="pinterest" href="#pinterest-share"><i class="fa-brands fa-pinterest fa-2xl pb-4 mb-2"></i><br><small>Pinterest Share/Send</small></a></li>	
		<li><a class="rounded text-white" id="pinterest" href="#pinterest-comment"><i class="fa-brands fa-pinterest fa-2xl pb-4 mb-2"></i><br><small>Pinterest Like/Comment</small></a></li>	
		<li><a class="rounded text-white" id="promo" href="#push-camapigns"><i class="fa-solid fa-bell fa-2xl pb-4 mb-2"></i><br><small>Push Camapigns</small></a></li>	
		<li><a class="rounded text-white" id="promo" href="#scratch-card"><i class="fa-solid fa-gift fa-2xl pb-4 mb-2"></i><br><small>Scratch Card</small></a></li>	
		<li><a class="rounded text-white" id="promo" href="#sms-campaigns"><i class="fa-solid fa-comment-sms fa-2xl pb-4 mb-2"></i><br><small>SMS Campaigns</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#spin-wheel"><i class="fa-solid fa-life-ring fa-2xl pb-4 mb-2"></i><br><small>Spin Wheel</small></a></li>		
		<li><a class="rounded text-white" id="promo" href="#survey-poll"><i class="fa-solid fa-clipboard-question fa-2xl pb-4 mb-2"></i><br><small>Survey or Poll</small></a></li>
		<li><a class="rounded text-white" id="tiktok" href="#tiktok-follow"><i class="fa-brands fa-tiktok fa-2xl pb-4 mb-2"></i><br><small>TikTok Follow/Like</small></a></li>
		<li><a class="rounded text-white" id="tiktok" href="#tiktok-comment"><i class="fa-brands fa-tiktok fa-2xl pb-4 mb-2"></i><br><small>TikTok Comment/Share</small></a></li>
		<li><a class="rounded text-white" id="twitter" href="#twitter-follow"><i class="fa-brands fa-twitter fa-2xl pb-4 mb-2"></i><br><small>Twitter Follow/Like</small></a></li>
		<li><a class="rounded text-white" id="twitter" href="#twitter-retweet"><i class="fa-brands fa-twitter fa-2xl pb-4 mb-2"></i><br><small>Twitter Retweet/Repost</small></a></li>
		<li><a class="rounded text-white" id="twitter" href="#twitter-share"><i class="fa-brands fa-twitter fa-2xl pb-4 mb-2"></i><br><small>Twitter Share</small></a></li>
		<li><a class="rounded text-white" id="twitter" href="#twitter-comment"><i class="fa-brands fa-twitter fa-2xl pb-4 mb-2"></i><br><small>Twitter Comment</small></a></li>	
		<li><a class="rounded text-white" id="promo" href="#video-box"><i class="fa-solid fa-video fa-2xl pb-4 mb-2"></i><br><small>Video</small></a></li>
		<li><a class="rounded text-white" id="promo" href="#weather-campaigns"><i class="fa-solid fa-cloud-sun fa-2xl pb-4 mb-2"></i><br><small>Weather Campaigns</small></a></li>
		<li><a class="rounded text-white" id="whatsapp" href="#whatsApp-campigns"><i class="fa-brands fa-whatsapp fa-2xl pb-4 mb-2"></i><br><small>WhatsApp Campigns</small></a></li>
		<li><a class="rounded text-white" id="youtube" href="#youtube-subscribe"><i class="fa-brands fa-youtube fa-2xl pb-4 mb-2"></i><br><small>YouTube Subscribe</small></a></li>
		<li><a class="rounded text-white" id="youtube" href="#youtube-comment"><i class="fa-brands fa-youtube fa-2xl pb-4 mb-2"></i><br><small>YouTube Comment</small></a></li>
		<li><a class="rounded text-white" id="youtube" href="#youtube-like"><i class="fa-brands fa-youtube fa-2xl pb-4 mb-2"></i><br><small>YouTube Like/Share</small></a></li>
	</ul>
	
	<div id="advert" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Advert</h1>
			<p>User visits your advert to earn points</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-brands fa-adversal fa-2xl"></i></div></div>
			
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Advert URL</label>
                    <input id="AdvertAction" type="text" class="form-control" placeholder="Advert URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Advert Image</label>
                    <input id="AdvertImage" type="text" class="form-control" placeholder="Advert Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="AdvertPoints" type="number" min="1" max="10" name="advert" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>

		</article>
	</div>

	<div id="amazon-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Amazon Store Follow</h1>
			<p>User follows your Amazon store to earn points</p>
			<div class="entry-image"><div id="amazon" class="img-placeholder rounded"><i class="fa-brands fa-amazon fa-2xl"></i></div></div>
			
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Amazon URL</label>
                    <input id="AmazonFollowAction" value="https://www.amazon.co.uk/stores/" type="text" class="form-control" placeholder="Amazon Store URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Amazon Store Image <small>- Optional</small></label>
                    <input id="AmazonFollowImage" type="text" class="form-control" placeholder="Amazon Shop Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="AmazonFollowPoints" type="number" min="1" max="10" name="Amazon" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>

		</article>
	</div>
	
	<div id="amazon-review" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Amazon Review</h1>
			<p>User reviews your Amazon product to earn points</p>
			<div class="entry-image"><div id="amazon" class="img-placeholder rounded"><i class="fa-brands fa-amazon fa-2xl"></i></div></div>
			
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Amazon URL</label>
                    <input id="AmazonReviewAction" value="https://www.amazon.co.uk/review/create-review/" type="text" class="form-control" placeholder="Amazon Store URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Amazon Store Image <small>- Optional</small></label>
                    <input id="AmazonReviewImage" type="text" class="form-control" placeholder="Amazon Store Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="AmazonReviewPoints" type="number" min="1" max="10" name="Amazon" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>

		</article>
	</div>
	
	<div id="birthday-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Birthday Campaigns</h1>
			<p>Send birthday promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-cake-candles fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="download" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Download</h1>
			<p>User downloads your app, ebook, menu, etc to earn points</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-download fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Download Image</label>
                    <input id="DownloadImage" type="text" class="form-control" placeholder="Download image"/>							
                  </div>
				  
                  <div class="form-group">
                    <label>Download URL</label>
                    <input id="DownloadAction" type="text" class="form-control" placeholder="Download URL"/>							
                  </div>
				  
				  <div class="form-group">
                        <label>Number of points</label>
                        <input id="DownloadPoints" type="number" min="1" max="10" name="download" class="form-control" placeholder="Enter Points">
                      </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="ebay-save" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Ebay</h1>
			<p>User saves or shares your Ebay shop to earn points</p>
			<div class="entry-image"><div id="ebay" class="img-placeholder rounded"><i class="fa-brands fa-ebay fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Ebay URL</label>
                    <input id="EbaySaveAction" type="text" value="https://stores.ebay.co.uk/" class="form-control" placeholder="Ebay Shop URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Ebay Image <small>- Optional</small></label>
                    <input id="EbaySaveImage" type="text" class="form-control" placeholder="Ebay Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="EbaySacePoints" type="number" min="1" max="10" name="Ebay" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="ebay-review" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Ebay</h1>
			<p>User reviews your Ebay item to earn points</p>
			<div class="entry-image"><div id="ebay" class="img-placeholder rounded"><i class="fa-brands fa-ebay fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Ebay URL</label>
                    <input id="EbayReviewAction" type="text" value="https://www.ebay.co.uk/urw/write-review/" class="form-control" placeholder="Ebay Shop URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Ebay Image <small>- Optional</small></label>
                    <input id="EbayReviewImage" type="text" class="form-control" placeholder="Ebay Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="EbayReviewPoints" type="number" min="1" max="10" name="Ebay" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="email-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Email Campaigns</h1>
			<p>Send email drip promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-envelope fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="etsy-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Etsy</h1>
			<p>User follows your Etsy shop to earn points</p>
			<div class="entry-image"><div id="etsy" class="img-placeholder rounded"><i class="fa-brands fa-etsy fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Etsy URL</label>
                    <input id="EtsyFollowAction" type="text" value="https://www.etsy.com/uk/shop/" class="form-control" placeholder="Etsy Shop URL"/>							
                  </div>
                  <div class="form-group">
                    <label>Etsy Image <small>- Optional</small></label>
                    <input id="EtsyFollowImage" type="text" class="form-control" placeholder="Etsy Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="EtsyFollowPoints" type="number" min="1" max="10" name="Etsy" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="facebook-checkin" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Facebook Check-in</h1>
			<p>User check-ins into your business to earn points</p>
			<div class="entry-image"><div id="facebook" class="img-placeholder rounded"><i class="fa-brands fa-facebook fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Facebook Page Name</label>					
                    <input id="FacebookCheckinAction" type="text" class="form-control" placeholder="Facebook Page Name"/>		
				    <input id="FacebookCheckinActionUrl" type="text" class="form-control" readonly>																				
                  </div>
                  <div class="form-group">
                    <label>Facebook Image <small>- Optional</small></label>
                    <input id="FacebookCheckinImage" type="text" class="form-control" placeholder="Facebook Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="FacebookCheckinPoints" type="number" min="1" max="10" name="Facebook" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="facebook-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Facebook Like/Follow</h1>
			<p>User likes or follows your Facebook page to earn points</p>
			<div class="entry-image"><div id="facebook" class="img-placeholder rounded"><i class="fa-brands fa-facebook fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Facebook Page</label>
                    <input id="FacebookFollowAction" type="text" class="form-control" placeholder="Facebook Page Name"/>		
				    <input id="FacebookFollowActionUrl" type="text" class="form-control" readonly>								
                  </div>
                  <div class="form-group">
                    <label>Facebook Image <small>- Optional</small></label>
                    <input id="FacebookFollowImage" type="text" class="form-control" placeholder="Facebook Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="FacebookFollowPoints" type="number" min="1" max="10" name="Facebook" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="facebook-share" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Facebook Share</h1>
			<p>User shares your Facebook page to earn points</p>
			<div class="entry-image"><div id="facebook" class="img-placeholder rounded"><i class="fa-brands fa-facebook fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Facebook Page</label>
                    <input id="FacebookShareAction" type="text" class="form-control" placeholder="Facebook Page Name"/>		
				    <input id="FacebookShareActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Facebook Image <small>- Optional</small></label>
                    <input id="FacebookShareImage" type="text" class="form-control" placeholder="Facebook Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="FacebookSharePoints" type="number" min="1" max="10" name="Facebook" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="facebook-recommend" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Facebook Recommend</h1>
			<p>User recommends your Facebook page to earn points</p>
			<div class="entry-image"><div id="facebook" class="img-placeholder rounded"><i class="fa-brands fa-facebook fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Facebook Page</label>
                    <input id="FacebookRecommendAction" type="text" class="form-control" placeholder="Facebook Page Name"/>		
				    <input id="FacebookRecommendActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Facebook Image <small>- Optional</small></label>
                    <input id="FacebookRecommendImage" type="text" class="form-control" placeholder="Facebook Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="FacebookRecommendPoints" type="number" min="1" max="10" name="Facebook" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="facebook-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Facebook Comment</h1>
			<p>User comments on your Facebook post to earn points</p>
			<div class="entry-image"><div id="facebook" class="img-placeholder rounded"><i class="fa-brands fa-facebook fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Facebook URL</label>
                    <input id="FacebookCommentAction" type="text" class="form-control" placeholder="Facebook Page Name"/>		
				    <input id="FacebookCommentActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Facebook Image <small>- Optional</small></label>
                    <input id="FacebookCommentImage" type="text" class="form-control" placeholder="Facebook Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="FacebookCommentPoints" type="number" min="1" max="10" name="Facebook" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="game" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Games</h1>
			<p>User plays a random game to earn points for engagement</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-gamepad fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
               <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Game Delay <small>- how long should they play to get points?</small></label>
                    <input id="GameDelay" type="number" min="10" max="60" name="GameDelay" class="form-control" placeholder="Enter Delay">			
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="GamePoints" type="number" min="1" max="10" name="GamePoints" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="holiday-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Holiday Campaigns</h1>
			<p>Send Holiday promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-cake-candles fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="instagram-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Instagram Follow</h1>
			<p>User follows your Instagram page to earn points</p>
			<div class="entry-image"><div id="instagram" class="img-placeholder rounded"><i class="fa-brands fa-instagram fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Instagram Page</label>
                    <input id="InstagramFollowAction" type="text" class="form-control" placeholder="Instagram Page Name"/>		
				    <input id="InstagramFollowActionUrl" type="text" class="form-control" readonly>								
                  </div>
                  <div class="form-group">
                    <label>Instagram Image <small>- Optional</small></label>
                    <input id="InstagramFollowImage" type="text" class="form-control" placeholder="Instagram Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="InstagramFollowPoints" type="number" min="1" max="10" name="Instagram" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="instagram-like" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Instagram Like</h1>
			<p>User likes your Instagram post to earn points</p>
			<div class="entry-image"><div id="instagram" class="img-placeholder rounded"><i class="fa-brands fa-instagram fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Instagram Post ID</label>
                    <input id="InstagramLikeAction" type="text" class="form-control" placeholder="Instagram Page Name"/>		
				    <input id="InstagramLikeActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Instagram Image <small>- Optional</small></label>
                    <input id="InstagramLikeImage" type="text" class="form-control" placeholder="Instagram Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="InstagramLikePoints" type="number" min="1" max="10" name="Instagram" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="instagram-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Instagram Comment</h1>
			<p>User comments on your Instagram post to earn points</p>
			<div class="entry-image"><div id="instagram" class="img-placeholder rounded"><i class="fa-brands fa-instagram fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Instagram Post ID</label>
                    <input id="InstagramCommentAction" type="text" class="form-control" placeholder="Instagram Page Name"/>		
				    <input id="InstagramCommentActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Instagram Image <small>- Optional</small></label>
                    <input id="InstagramCommentImage" type="text" class="form-control" placeholder="Instagram Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="InstagramCommentPoints" type="number" min="1" max="10" name="Instagram" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="instagram-share" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Instagram Share</h1>
			<p>User shares on your Instagram post to earn points</p>
			<div class="entry-image"><div id="instagram" class="img-placeholder rounded"><i class="fa-brands fa-instagram fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Instagram Post ID</label>
                    <input id="InstagramShareAction" type="text" class="form-control" placeholder="Instagram Page Name"/>		
				    <input id="InstagramShareActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Instagram Image <small>- Optional</small></label>
                    <input id="InstagramShareImage" type="text" class="form-control" placeholder="Instagram Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="InstagramSharePoints" type="number" min="1" max="10" name="Instagram" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="linkedin-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">LinkedIn Follow</h1>
			<p>User follows your LinkedIn page to earn points</p>
			<div class="entry-image"><div id="linkedin" class="img-placeholder rounded"><i class="fa-brands fa-linkedin fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>LinkedIn Page</label>
                    <input id="LinkedinFollowAction" type="text" class="form-control" placeholder="Linkedin Page Name"/>		
				    <input id="LinkedinFollowActionUrl" type="text" class="form-control" readonly>								
                  </div>
                  <div class="form-group">
                    <label>LinkedIn Image <small>- Optional</small></label>
                    <input id="LinkedinFollowImage" type="text" class="form-control" placeholder="Linkedin Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="LinkedinFollowPoints" type="number" min="1" max="10" name="Linkedin" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="linkedin-share" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">LinkedIn Share</h1>
			<p>User shares your LinkedIn page to earn points</p>
			<div class="entry-image"><div id="linkedin" class="img-placeholder rounded"><i class="fa-brands fa-linkedin fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>LinkedIn Post ID</label>
                    <input id="LinkedinShareAction" type="text" class="form-control" placeholder="Linkedin Page Name"/>		
				    <input id="LinkedinShareActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>LinkedIn Image <small>- Optional</small></label>
                    <input id="LinkedinShareImage" type="text" class="form-control" placeholder="Linkedin Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="LinkedinSharePoints" type="number" min="1" max="10" name="Linkedin" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="pinterest-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Pinterest Follow</h1>
			<p>User follows your Pinterest profile to earn points</p>
			<div class="entry-image"><div id="pinterest" class="img-placeholder rounded"><i class="fa-brands fa-pinterest fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Pinterest Profile</label>
                    <input id="PinterestFollowAction" type="text" class="form-control" placeholder="Pinterest Profile"/>		
				    <input id="PinterestFollowActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Pinterest Image <small>- Optional</small></label>
                    <input id="PinterestFollowImage" type="text" class="form-control" placeholder="Pinterest Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="PinterestFollowPoints" type="number" min="1" max="10" name="Pinterest" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="pinterest-share" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Pinterest Share</h1>
			<p>User shares your Pinterest pin to earn points</p>
			<div class="entry-image"><div id="pinterest" class="img-placeholder rounded"><i class="fa-brands fa-pinterest fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Pinterest Pin ID</label>
                    <input id="PinterestShareAction" type="text" class="form-control" placeholder="Pinterest Pin ID"/>		
				    <input id="PinterestShareActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Pinterest Image <small>- Optional</small></label>
                    <input id="PinterestShareImage" type="text" class="form-control" placeholder="Pinterest Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="PinterestSharePoints" type="number" min="1" max="10" name="Pinterest" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="pinterest-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Pinterest Comment & Like</h1>
			<p>User comment or likes your Pinterest pin to earn points</p>
			<div class="entry-image"><div id="pinterest" class="img-placeholder rounded"><i class="fa-brands fa-pinterest fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Pinterest Pin ID</label>
                    <input id="PinterestCommentAction" type="text" class="form-control" placeholder="Pinterest Pin ID"/>		
				    <input id="PinterestCommentActionUrl" type="text" class="form-control" readonly>							
                  </div>
                  <div class="form-group">
                    <label>Pinterest Image <small>- Optional</small></label>
                    <input id="PinterestCommentImage" type="text" class="form-control" placeholder="Pinterest Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="PinterestCommentPoints" type="number" min="1" max="10" name="Pinterest" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="push-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Push Camapigns</h1>
			<p>Send push promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-bell fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="scratch-card" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Scratch Card</h1>
			<p>User answers scratches card to earn points</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-gift fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">				  				  
				  <div class="form-group">
					<label>Number of cards</label>
					<input id="ScratchNumber" type="number" min="4" max="8" name="Scratch" class="form-control" placeholder="Enter number of cards">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="sms-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">SMS Campaigns</h1>
			<p>Send SMS drip promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-comment-sms fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="survey" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Survey or Poll</h1>
			<p>User answers survey or poll questions to earn points</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-clipboard-question fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Question 1</label>
                    <input id="Question1Action" type="text" class="form-control" placeholder="Question"/>							
                  </div>
                  <div class="form-group">
                    <label>Options</label>
                    <input id="Question1Options1" type="text" class="form-control" placeholder="Option"/>
					<input id="Question1Options2" type="text" class="form-control" placeholder="Option"/>
					<input id="Question1Options3" type="text" class="form-control" placeholder="Option"/>
					<input id="Question1Options4" type="text" class="form-control" placeholder="Option"/>
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="QuestionPoints" type="number" min="1" max="10" name="Survey" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="spin-wheel" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Spin Wheel</h1>
			<p>User spin the wheel to earn points</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-life-ring fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="tiktok-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">TikTok Follow/Like</h1>
			<p>User follows or likes you on TikTok pin to earn points</p>
			<div class="entry-image"><div id="tiktok" class="img-placeholder rounded"><i class="fa-brands fa-tiktok fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>TikTok Profile</label>
                    <input id="TiktokFollowAction" type="text" class="form-control" value="https://www.tiktok.com/@" placeholder="TikTok profile"/>								
                  </div>
                  <div class="form-group">
                    <label>TikTok Image <small>- Optional</small></label>
                    <input id="TiktokFollowImage" type="text" class="form-control" placeholder="TikTok Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TiktokFollowPoints" type="number" min="1" max="10" name="tiktok" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="tiktok-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">TikTok Comment/Share</h1>
			<p>User comments or shares your TikTok video to earn points</p>
			<div class="entry-image"><div id="pinterest" class="img-placeholder rounded"><i class="fa-brands fa-pinterest fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>TikTok Video Link</label>
                    <input id="TiktokCommentAction" type="text" class="form-control" value="https://www.tiktok.com/@" placeholder="TikTok profile"/>							
                  </div>
                  <div class="form-group">
                    <label>TikTok Image <small>- Optional</small></label>
                    <input id="TiktokCommentImage" type="text" class="form-control" placeholder="TikTok Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TiktokCommentPoints" type="number" min="1" max="10" name="tiktok" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="twitter-follow" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Twitter Follow</h1>
			<p>User follows you on Twitter to earn points</p>
			<div class="entry-image"><div id="twitter" class="img-placeholder rounded"><i class="fa-brands fa-twitter fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Twitter Profile</label>
                    <input id="TwitterFollowAction" type="text" class="form-control" value="https://www.twitter.com/" placeholder="Twitter profile"/>							
                  </div>
                  <div class="form-group">
                    <label>Twitter Image <small>- Optional</small></label>
                    <input id="TwitterFollowImage" type="text" class="form-control" placeholder="Twitter Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TwitterFollowPoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="twitter-retweet" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Twitter Retweet/Repost</h1>
			<p>User retweets or reposts to earn points</p>
			<div class="entry-image"><div id="twitter" class="img-placeholder rounded"><i class="fa-brands fa-twitter fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Twitter Post</label>
                    <input id="TwitterRetweetAction" type="text" class="form-control" value="https://www.twitter.com/" placeholder="Twitter post"/>							
                  </div>
                  <div class="form-group">
                    <label>Twitter Image <small>- Optional</small></label>
                    <input id="TwitterRetweetImage" type="text" class="form-control" placeholder="Twitter Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TwitterRetweetPoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="twitter-share" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Twitter Share</h1>
			<p>User shares on Twitter to earn points</p>
			<div class="entry-image"><div id="twitter" class="img-placeholder rounded"><i class="fa-brands fa-twitter fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Twitter Video Link</label>
                    <input id="TwitterShareAction" type="text" class="form-control" placeholder="Twitter profile"/>	
					<input id="TwitterShareActionUrl" type="text" class="form-control" readonly>						
                  </div>
                  <div class="form-group">
                    <label>Twitter Image <small>- Optional</small></label>
                    <input id="TwitterShareImage" type="text" class="form-control" placeholder="Twitter Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TwitterSharePoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="twitter-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Twitter Comment</h1>
			<p>User comments on Twitter video to earn points</p>
			<div class="entry-image"><div id="twitter" class="img-placeholder rounded"><i class="fa-brands fa-twitter fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Twitter Post</label>
                    <input id="TwitterCommentAction" type="text" class="form-control" value="https://www.twitter.com/" placeholder="Twitter post"/>							
                  </div>
                  <div class="form-group">
                    <label>Twitter Image <small>- Optional</small></label>
                    <input id="TwitterCommentImage" type="text" class="form-control" placeholder="Twitter Image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="TwitterCommentPoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="video-box" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Video</h1>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-video fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>Video Link</label>
                    <input id="VideoAction" type="text" class="form-control" placeholder="MP4 Video Link"/>							
                  </div>
                  <div class="form-group">
                    <label>Video Preview Image <small>- Optional</small></label>
                    <input id="VideoImage" type="text" class="form-control" placeholder="Video Preview Image"/>							
                  </div>				  				  				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="weather-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">Weather Campaigns</h1>
			<p>Send weather promotions to leads.</p>
			<div class="entry-image"><div id="promo" class="img-placeholder rounded"><i class="fa-solid fa-cloud-sun fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="weather-campaigns" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">WhatsApp Campigns</h1>
			<p>Send WhatsApp promotions to leads.</p>
			<div class="entry-image"><div id="whatsapp" class="img-placeholder rounded"><i class="fa-brands fa-whatsapp fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>

	<div id="youtube-subscribe" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">YouTube Subscribe</h1>
			<div class="entry-image"><div id="youtube" class="img-placeholder rounded"><i class="fa-brands fa-youtube fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>YouTube Channel ID</label>
                    <input id="YoutubeSubscribeAction" type="text" class="form-control" placeholder="YouTube Channel ID"/>	
					<input id="YoutubeSubscribeActionUrl" type="text" class="form-control" readonly>						
                  </div>
                  <div class="form-group">
                    <label>YouTube Image <small>- Optional</small></label>
                    <input id="YoutubeSubscribeImage" type="text" class="form-control" placeholder="YouTube image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="YoutubeSubscribePoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="youtube-comment" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">YouTube Comment</h1>
			<div class="entry-image"><div id="youtube" class="img-placeholder rounded"><i class="fa-brands fa-youtube fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>YouTube Video ID</label>
                    <input id="YoutubeCommentAction" type="text" class="form-control" placeholder="YouTube Video ID"/>	
					<input id="YoutubeCommentActionUrl" type="text" class="form-control" readonly>						
                  </div>
                  <div class="form-group">
                    <label>YouTube Image <small>- Optional</small></label>
                    <input id="YoutubeCommentImage" type="text" class="form-control" placeholder="YouTube image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="YoutubeCommentPoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
	<div id="youtube-like" class="expanding-container">
		<article class="hentry">
			<h1 class="entry-title">YouTube Like/Share</h1>
			<div class="entry-image"><div id="youtube" class="img-placeholder rounded"><i class="fa-brands fa-youtube fa-2xl"></i></div></div>
			<div class="card bg-transparent">
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label>YouTube Video ID</label>
                    <input id="YoutubeLikeAction" type="text" class="form-control" placeholder="YouTube Video ID"/>	
					<input id="YoutubeLikeActionUrl" type="text" class="form-control" readonly>						
                  </div>
                  <div class="form-group">
                    <label>YouTube Image <small>- Optional</small></label>
                    <input id="YoutubeLikeImage" type="text" class="form-control" placeholder="YouTube image"/>							
                  </div>				  				  
				  <div class="form-group">
					<label>Number of points</label>
					<input id="YoutubeLikePoints" type="number" min="1" max="10" name="Twitter" class="form-control" placeholder="Enter Points">
				  </div>				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
				  <input type="checkbox" name="my-checkbox" data-bootstrap-switch>
                  <button type="submit" class="float-right btn btn-sm btn-primary">Submit</button>
                </div>
              </form>
            </div>
		</article>
	</div>
	
</div>
<!-- partial -->
				  
                </div>
                <!-- /.card-body -->
            </div>		
			
          </div>
          <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>


	</div><!-- /.container-fluid -->
	
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
        <form id="link-data-form">
          <div class="form-group" id="group-form">
				    <label for="InputGroup">1. Select Group</label>
            <select style="width:100%" class="form-control" id="linkfiltergroup" name="filtergroup" onchange="linkfilterchange(this)">
              <option value="">- SELECT GROUP OR RESET-</option>
              <?php
                sort($datagroups);
                foreach ($datagroups as $key => $group):
              ?>
                <option value="<?= $group ?>"><?= $group ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- /.form-group -->

			    <label for="InputData">2. Select data to include</label>
			    <p><small>Only select the data you want to show to client</small></p>
			    <p>
            <ul class="todo-list ui-sortable" data-widget="todo-list" id="data-list">
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="0" name="name" id="todoCheck0">
                  <label for="todoCheck0"></label>
                </div>
                <span class="text">Name</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="1" name="age" id="todoCheck1">
                  <label for="todoCheck1"></label>
                </div>
                <span class="text">Age</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="2" name="website" id="todoCheck2">
                  <label for="todoCheck2"></label>
                </div>
                <span class="text">Website</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="3" name="phone" id="todoCheck3">
                  <label for="todoCheck3"></label>
                </div>
                <span class="text">Phone</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="4" name="email" id="todoCheck4">
                  <label for="todoCheck4"></label>
                </div>
                <span class="text">Email</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="5" name="location" id="todoCheck5">
                  <label for="todoCheck5"></label>
                </div>
                <span class="text">Location</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="6" name="date" id="todoCheck6">
                  <label for="todoCheck6"></label>
                </div>
                <span class="text">Date</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="7" name="confirmed" id="todoCheck7">
                  <label for="todoCheck7"></label>
                </div>
                <span class="text">Confirmed</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="8" name="status" id="todoCheck8">
                  <label for="todoCheck8"></label>
                </div>
                <span class="text">Status</span>
              </li>
              <li>
                <div class="icheck-primary d-inline ml-2">
                  <input type="checkbox" value="9" name="group" id="todoCheck9">
                  <label for="todoCheck9"></label>
                </div>
                <span class="text">Actions</span>					
              </li>
            </ul>
				  </p>
				
			    <div class="card-footer clearfix">
            <input type="hidden" id="create-link-type" value="leads" />
            <button type="submit" class="btn btn-primary float-right" id="create-link">Submit</button>
          </div>
          <hr>
			    <div class="form-group">
			      <div class="input-group input-group-lg pb-3">
              <input type="text" class="form-control" id="cplLink">
              <span class="input-group-append">
                <a target="_blank" class="btn btn-success btn-flat" id="cplVisitBtn">VISIT</a>
				        <a href="javascript:void(0);" class="btn btn-info btn-flat" id="cplBtn">COPY</a>
                <a class="btn btn-danger btn-flat" id="cplDelBtn">DELETE</a>
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
</div>
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
		    <div class="form-group">
          <label for="exampleInputFile">1. Select Group</label>
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
let searchsts= <?=(searchstatus)?>;
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
