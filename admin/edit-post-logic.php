<?php
require 'config/database.php';

//make sure the edit button has been clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_SESSION['send_id_post'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_SESSION['send_thumb_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    //validate form data
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update the post. A post must have a <b>title</b>.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update the body. A post must have a <b>body</b>";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Choose the post's thumbnail";
    } else {
        //delete exsisting thumbnail if new thumbnail is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }
        }

        //renaming the image for it to have a unique name
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        //make sure the file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            //checking for the image's size (2MB)
            if ($thumbnail['size'] < 2000000) {
                //upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['edit-post'] = "File size is too big. It should be less than 2MB.";
            }
        } else {
            $_SESSION['edit-post'] = "File should be png, jpg, or jpeg.";
        }
    }

    //redirect back to edit-post page if there is any problem
    if (isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        //set thumbnail name if a new one was uploaded, otherwise keep the old name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        //insert post into database
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert',
        category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        // $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
        // VALUES ('$title', '$body','$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)) {
            $_SESSION['edit-post-success'] = "Post updated successfully";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }
}

header('location: ' . ROOT_URL . 'admin/edit-post.php?id=' . $id);
die();
