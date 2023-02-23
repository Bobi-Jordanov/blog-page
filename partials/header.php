<?php
require 'config/database.php';

//fetch the current user from the database
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Blog Website</title>
        <script src="<?=ROOT_URL?>js/main.js"></script>
        <link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link type="image/x-icon" rel="icon" href="https://img.icons8.com/color/48/null/google-blog-search.png">
    <body>

        <!-- Nav Bar -->
        <nav>
            <div class="container nav__container">
                <a href="<?=ROOT_URL?>" class="nav__logo">BO-Bloger</a>
                <ul class="nav__items">
                    <li><a href="<?=ROOT_URL?>blog.php">Blog</a></li>
                    <li><a href="<?=ROOT_URL?>about.php">About</a></li>
                    <li><a href="<?=ROOT_URL?>services.php">Services</a></li>
                    <li><a href="<?=ROOT_URL?>contact.php">Contact</a></li>

                    <?php if (isset($_SESSION['user-id'])): ?>
                        <li class="nav__profile">
                            <div class="avatar">
                                <img src="<?=ROOT_URL . 'images/' . $user['avatar']?>" alt="Profile Pic">
                            </div>
                            <ul style="width: 10rem;">
                                <li><a href="<?=ROOT_URL?>admin/index.php"><p>Logged in as: <?="<b>{$user['firstname']} {$user['lastname']}</b>"?></p></a></li>
                                <li><a href="<?=ROOT_URL?>admin/index.php">Dashboard</a></li>
                                <li><a href="<?=ROOT_URL?>logout.php">Logout</a></li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li><a href="<?=ROOT_URL?>signin.php">Sign In</a></li>
                    <?php endif?>

                </ul>
                <div class="nav-btn">
                    <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
                    <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
                </div>

            </div>
        </nav>
