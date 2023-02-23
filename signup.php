<?php
require 'config/constants.php';

//get back the form data in case there was a registration error
$firstname = $_SESSION['singup-data']['firstname'] ?? null;
$lastname = $_SESSION['singup-data']['lastname'] ?? null;
$username = $_SESSION['singup-data']['username'] ?? null;
$email = $_SESSION['singup-data']['email'] ?? null;
$create_password = $_SESSION['singup-data']['create_password'] ?? null;
$confirm_password = $_SESSION['singup-data']['confirm_password'] ?? null;

//delete session
unset($_SESSION['signup-data']);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Blog Website</title>
        <script src="./js/main.js"></script>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
    </head>

    <body>
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Sign Up</h2>

                <?php if (isset($_SESSION['signup'])): ?>
                    <div class="alert__message error">
                    <p>
                        <?=$_SESSION['signup']?>
                        <?php unset($_SESSION['signup'])?>
                    </p>
                </div>
                <?php endif?>

                <form action="<?=ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="post">
                    <input type="text" name="firstname" value="<?=$firstname?>" placeholder="First Name">
                    <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Last Name">
                    <input type="text" name="username" value="<?=$username?>" placeholder="Username">
                    <input type="email" name="email" value="<?=$email?>" placeholder="E-mail">
                    <input type="password" name="create_password" value="<?=$create_password?>" placeholder="Create Password">
                    <input type="password" name="confirm_password" value="<?=$confirm_password?>" placeholder="Confirm Password">
                    <div class="form__control">
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <label for="avatar" class="btn">Upload an Avatar</label>
                            <h4 class="here"></h4>
                        </div>
                        <input type="file" name="avatar" id="avatar">
                        <script src="./js/upload-thumbnail-name.js"></script>
                    </div>
                    <button type="submit" name="submit" class="btn">Sign Up</button>
                    <small>Already have an account? <a href="signin.php">Sing In</a></small>
                </form>
            </div>

        </section>


    </body>

</html>
