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
        <title>Manage All Contests/Sweepstakes - Sweepstakes &amp; Contests Admin</title>
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
        <script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3> <i class="fa fa-trophy"></i> All Contests/Sweepstakes</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="contestlist" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" data-placement="right" class="select-checkbox tooltips" data-toggle="tooltip" data-original-title="Check/Uncheck All" id="multi-action-box" /></th>
                                                <th>
                                                    Actions <br/> 
                                                    <button  class="btn btn-success btn-small multi-activate-contest multi-select" title="Change selected contest status"><i class="btn-icon-only icon-check"> </i></button> 
                                                    <button class="btn btn-danger btn-small multi-delete-contest multi-select" title="Delete Selected"><i class="btn-icon-only icon-trash"> </i></button>
                                                </th>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Intro</th>
                                                <th>Description</th>
                                                <th>Header Image</th>
                                                <th>Caption Image</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Announcement Date</th>
                                                <th>No of Winners</th>
                                                <th>Bonus Question</th>
                                                <th>Answer</th>
                                                <th>Point/Invitation</th>
                                                <th>Bonus Point</th>
                                                <th>Rules</th>
                                                <th>Prize</th>
                                                <th>Message</th>
                                                <th>Custom CSS</th>
                                                <th>Date Added</th>
                                                <th>Announce Winner</th>
                                                <th>Auto Restart</th>
                                                <th>Restart Interval</th>
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
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal" type="button"> Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body"> </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-primary" type="button">Close</button>
                                <button class="btn btn-danger modal-confirm" type="button"> Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
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
    <script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
    <script src="assets/dataTables/jquery.dataTables.js"></script>
    <script src="assets/dataTables/dataTables.bootstrap.js"></script>
    
    <script src="js/respond.min.js" ></script>
    <script type="text/javascript" src="js/jquery.pulsate.min.js"></script>
    <script src="js/pulstate.js" type="text/javascript"></script>
    <script src="js/manage-contests.js"></script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    
  </body>
</html>
