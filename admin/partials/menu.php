<?php 

    include('../config/constants.php'); 
    include('login-check.php');

?>


<html>
    <head>
        <title>Food Order Website - Home Page</title>
        <link rel="stylesheet" href="../css/admin.css">
        <link rel="stylesheet" href=
    "https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
            integrity=
    "sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
            crossorigin="anonymous"> 
     
        
    </head>
    
    <body>
        <!-- Menu Section Starts -->
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                <li>
        
            <a href="<?php echo SITEURL; ?>index.php" style="margin-right: auto; text-decoration: none; color: #333; font-weight: bold; padding: 8px 12px;">
                [User Interface]
       
    </li>
                <li><a href="<?php echo SITEURL; ?>home.php">Home</a></li>


                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-users.php">Users</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>
            </div>
        </div>
        <!-- Menu Section Ends -->