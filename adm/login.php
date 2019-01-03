<?php include("inc.aplication_top.php");

if($_GET['action'] == 'acceso'){

	if($sesion->enviarContrasena()){

		header("Location:login.php?msg=success");

	}else{

		header("Location:login.php?action=recuperar_c&msg=error");

	}	

}

?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v4.1/admin/html/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Jun 2018 19:21:31 GMT -->
<head>
    <meta charset="utf-8" />
    <title>DevelowebApps Admin | Login</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>plugins/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>css/default/style.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?php echo _admin_assets_?>css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo _admin_assets_?>plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top bg-white">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(<?php echo _admin_assets_?>img/login-bg/login-bg-11.jpg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><b>Content</b> Admin </h4>
                    <p>
                        Consultas o incidencias al correo <b>florescastrokevin@gmail.com.</b>
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> <b>WebEdson</b> Admin
                        <small>Administre el contenido de la web</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <form name="login" action="index.php" method="post" class="margin-bottom-0">
                        <div class="form-group m-b-15">
                            <input type="text" name="login" value="<?php echo $_COOKIE['email_MKD']?>" tabindex="1" class="form-control form-control-lg" placeholder="Usuario" required />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password" class="form-control form-control-lg" placeholder="Password" value="<?php echo $_COOKIE['pass_MKD']?>"  name="password" tabindex="2" required />
                        </div>
                        <!-- <div class="checkbox checkbox-css m-b-30">
                            <input type="checkbox" id="remember_me_checkbox" value="" />
                            <label for="remember_me_checkbox">
                                Recordarme por 30 días
                            </label>
                        </div> -->
                        <div class="login-buttons">
                            <button type="submit" id="sign-in" name="enviar" tabindex="3" class="btn btn-success btn-block btn-lg">Ingresar</button>
                        </div>
                        <hr />
                        <p class="text-center text-grey-darker">
                            &copy; WebEdson todos los derechos reservados 2018
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->
        
    </div>
    <!-- end page container -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo _admin_assets_?>plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?php echo _admin_assets_?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo _admin_assets_?>plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
    <!--[if lt IE 9]>
        <script src="<?php echo _admin_assets_?>crossbrowserjs/html5shiv.js"></script>
        <script src="<?php echo _admin_assets_?>crossbrowserjs/respond.min.js"></script>
        <script src="<?php echo _admin_assets_?>crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?php echo _admin_assets_?>plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo _admin_assets_?>plugins/js-cookie/js.cookie.js"></script>
    <script src="<?php echo _admin_assets_?>js/theme/default.min.js"></script>
    <script src="<?php echo _admin_assets_?>js/apps.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>

</body>

<!-- Mirrored from seantheme.com/color-admin-v4.1/admin/html/login_v3.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Jun 2018 19:21:32 GMT -->
</html>

