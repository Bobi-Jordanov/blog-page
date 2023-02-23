<?php
include 'partials/header.php';

//fetch all the categories form the database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

//fetch data if there was any error in the form
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

unset($_SESSION['add-post-data']);
?>

        <!-- Add Post Form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Add Posts</h2>
                <?php if (isset($_SESSION['add-post'])): ?>
                    <div class="alert__message error">
                        <p>
                            <?=$_SESSION['add-post']?>
                            <?php unset($_SESSION['add-post'])?>
                        </p>
                    </div>
                <?php endif?>

                <form action="<?=ROOT_URL?>admin/add-post-logic.php" enctype="multipart/form-data" method="post">
                    <input type="text" name="title" value="<?=$title?>" placeholder="Title">
                    <select name="category">
                        <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?=$category['id']?>"><?=$category['title']?></option>
                        <?php endwhile?>
                    </select>
                    <textarea rows="10" name="body" placeholder="Body"><?=$body?></textarea>

                    <?php if (isset($_SESSION['user_is_admin'])): ?>
                        <div class="form__control inline">
                            <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                            <label for="is_featured" checked>Featured</label>
                        </div>
                    <?php endif?>

                    <div class="form__control">
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <label for="thumbnail" class="btn">Add Thumbnail</label>
                            <h4 class="here"></h4>
                        </div>
                        <input type="file" name="thumbnail" id="thumbnail">
                        <script src="../js/upload-thumbnail-name.js"></script>
                    </div>

                    <button type="submit" name="submit" class="btn">Add Posts</button>
                </form>
            </div>
        </section>
        <div style="margin-top:15rem;"></div>

<?php
include '../partials/footer.php';
?>