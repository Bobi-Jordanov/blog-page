<?php
require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);
?>

<html>

    <head>
        <meta charset="UTF-8">
        <title>Blog Website</title>
        <script src="<?=ROOT_URL?>js/main.js"></script>
        <link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Sign In</h2>

                <?php if (isset($_SESSION['signup-success'])): ?>
                    <div class="alert__message success">
                        <p>
                            <?=$_SESSION['signup-success']?>
                            <?php unset($_SESSION['signup-success'])?>
                        </p>
                    </div>
                <?php elseif (isset($_SESSION['signin'])): ?>
                    <div class="alert__message error">
                        <p>
                            <?=$_SESSION['signin']?>
                            <?php unset($_SESSION['signin'])?>
                        </p>
                    </div>
                <?php endif?>

                <form action="<?=ROOT_URL?>signin-logic.php" method="post">
                    <input type="text" name="username_email" value="<?=$username_email?>" placeholder="Username or E-mail">
                    <input type="password" name="password" value="<?=$password?>" placeholder="Password">

                    <button type="submit" name="submit" class="btn">Sign In</button>
                    <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
                </form>
            </div>
        </section>
    </body>

</html>
