<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch the category from the database
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
        $_SESSION['send_id'] = $category['id'];
    }

} else {
    header('location: ' . ROOT_URL . 'admin/manage-categories');
    die();
}
?>

        <!-- Edit Category Form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Edit Category</h2>
                <?php if (isset($_SESSION['edit-category'])): ?>
                    <div class="alert__message error ">
                        <p>
                            <?=$_SESSION['edit-category']?>
                            <?php unset($_SESSION['edit-category'])?>
                        </p>
                    </div>
                <?php endif?>
                <form action="<?=ROOT_URL?>admin/edit-category-logic.php" method="post">
                    <input type="text" name="title" value="<?=$category['title']?>" placeholder="Title">
                    <textarea rows="6" name="description" placeholder="Description"><?=$category['description']?></textarea>
                    <button type="submit" name="submit" class="btn">Update category</button>
                </form>
            </div>
        </section>

<?php
include '../partials/footer.php';
?>