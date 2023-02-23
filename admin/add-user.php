<?php
include 'partials/header.php';

//get back the form data, if there was an error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$create_password = $_SESSION['add-user-data']['create_password'] ?? null;
$confirm_password = $_SESSION['add-user-data']['confirm_password'] ?? null;

//delete session data
unset($_SESSION['add-user-data']);
?>


        <!-- Add User Form -->
        <section class="form__section">
            <div class="container form__section-container">
                <h2>Add User</h2>
                <?php if (isset($_SESSION['add-user'])): ?>
                    <div class="alert__message error">
                        <p>
                            <?=$_SESSION['add-user']?>
                            <?php unset($_SESSION['add-user'])?>
                        </p>
                    </div>
                <?php endif?>
                <form action="<?=ROOT_URL?>admin/add-user-logic.php" enctype="multipart/form-data" method="post">

                    <div class="first-last-name" style="display: grid; grid-template-columns: 1fr 1fr; gap:1rem;">
                        <input type="text" name="firstname" value="<?=$firstname?>" placeholder="First Name">
                        <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Last Name">
                    </div>
                    <input type="text" name="username" value="<?=$username?>" placeholder="Username">
                    <input type="email" name="email" value="<?=$email?>" placeholder="E-mail">
                    <input type="password" name="create_password" value="<?=$create_password?>" placeholder="Create Password">
                    <input type="password" name="confirm_password" value="<?=$confirm_password?>" placeholder="Confirm Password">
                    <select name="user_role">
                        <option value="0">Author</option>
                        <option value="1">Admin</option>
                    </select>

                    <div class="form__control">
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <label for="avatar" class="btn">Add Avatar</label>
                            <h4 class="here"></h4>
                        </div>
                        <input type="file" name="avatar" id="avatar">
                        <script src="../js/upload-thumbnail-name.js"></script>
                    </div>

                    <button type="submit" name="submit" class="btn">Add User</button>
                </form>
            </div>
        </section>
        <div style="margin-top: 20rem;"></div>

<?php
include '../partials/footer.php';
?>