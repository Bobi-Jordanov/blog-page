<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    //fetch user from database
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    //make sure we only get back one user
    if (mysqli_num_rows($result) == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        //delete image if available
        if ($avatar_path) {
            unlink($avatar_path);
        }
    }

    //fetch all the thumbanils of the user's posts and delete them
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id=$id";
    $thumbnails_result = mysqli_query($connection, $thumbnails_query);
    if (mysqli_num_rows($thumbnails_result) > 0) {
        while ($thumbnail = mysqli_fetch_assoc($thumbnails_result)) {
            $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
            //delete thumbnail from the images folder
            if ($thumbnail_path) {
                unlink($thumbnail_path);
            }
        }
    }
    //delete usser from database
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    if (mysqli_errno($connection)) {
        $_SESSION['delete-user'] = "Couldn't delete {$user['firstname']} {$user['lastname']}.";
    } else {
        $_SESSION['delete-user-success'] = "<b>{$user['firstname']} {$user['lastname']}</b> has been deleted successfully.";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
