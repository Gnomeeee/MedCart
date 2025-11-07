<?php
session_start();
include "includes/functions.php";
login();
?>

<head>
    <title>
        MedCart
    </title>
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body {
            background: url(./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;   
            height: 100vh;
            display: flex;
        }
        </style>
</head>

<!------ Include the above in your HEAD tag ---------->
<div class="container" style="margin-top: 30px; ">
    <div id="loginbox" style="margin-top:30px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading" style="background-color: rgb(123, 216, 123); color: white;">
                <div class="panel-title" style="text-align: center; color: white; font-weight:bold;">LOGIN</div>
            </div>
                <div style="padding:30px 50px 50px 50px;" class="panel-body">
                     <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                <?php
                message();
                ?>
                    <form id="loginform" class="form-horizontal" role="form" method="post" action="login.php">
                       <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                         <input id="login-username" type="text" class="form-control" name="userEmail" value="" placeholder="Email">
                         </div>
                          <div style="margin-bottom: 25px" class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                         <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                         </div>

                         <div style="margin-top:15px; " class="form-group">
                            <!-- Button -->
                            <div class="col-sm-12 controls" style="margin-bottom: 30px">
                             <input type="checkbox" name="remember" value="1"> Remember me
                             <a href="./forgot.php" style="color: black; font-size: 13px; float: right; margin-top: 3.5px">Forgot password?</a>
                         </div>
                         <div style="text-align: center;">
                         <input id="btn-login" class="btn" type="submit" value="Login" name="login" style="padding: 10px 60px; font-weight: bold; background-color: rgb(104, 206, 104); color: white" />
                        </div>
                    </div>

                    <div class="form-group" style="text-align: center;">
                        <div class="col-md-12 control">
                            <div style=" padding-top:15px; font-size:85%; font-weight: bold;">
                                Don't have an account?
                                <a href="signUp.php" ">
                                    Sign Up
                                </a>
                                <br>
                                <br>
                                <a href="admin/login.php">
                                 Administrators
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>