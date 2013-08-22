<!DOCTYPE html>
<html>
<head>
<title>Escalation/Issues Logger</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="<?php echo base_url(); ?>"/>

<!-- Bootstrap -->
<!--<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">-->
<link href="css/bootstrap.css" rel="stylesheet" media="screen">
<link href="css/datepicker.css" rel="stylesheet" media="screen">

<script src="js/jquery.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/apps.js"></script>

 
<style>
	body {
		 
		font-size: 12px !important;	 
		color: #2C3E50;
		font-family: "Lato","Helvetica Neue",Helvetica,Arial,sans-serif;
		margin-top: 55px;
	}

	.row-fluid{ 
		padding: 5px 10px;
	}
  
	.dataTable thead tr th {
		background-color: #EEE !important;
		border-bottom: 1px solid #000000;
		border-left: 1px solid #fff; 
	}
	
	.row{
		margin-left: 0px !important;
	}

 
	.navbar {
		background-color: #2C3E50;
		background-image: linear-gradient(to bottom, #2C3E50, #2C3E50); 	
	}	

	.navbar-inverse .brand, .navbar-inverse .nav > li > a {
		color: #FFFFFF;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	}

	.container {
		width: 1024px;
	}

 	
.navbar-inverse .nav .active > a, .navbar-inverse .nav .active > a:hover, .navbar-inverse .nav .active > a:focus {
    background-color: #CCCCCC;
    color: red;
}

 
</style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

<script>
$(document).ready(function () {

	 
});
	
</script>
	
</head>
<body>
     <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner" style="padding: 8px">
        <div class="container">
           
          <a class="brand" href="#" style="font-weight: bold; color:#fff;">Escalation / Issues Logger</a>
          <div class="nav-collapse collapse pull-right" style="font-size: 17px;">
	 
            <ul class="nav" style="color:#fff !important">
				<?php if( $this->session->userdata('ESCISSL_ROLEID') != 4): ?>
				<li <?php echo @($nactive == 'overview')?'class="active"':''; ?>><a href="#">Overview</a></li> 
				<?php endif; ?>
				<?php if( in_array(1, $this->access) ): ?> <li <?php echo @($nactive == 'escalation')?'class="active"':''; ?>><a href="escalation/form">Escalation Log</a></li><?php endif; ?> 
				<?php if( in_array(2, $this->access) ): ?><li <?php echo @($nactive == 'issues')?'class="active"':''; ?>><a href="issues/form">Issues Log</a></li> <?php endif; ?>  				
            </ul>
		 
			<ul class="nav menu pull-right">
				<ul class="nav "> 
					<li class="deeper dropdown"><a href="/themes" data-toggle="dropdown" class=" dropdown-toggle "><?php echo $this->session->userdata('ESCISSL_FULLNAME'); ?><b class="caret"></b></a>
						<ul class="nav-child unstyled small dropdown-menu">
							<li><a href="myaccount">Manage Account</a></li> 
							<li class="divider"></li>
							<li><a href="logout">Logout</a></li>    
							 
						</ul>
					</li> 
				</ul>				
			</ul>
          </div> 
        </div>
      </div>
    </div> 
	 
	
	<div class="<?php echo isset($container)?$container:'container'; ?>">	 