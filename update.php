<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'xtnd_carshop');

$sql = "SELECT * FROM cars";
$sql1 = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
$results = mysqli_query($conn, $sql1);
$cars = mysqli_fetch_all($result, MYSQLI_ASSOC);
$users = mysqli_fetch_all($results, MYSQLI_ASSOC);


if (isset($_POST['submit'])) {
    // Sanitize and validate input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // Update query
    $sql = "UPDATE cars SET model = '$model', year = '$year', color = '$color', user_id = '$user_id' WHERE id = '$id'";

    // Execute the update query
    mysqli_query($conn, $sql);

}
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM cars WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $car = mysqli_fetch_assoc($result);
} else {
    header('location: index.php');

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
</head>
<style>
    .edit{
        text-decoration: none;
        color: black;
    }
    .test{
        width: 8%;
    }
</style>
<body>
<button><a class="edit" href="index.php">Home</a></button>

<h2>Update Data</h2>
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $car['id']; ?>">
    <label for="model">New model:</label>
    <input type="text" name="model"  value="<?php echo $car['model']?>" <br><br>
    <label for="year">New year:</label>
    <input type="text" name="year"  value="<?php echo $car['year']?>"><br><br>
    <label for="color">New color:</label>
    <input type="text" name="color"  value="<?php echo $car['color']?>"><br><br>
<!--    <label for="user_id">New user id:</label>-->
<!--    <input type="text" name="user_id"  value="--><?php //echo $car['user_id']?><!--"><br><br>-->
    <select name="$user_id" class="test">
        <?php foreach ($users as $user) {?>
            <option value="<?php echo $car['user_id']?>"><?php echo $user['name'] ?></option>
        <?php }?>
    </select>

    <input type="submit" name="submit" value="Update">
</form>
</body>
</html>