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
        <title>Admin Profile - Sweepstakes &amp; Contests Admin</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
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
                                <h3> <i class="fa fa-book"></i> My Profile [Editable]</h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" id="UpdateProfile" name="UpdateProfile" action="../REST/update-admin.php">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Full Name:</label>
                                        <div class="controls">
                                            <input type="hidden" id="id" name="id" value=""/>
                                            <input type="text" id="name" name="name" placeholder="admin full name" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="email">Email Address:</label>
                                        <div class="controls">
                                            <input data-title="Email Address" type="email" placeholder="email address" id="email" name="email" data-original-title="Email Address" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="role">Admin Role:</label>
                                        <div class="controls">
                                            <select tabindex="1" name="role" id="role" data-placeholder="Select a role.." class="form-control">
                                                <option value="">Select a role..</option>
                                                <option value="Sub-Admin">Sub-Admin</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="userName">Username:</label>
                                        <div class="controls">
                                            <input data-title="username.." type="text" placeholder="username.." id="userName" name="userName" data-original-title="Username" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="hidden" name="updateThisAdmin" id="updateThisAdmin" value="updateThisAdmin"/>
                                            <button type="submit" class="btn btn-danger" id="mainUpdateButton">Update Profile</button> &nbsp; &nbsp;
                                            <button type="button" class="btn btn-info" id="cancelProfileUpdate">Cancel</button>
                                            <button type="button" class="btn btn-info" id="enableProfileUpdate">Edit Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="messageBox"></div>
                        <div class="panel panel-warning" id="changePasswordDiv">
                            <div class="panel-heading">
                                <h3> <i class="fa fa-key"></i> Change Password</h3>
                            </div>
                            <div class="panel-body">
                                <form role="form" id="changeAdminPassword" name="changeAdminPassword" action="../REST/change-admin-password.php">
                                    <div class="form-group">
                                        <label class="control-label" for="oldPassword">Old Password:</label>
                                        <div class="controls">
                                            <input type="text" placeholder="old password.." id="oldPassword" name="oldPassword" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="newPassword">New Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="new password.." id="newPassword" name="newPassword" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="confirmPassword">Confirm New Password:</label>
                                        <div class="controls">
                                            <input type="password" placeholder="confirm password.." id="confirmPassword" name="confirmPassword" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="controls">
                                            <input type="hidden" name="changeThisPassword" id="changeThisPassword" value="changeThisPassword"/>
                                            <button type="submit" class="btn btn-danger">Change Password</button> &nbsp; &nbsp;
                                        </div>
                                    </div>
                                </form>
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
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/dataTables/jquery.dataTables.js"></script>
    <script src="assets/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/profile.js"></script>
    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>
    
  </body>
</html>
