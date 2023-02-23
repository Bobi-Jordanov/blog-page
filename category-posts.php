<?php
include 'partials/header.php';

//fetch posts if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $result = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

        <!------------- Posts Category ------------->
        <header class="category__title">
            <?php $category_query = "SELECT * FROM categories WHERE id=$id"?>
            <?php $category_result = mysqli_query($connection, $category_query)?>
            <?php $category = mysqli_fetch_assoc($category_result)?>
            <h2><?=$category['title']?></h2>
        </header>


        <!------------- Posts ------------->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <section class="post">
                <div class="container post__container">
                    <?php while ($post = mysqli_fetch_assoc($result)): ?>
                        <article class="post">
                            <div class="post__thumbnail">
                                <img src="./images/<?=$post['thumbnail']?>" alt="">
                            </div>
                            <div class="post__info">
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
            <div class="alert__message error lg container">
                <p>No posts found for this category</p>
            </div>
        <?php endif?>

        <!-- Category Buttons -->
        <section class="category__buttons">
            <div class="container category__buttons-container">
                <?php $categories_query = "SELECT * FROM categories"?>
                <?php $categories = mysqli_query($connection, $categories_query)?>
                <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                    <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?=$category['title']?></a>
                <?php endwhile?>
            </div>
        </section>

<?php
include 'partials/footer.php';
?>