<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query_title = "SELECT title FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query_title);
    $title = $result->fetch_array()['title'] ?? '';

    //update category_id of posts that belong to this category to id of uncategorized posts
    $update_query = "UPDATE posts SET category_id=16 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);
    if (!mysqli_errno($connection)) {
        //delete the category
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Category <b>$title</b> deleted successfully";
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
