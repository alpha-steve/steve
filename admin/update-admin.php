<?php
include('partials/menu.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure a connection to the database is established
if (!isset($conn)) {
    die("Database connection failed.");
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
        // Check if the ID is set in the URL
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']); // Convert ID to integer for safety
        } else {
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
            exit;
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password" required>
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 

// Check whether the Submit Button is Clicked or Not
if (isset($_POST['submit'])) {
    // Get the data from the form
    $id = intval($_POST['id']); // Convert ID to integer for safety
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Retrieve the current hashed password for the user
    $sql = "SELECT * FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $hashed_password = $row['password'];

        // 2. Verify the current password
        if (password_verify($current_password, $hashed_password)) {
            // Check whether the new password and confirm match
            if ($new_password === $confirm_password) {
                // Hash the new password before updating
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $sql2 = "UPDATE tbl_admin SET password='$hashed_new_password' WHERE id=$id";
                $res2 = mysqli_query($conn, $sql2);

                // Check whether the query executed successfully
                if ($res2) {
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                } else {
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                }
                // Redirect to Manage Admin Page
                header('location:' . SITEURL . 'admin/manage-admin.php');
                exit;
            } else {
                $_SESSION['pwd-not-match'] = "<div class='error'>Passwords Did Not Match.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
                exit;
            }
        } else {
            $_SESSION['user-not-found'] = "<div class='error'>Current Password is Incorrect.</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
            exit;
        }
    } else {
        $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
        header('location:' . SITEURL . 'admin/manage-admin.php');
        exit;
    }
}

?>