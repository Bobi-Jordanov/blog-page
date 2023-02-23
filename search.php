<?php
require 'partials/header.php';

if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM posts WHERE title LIKE '%$search%'
            ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}

?>
        <?php if (mysqli_num_rows($posts) > 0): ?>
            <section class="posts section__extra-margin">
                <div class="container post__container">
                    <?php while ($post = mysqli_fetch_assoc($posts)): ?>
                        <article class="post">
                            <div class="post__thumbnail">
                                <img src="./images/<?=$post['thumbnail']?>" alt="">
                            </div>
                            <div class="post__info">
                                <?php $category_id = $post['category_id']?>
                                <?php $category_query = "SELECT * FROM categories WHERE id=$category_id"?>
                                <?php $category_result = mysqli_query($connection, $category_query)?>
                                <?php $category = mysqli_fetch_assoc($category_result)?>
                                <a href="<?=ROOT_URL?>category-posts.php?id=<?=$post['category_id']?>" class="category__button"><?=$category['title']?></a>
                                <h3 class="post__title">
                                    <a href="<?=ROOT_URL?>post.php?id=<?=$post['id']?>"><?=$post['title']?></a>
                                </h3>
                                <p class="post__body"><?=substr($post['body'], 0, 200)?>...</p>
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
                                        <small><?=date("d M, Y - H:i", strtotime($post['date_time']))?></small>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile?>
                </div>
            </section>
        <?php else: ?>
            <div class="alert__message error lg container section__extra-margin">
                <p>Posts with that search word do not exist</p>
            </div>
        <?php endif?>

        <!-- Category Buttons -->
        <section class="category__buttons">
            <div class="container category__buttons-container">
                <?php $all_categories_query = "SELECT * FROM categories"?>
                <?php $all_categories_result = mysqli_query($connection, $all_categories_query)?>
                <?php while ($category = mysqli_fetch_assoc($all_categories_result)): ?>
                    <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?=$category['title']?></a>
                <?php endwhile?>
            </div>
        </section>

<?php include 'partials/footer.php'?>

