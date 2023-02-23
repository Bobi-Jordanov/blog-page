<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    //get the form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //check if a category already exists in the database
    $title_check_query = "SELECT * FROM categories WHERE title='$title'";
    $title_check_result = mysqli_query($connection, $title_check_query);

    if (!$title) {
        $_SESSION['add-category'] = "Enter title.";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Enter description.";
    } elseif (mysqli_num_rows($title_check_result) > 0) {
        $_SESSION['add-category'] = "The category <b>$title</b> already exists.";
    }

    //redirect back to category page with form data if there wa invalid input
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        //insert category
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "The <b>$title</b> category has been added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
            die();
        }
    }
}
