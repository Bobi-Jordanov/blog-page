<?php
require 'config/database.php';

//get user form if the button was clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $create_password = filter_var($_POST['create_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    $is_admin = filter_var($_POST['user_role'], FILTER_SANITIZE_NUMBER_INT);
    //validate inputs
    if (!$firstname) {
        $_SESSION['add-user'] = "Please enter your First Name";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Please enter your Last Name";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Please enter your Username";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Please enter your E-mail";
    } elseif (strlen($create_password) < 8 || strlen($confirm_password) < 8) {
        $_SESSION['add-user'] = "The password should be 8+ characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please select an image";
    } else {
        //check if passwords don't match
        if ($create_password !== $confirm_password) {
            $_SESSION['add-user'] = "Passwords don't match";
        } else {
            //hash the passwords
            $hashed_password = password_hash($create_password, PASSWORD_DEFAULT);
            // echo $create_password . ' ' . $hashed_password;

            //check if username or e-mail exists in the database
            $user_check_query = "SELECT * FROM users WHERE
            username='$username' OR email='$email'";

            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username or E-mail already exists";
            } else {
                //making a unique name for the uploaded image
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                //make sure the file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if (in_array($extention, $allowed_files)) {
                    //if the gile is and image, check its size (1MB)
                    if ($avatar['size'] < 1000000) {
                        //upload the image
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "The file size is too big, it should be less than 1MB";
                    }
                } else {
                    $_SESSION['add-user'] = "The file should be png, jpg, jpeg";

                }
            }
        }
    }

    //redirect back to add-user page if there was any problem with the uploaded info
    if (isset($_SESSION['add-user'])) {
        //pass the form data back to the add-user page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
    } else {
        //insert the new user into the table
        $insert_user_query = "INSERT INTO users SET
        firstname='$firstname', lastname='$lastname', username='$username', email='$email',
        password='$hashed_password', avatar='$avatar_name', is_admin='$is_admin'";

        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if (!mysqli_errno($connection)) {
            //redirect to login page with success message
            $_SESSION['add-user-success'] = "New user <b>$firstname $lastname</b> added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }

} else {
    //if button wasn't clicked, then go back to add-user page
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}
