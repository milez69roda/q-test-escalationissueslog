<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Escalation/Issues Logger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<base href="<?php echo base_url(); ?>"/>
	
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <style type="text/css">
	body {
		padding-top: 40px;
		padding-bottom: 40px;
		/* background-color: #f5f5f5; */
		background: url("img/pattern-splash2.png") repeat scroll 0 0 #222222;
		 
		
	}

	.form-signin {
		max-width: 300px;
		padding: 19px 29px 29px;
		margin: 0 auto 20px;
		background-color: #fff;
		border: 1px solid #e5e5e5;
		-webkit-border-radius: 5px;
		   -moz-border-radius: 5px;
				border-radius: 5px;
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		   -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
		margin-bottom: 10px;
	}
	.form-signin input[type="text"],
	.form-signin input[type="password"] {
		font-size: 16px;
		height: auto;
		margin-bottom: 15px;
		padding: 7px 9px;
	}

	.jumbotron {
		margin: 20px 0;
	text-align: center;
	}
	.jumbotron h1 {
		font-size: 30px;
		line-height: 1;
	}	
    </style> 

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

 
  </head>

  <body>

    <div class="container">
		<div class="jumbotron">
			<h1 style="color: #fff">Escalation/Issues Logger</h1>         
		</div>
		<form class="form-signin" action="" method="post">
			<h3 class="form-signin-heading">Please sign in</h3>
			<?php echo $errors; ?>
			<label>Username: </label>
			<input type="text" name="txt45u" class="input-block-level" placeholder="Username">
			<label>Password: </label>
			<input type="password" name="txt45p" class="input-block-level" placeholder="Password">		 
			<button class="btn btn-large btn-inverse" type="submit">Sign in</button>
		</form>

    </div> <!-- /container -->

    
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>

  </body>
</html>
