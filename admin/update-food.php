<?php
// Start output buffering to prevent header errors
ob_start();
include('partials/menu.php');

// Check if the food item ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve current food item details from the database
    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
    $res2 = mysqli_query($conn, $sql2);

    if ($res2 && mysqli_num_rows($res2) == 1) {
        $row2 = mysqli_fetch_assoc($res2);
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        $_SESSION['error'] = "<div class='error'>Food Item Not Found.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
        exit;
    }
} else {
    header('location:' . SITEURL . 'admin/manage-food.php');
    exit;
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5" required><?php echo $description; ?></textarea></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>" required></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php 
                        if ($current_image) {
                            echo "<img src='" . SITEURL . "images/food/$current_image' width='150px'>";
                        } else {
                            echo "<div class='error'>Image not available.</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category" required>
                            <?php 
                            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
                            $res = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    $selected = $category_id == $current_category ? "selected" : "";
                                    echo "<option value='$category_id' $selected>$category_title</option>";
                                }
                            } else {
                                echo "<option value='0'>No categories available.</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get form data
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];
            $current_image = $_POST['current_image'];

            // Handle image upload if a new image is selected
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = end(explode('.', $image_name));
                $image_name = "Food-Name-" . rand(0000, 9999) . ".$ext";

                $src = $_FILES['image']['tmp_name'];
                $dst = "../images/food/$image_name";

                if (!move_uploaded_file($src, $dst)) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                    header('location:' . SITEURL . 'admin/manage-food.php');
                    exit;
                }

                if ($current_image) {
                    $remove_path = "../images/food/$current_image";
                    if (!unlink($remove_path)) {
                        $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
                        exit;
                    }
                }
            } else {
                $image_name = $current_image;
            }

            // Update food item in the database
            $sql3 = "UPDATE tbl_food SET 
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active' 
                     WHERE id = $id";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3) {
                $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
            }
            header('location:' . SITEURL . 'admin/manage-food.php');
            exit;
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
<?php ob_end_flush(); ?>
