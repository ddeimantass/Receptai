<?php echo doctype('html5'); ?>
<html>

<head>
	<title>Receptai</title>
	<meta charset="UTF-8">
	<link rel="stylesheet"  href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="<?php echo base_url();?>styles.css">
	<link rel="stylesheet"  href="<?php echo base_url();?>animate.css">
	<link rel="stylesheet"	href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" >
</head>

<body>
	<header>
		<nav class=" nav navbar-inverse topNav " >
			<div class="container">	
                <button class="navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>					
				</button>
				<div class="collapse navbar-collapse navHeaderCollapse container ">
					<ul class="nav navbar-nav">
                        <li class="<?php if(base_url(uri_string())=='http://localhost:8888/receptai/'){echo "IamHere ";}?> " ><a id ='tab' href="<?php echo base_url();?>"><i class="fa fa-home"></i>Pradinis</a></li>
						
						<li <?php if($this->session->userdata('is_logged_in')) echo "style='display: none'"?> id='login' class="<?php if(base_url(uri_string())=='http://localhost:8888/receptai/site/prisijungimas'){echo "IamHere ";}?> " ><a id ='tab' href="<?php echo base_url();?>index.php/site/prisijungimas"><i class="fa fa-sign-in"></i>Prisijungti</a></li>
						
                        <li <?php if($this->session->userdata('is_logged_in')) echo "style='display: block'"?> id='anketa' class="<?php if(base_url(uri_string())=='http://localhost:8888/receptai/vartotojas/anketa'){echo "IamHere ";}?> " ><a id ='tab' href="<?php echo base_url();?>index.php/vartotojas/anketa"><i class="fa fa-user"></i>Anketa</a></li>
                        
						<li <?php if($this->session->userdata('is_logged_in')) echo "style='display: block'"?> id='atsiliepimas' class="<?php if(base_url(uri_string())=='http://localhost:8888/receptai/vartotojas/pasiulytiRecepta'){echo "IamHere ";}?> " ><a id ='tab' href="<?php echo base_url();?>index.php/vartotojas/pasiulytiRecepta"><i class="fa fa-pencil"></i>Pasiūlyti receptą</a></li>
					</ul>
				</div>
            </div>
		</nav>	
	</header>
   	