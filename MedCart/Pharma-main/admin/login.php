<?php
session_start();
include "includes/functions.php";
login();

?>

<head>
    <title>MedCart</title>
    <link rel="icon" href="../images/logo.png" type="image/icon type">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body {
            background: url(../images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
        }
        .btn:hover {
            background-color: none;
            border: 2px solid white; 
            color: rgb(0, 0, 0);
        }
    </style>
</head>

<div class="container" style="margin-top: 100px;">
    
    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading" style="background-color: rgb(123, 216, 123);">
                <div class="panel-title" style="text-align:center; font-weight: bold; color: white; padding: 6px;">Admin / Employee Login</div>
            </div>
<?php message(); ?>
            <div class="panel-body" style="padding:30px 50px 50px 50px;">
                
                <form id="loginform" class="form-horizontal" method="post" action="login.php">
                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="adminEmail" placeholder="Email" required>
                    </div>

                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="adminPassword" placeholder="Password" required>
                    </div>

                    <div class="form-group" style="margin-top:10px;">
                        <div class="col-sm-12 controls" style="text-align: center; margin-top: 20px">
                            <input class="btn" type="submit" value="Login" name="login" style="padding: 10px 70px; background-color: rgb(103, 202, 103); font-weight: bold; color: white; font-size: 15px;" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
