<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="img/favicon.png">
        <title>Add New Site Administrator - Sweepstakes &amp; Contests Admin</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <section id="container" >
        <?php include('includes/header.php'); ?>
        <?php include('includes/sidebar.php'); ?>
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div id="messageBox"></div>
                <!--state overview start-->
                <div class="row state-overview">
                    <div class="col-md-10 col-md-offset-1 col-sm-8 col-sm-offset-1 col-xs-8 col-xs-offset-1">
                         <div class="panel panel-default">
                             <div class="panel-heading">
                                 <h2><i class="fa fa-user"></i>  Add New Site Admin </h2>  
                             </div>
                             <div class="panel-body">
                                 <form role="form" id="CreateAdmin" name="CreateAdmin" action="../REST/add-admin.php" method="POST">
                                     <br/>
                                     <div class="form-group input-group">
                                         <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                         <input type="text" class="form-control" id='name' name='name' placeholder="Admin's Full Name" required="required"/>
                                     </div>
                                     <div class="form-group input-group">
                                         <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                         <input type="text" class="form-control" id="userName" name="userName" placeholder="Desired Username" required="required"/>
                                     </div>
                                     <div class="form-group input-group">
                                        <span class="input-group-addon">@</span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Valid Email" required="required"/>
                                    </div>
                                     <div class="form-group input-group">
                                           <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                           <input type="password" class="form-control" id="passWord" name="passWord" placeholder="Enter Password" required="required"/>
                                     </div>
                                     <div class="form-group input-group">
                                         <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                         <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Retype Password" required="required"/>
                                     </div>
                                     <input type="hidden" id="addNewAdmin" name="addNewAdmin" value="addNewAdmin"/>
                                    <div class="form-group input-group">
                                         <span class="input-group-addon"><i class="fa fa-archive"  ></i></span>
                                         <select name="role" id="role" class="form-control" required="required">
                                             <option value=""> -- Select a role -- </option>
                                             <option value="Admin">Admin</option>
                                             <option value="Sub-Admin">Sub-Admin</option>
                                         </select>
                                     </div>
                                     <br/><br/>
                                     <button type="submit" class="btn btn-success ">Add Admin</button>
                                     <button type="reset" class="btn btn-danger ">Reset Form</button>
                                </form>
                                 
                             </div>
                            
                         </div>
                        <div class="messageBox"></div>
                     </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <?php include('includes/footer.php'); ?>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    <script src="js/add-admin.js"></script>
    <!--script for this page-->
    <script src="js/count.js"></script>
  </body>
</html>
