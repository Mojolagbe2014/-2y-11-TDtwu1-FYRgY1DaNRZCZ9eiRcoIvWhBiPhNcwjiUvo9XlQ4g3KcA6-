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
        <title>Manage Contest Entrants - Sweepstakes &amp; Contests Admin</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
        <link href="assets/font_awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
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
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3><i class="fa fa-group"> </i> All Contests' Entrants</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="entrantlist" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="select-checkbox" id="multi-action-box" /></th>
                                                <th>Actions &nbsp; 
<!--                                                    <button  class="btn btn-success btn-small multi-message-entrant multi-select" title="Send Email"><i class="btn-icon-only icon-envelope"> </i></button> -->
                                                    <button class="btn btn-danger btn-small multi-delete-entrant multi-select" title="Delete Selected"><i class="btn-icon-only icon-trash"> </i></button>
                                                </th>
                                                <th>ID</th>
                                                <th>Contest</th>
                                                <th>Entrant</th>
                                                <th>Friend E-mails</th>
                                                <th>Friend Names</th>
                                                <th>Time Entered</th>
                                                <th>Point Earned</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="messageBox"></div>
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
    <script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/dataTables/jquery.dataTables.js"></script>
    <script src="assets/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/manage-entrants.js"></script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    
  </body>
</html>
