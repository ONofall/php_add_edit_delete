<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'xtnd_carshop');
$sql = 'SELECT cars.*, user.name as user_name FROM cars INNER JOIN user on cars.user_id = user.id';
//$sql = "SELECT * FROM cars";
//$sql1 = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
//$results = mysqli_query($conn, $sql1);
$cars = mysqli_fetch_all($result, MYSQLI_ASSOC);
//$user = mysqli_fetch_all($results, MYSQLI_ASSOC);

$id = $model = $year = $color = $user_id = '';
if (isset($_POST['submit'])) {

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $sql = "INSERT INTO cars ( model, year, color, user_id) VALUES ( '$model', '$year', '$color', '$user_id')";

    mysqli_query($conn, $sql);

    header('location: index.php');

}


if (isset($_POST['delete'])) {
    $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $sql = "DELETE FROM cars WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        header('location: index.php');
    } else {
        echo 'Querry Error :' . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<style>
    table, th, td {
        border: 1px solid black;
    }

    button {
        width: 100%;
        height: 30px;
    }

    form, input {
        width: 100%;
        height: 30px;
    }
    .test{
        width: 50%;
    }
    .edit{
        text-decoration: none;
        color: black;
    }

</style>
<body>

<h2>Cars Table</h2>

<table style="width:50%">
    <tr>
        <th>ID</th>
        <th>Model</th>
        <th>Year</th>
        <th>Color</th>
        <th>User Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($cars as $car) { ?>
        <tr>
            <td><?php echo $car['id'] ?></td>
            <td><?php echo $car['model'] ?></td>
            <td><?php echo $car['year'] ?></td>
            <td><?php echo $car['color'] ?></td>
            <td><?php echo $car['user_name'] ?></td>
            <td>
                <button><a class="edit" href="update.php?id=<?php echo  $car['id']?>" >Update</a>

                </button>
                <form action="index.php" method="POST">
                    <input type="hidden" name="delete_id" value="<?php echo $car['id'] ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<h4>Add Car</h4>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="test">

    <label for="">Car Model</label>
    <input type="text" name="model" value="<?php echo htmlspecialchars($model) ?>">
    <label for="">year</label>
    <input type="text" name="year" value="<?php echo htmlspecialchars($year) ?>">
    <label for="">Color</label>
    <input type="text" name="color" value="<?php echo htmlspecialchars($color) ?>">
    <label for="">User id</label>
    <input type="text" name="user_id" value="<?php echo $user_id ?>">


    <div class="">
        <input type="submit" name="submit" value="Add">
    </div>
</form>


</body>
</html>

