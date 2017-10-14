<?php

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="https://userstats.timo-schneider.de/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="https://userstats.timo-schneider.de/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Persönliche BOINC Userstats - stündlich aktualisiert</title>
	<meta name="description" content="Erstelle deine eigenen BOINC Statistiken mit php und mysql auf deinem Webspace.">
	<meta name="robots" content="index,follow">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="https://userstats.timo-schneider.de/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://userstats.timo-schneider.de/assets/css/now-ui-kit.css?v=1.1.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="https://userstats.timo-schneider.de/assets/css/demo.css" rel="stylesheet" />
</head>

<body class="landing-page sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="100">
        <div class="container">
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="https://userstats.timo-schneider.de/assets/img/blurred-image-1.jpg">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="https://userstats.timo-schneider.de/voraussetzungen.html">Voraussetzungen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://userstats.timo-schneider.de/install.html">Installation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://userstats.timo-schneider.de/faq.html">FAQ</a>
                    </li>					
                    <!--li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="https://twitter.com/CreativeTim" target="_blank">
                            <i class="fa fa-twitter"></i>
                            <p class="d-lg-none d-xl-none">Twitter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="https://www.facebook.com/CreativeTim" target="_blank">
                            <i class="fa fa-facebook-square"></i>
                            <p class="d-lg-none d-xl-none">Facebook</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="https://www.instagram.com/CreativeTimOfficial" target="_blank">
                            <i class="fa fa-instagram"></i>
                            <p class="d-lg-none d-xl-none">Instagram</p>
                        </a>
                    </li-->
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
	
    <div class="wrapper">
        <div class="page-header" filter-color="orange">
            <div class="page-header-image" data-parallax="true" style="background-image: url('https://userstats.timo-schneider.de/assets/img/bg5.jpg');">
            </div>
            <div class="container">
			    <div class="content-center brand">
                    <h1 class="title"><?php echo $connErrorTitle; ?></h1>
                    <h5 class="description text-center"><?php  echo $connErrorDescription; ?></h5>
					<!--div class="alert alert-danger" role="alert">
						<div class="container">
							<div class="alert-icon">
								<i class="now-ui-icons objects_support-17"></i>
							</div>
							<strong>ACHTUNG!</strong> Inhalte dieser Webseite sind teilweise noch in Bearbeitung!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">
									<i class="now-ui-icons ui-1_simple-remove"></i>
								</span>
							</button>
						</div>
					</div-->						
                    <!--div class="text-center">
                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                            <i class="fa fa-facebook-square"></i>
                        </a>
                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div-->
                </div>
            </div>
        </div>
	</div>
		


	<footer class="footer footer-default">
		<div class="container">
			<nav>
				<ul>
					<li>
						<a href="https://www.timo-schneider.de">
							Timo Schneider
						</a>
					</li>
					<li>
					<a href="https://userstats.timo-schneider.de/uebermich.html">
							Über mich
						</a>
					</li>
					<li>
						<a href="https://github.com/creativetimofficial/now-ui-kit/blob/master/LICENSE.md">
							MIT License
						</a>
					</li>
				</ul>
			</nav>
			<div class="copyright">
				&copy;
				<script>
					document.write(new Date().getFullYear())
				</script>, Template by
				<a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>. Code by
				<a href="https://www.timo-schneider.de" target="_blank">Timo Schneider</a>
			</div>
		</div>
	</footer>

</body>
<!--   Core JS Files   -->
<script src="https://userstats.timo-schneider.de/assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="https://userstats.timo-schneider.de/assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="https://userstats.timo-schneider.de/assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="https://userstats.timo-schneider.de/assets/js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="https://userstats.timo-schneider.de/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="https://userstats.timo-schneider.de/assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="https://userstats.timo-schneider.de/assets/js/now-ui-kit.js?v=1.1.0" type="text/javascript"></script>

</html>
