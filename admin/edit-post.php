<?php
include 'partials/header.php';

//fetch categories from database
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $category_query);

//fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
    $_SESSION['send_id_post'] = $post['id'];
    $_SESSION['send_thumb_name'] = $post['thumbnail'];
} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

?>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

        <!-- Edit Post Form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Edit Posts</h2>
                <?php if (isset($_SESSION['edit-post'])): ?>
                    <div class="alert__message error">
                        <p>
                            <?=$_SESSION['edit-post']?>
                            <?php unset($_SESSION['edit-post'])?>
                        </p>
                    </div>
                <?php endif?>
                <form action="<?=ROOT_URL?>admin/edit-post-logic.php" enctype="multipart/form-data" method="post">
                    <input type="text" name="title" value="<?=$post['title']?>" placeholder="Title">
                    <select name="category">
                        <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?=$category['id']?>"><?=$category['title']?></option>
                        <?php endwhile?>
                    </select>
                    <textarea rows="10" name="body" placeholder="Body"><?=$post['body']?></textarea>

                    <div class="form__control inline">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                        <label for="is_featured">Featured</label>
                    </div>

                    <div class="form__control">
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <label for="thumbnail" class="btn">Change Thumbnail</label>
                            <h4 class="here"></h4>
                        </div>
                        <input type="file" name="thumbnail" id="thumbnail">
                        <script src="../js/upload-thumbnail-name.js"></script>
                    </div>

                    <button type="submit" name="submit" class="btn">Update Post</button>
                </form>
            </div>
        </section>
        <div style="margin-top: 10rem;"></div>


<?php
include '../partials/footer.php';
?>