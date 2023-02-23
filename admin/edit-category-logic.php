<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_SESSION['send_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //validate inputs
    if (!$title) {
        $_SESSION['edit-category'] = "Invalid form. A category must have e <b>title</b>";
    } else {
        if (isset($_SESSION['edit-category'])) {
            $_SESSION['edit-category-data'] = $_POST;
            header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
            die();
        } else {
            $query = "UPDATE categories SET title='$title', description='$description'
                    WHERE id=$id LIMIT 1";
            $result = mysqli_query($connection, $query);

            if (!mysqli_errno($connection)) {
                $_SESSION['edit-category-success'] = "The <b>$title</b> category was updated successfully";
                header('location: ' . ROOT_URL . 'admin/manage-categories.php');
                die();
            }
        }
    }
}
header('location: ' . ROOT_URL . 'admin/edit-category.php?id=' . $id);
die();
