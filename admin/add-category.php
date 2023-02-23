<?php
include 'partials/header.php';

//get back the form data if invalid
$title = $_SESSION['add-category-data']['title'] ?? null;
$description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);
?>

        <!-- Add Category form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Add Category</h2>
                <?php if (isset($_SESSION['add-category'])): ?>
                    <div class="alert__message error">
                        <p>
                            <?=$_SESSION['add-category']?>
                            <?php unset($_SESSION['add-category'])?>
                        </p>
                    </div>
                <?php endif?>
                <form action="<?=ROOT_URL?>admin/add-category-logic.php" method="post">
                    <input type="text" name="title" value="<?=$title?>" placeholder="Title">
                    <textarea rows="6" name="description" placeholder="Description"><?=$description?></textarea>
                    <button type="submit" name="submit" class="btn">Add category</button>
                </form>
            </div>
        </section>


<?php
include '../partials/footer.php';
?>