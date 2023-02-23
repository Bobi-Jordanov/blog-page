<?php
include 'partials/header.php';

//fetch the post from the database if the id has been set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

        <!-- Post  -->
        <section class="singlepost">
            <div class="container singlepost__container">
                <h2><?=$post['title']?></h2>
                <div class="post__author">
                    <?php $author_id = $post['author_id']?>
                    <?php $author_query = "SELECT * FROM users WHERE id=$author_id"?>
                    <?php $author_result = mysqli_query($connection, $author_query)?>
                    <?php $author = mysqli_fetch_assoc($author_result)?>
                    <div class="post__author-avatar">
                        <img src="./images/<?=$author['avatar']?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?="{$author['firstname']} {$author['lastname']}"?></h5>
                        <small>
                            <?=date("d M, Y - H:i", strtotime($post['date_time']))?>
                        </small>
                    </div>
                </div>
                <div class="singlepost__thumbnail">
                    <img src="./images/<?=$post['thumbnail']?>" alt="">
                </div>
                <p><?=$post['body']?></p>
            </div>
        </section>

<?php
include 'partials/footer.php';
?>