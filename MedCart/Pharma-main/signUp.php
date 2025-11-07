<?php
session_start();
include "includes/functions.php";
signUp();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MedCart</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MedCart is a pharmacy management system.">
    <meta name="keywords" content="pharmacymanagementsystem, inventory, sales, customer, staff, delivery">
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

<body>
<div class="container">
    <div id="signupbox" style="margin-top:30px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading" style="background-color: rgb(123, 216, 123);">
                <div class="panel-title" style="text-align: center; font-weight: bold; color: white;">SIGN UP</div>
            </div>
            <?php message(); ?>
            <div class="panel-body" style="border: none; margin-top: 10px;">
                <form id="signupform" class="form-horizontal" role="form" method="post" action="signUp.php">
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="firstname" class="col-md-3 control-label">First Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="Fname" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-md-3 control-label">Last Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="Lname" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-md-3 control-label">Address</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-md-3 control-label">Phone Number</label>
                        <div class="col-md-8">
                        <input type="tel" name="number" pattern="\d*" maxlength="15" class="form-control" placeholder="Number" required title="Please enter a valid phone number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="passwd" placeholder="Password" required autocomplete="off">
                        </div>
                    </div>
                    <div style="text-align: center; margin-left: 15px;">
                        <b>Password must contain the following:</b>
                        <ul style="list-style-type: none; margin-left: -20px;">
                            <li>At least 1 number and 1 capital letter</li>
                            <li>Must be 8-30 characters</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="security-question" class="col-md-3 control-label">Security Question</label>
                        <div class="col-md-8" style="margin-top: 5px;">
                        <select class="form-control" name="secque" required>
                            <option value="" disabled selected>Select a security question</option>
                            <option>What is your favourite color?</option>
                            <option>What's the name of your first school?</option>
                            <option>Where is your birth place?</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="answer" class="col-md-3 control-label">Answer</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="secans" placeholder="Your Answer" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 controls" style="text-align: center;">
                            <input id="btn-login" class="btn btn-success" type="submit" value="Sign Up" name="signUp" style="padding: 10px 60px" />
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center; font-weight: bold;">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                Already have an account? <a href="login.php">Sign In</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
