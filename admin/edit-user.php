<?php
include 'partials/header.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    //fetch the users based on the value of the idd
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
} else {
    header('location:' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>

        <!-- Edit User Form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Edit User</h2>
                <form action="<?=ROOT_URL?>admin/edit-user-logic.php" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?=$user['id']?>">
                    <input type="text" name="firstname" value="<?=$user['firstname']?>" placeholder="First Name">
                    <input type="text" name="lastname" value="<?=$user['lastname']?>" placeholder="Last Name">
                    <select name="user_role">
                        <option value="0">Author</option>
                        <option value="1">Admin</option>
                    </select>
                    <button type="submit" name="submit" class="btn">Update User</button>
                </form>
            </div>
        </section>

<?php
include '../partials/footer.php';
?>