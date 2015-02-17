<?php
/**
 * Created by PhpStorm.
 * User: Austin
 * Date: 2/16/2015
 * Time: 9:44 PM
 */
?>

<?php

ini_set('display_errors', 'On');

include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "welborau-db", "$myPassword", "welborau-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Connection worked!<br>";
}
?>

<?php
// Available POST request
if (isset($_POST['rent']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    if ($_POST['rent'] == 'available')
        $rent = 0;
    else $rent = 1;
    $mysqli->query("update video set rented =" . $rent . " WHERE name=" . $_POST['id']);
}
?>

<?php
// Delete POST request
if (isset($_POST['del']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $mysqli->query("DELETE FROM video WHERE name=" . $_POST['id']);
}

?>

<?php
// Add video POST request
if (isset($_POST['add']) and $_SERVER['REQUEST_METHOD'] == "POST") {
    // If length is below 1 or isn't a number, don't do anything
    if (((integer)($_POST['length']) < 1) || (!is_numeric($_POST['length']))) {
        echo "Length cannot be below 1!";
    }
    else
    {
        $str = "insert into video (name, category, length) values ('" .
            $_POST['name'] . "','" . $_POST['category'] . "','" . $_POST['length'] . "')";
        $mysqli->query($str);
    }
}
?>

<?php
// Delete all video POST request
if (isset($_POST['delAll']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $mysqli->query("delete from video");
}
?>

<?php
// Search by POST request
?>

<?php
// Display the video table
    $result = $mysqli->query("select * from video");
?>

<!DOCTYPE HTML>
<HTML>
<head>
    <title> MySQL ARW Assignment</title>
    <h1>Video Database</h1>
</head>
<body>
<table>
    <tr><th>id</th><th>Name</th><th>Category</th><th>Length</th>Rented<th>Availability</th></tr>
    <?php

        while ($row = $result->fetch_assoc()) {
        ?>
    <tr>
        <td><?php echo $row['id'] ?></td>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['category'] ?></td>
        <td><?php echo $row['length'] ?></td>
        <td><?php echo $row['rented'] ?></td>
            <td><form action="betterStorage.php" method="post">
                    <input type="submit" name= "rent" value= "available" />
                    <input type="submit" name= "del" value= "delete" />
            </form>
        </td>
        </tr>
        <?php }  ?>
</table>
<table>
    <tr>
        <td>
            <form action="betterStorage.php" method="post">
                <p>Name:<input type="text" name="name" />
                Category:<input type="text" name="category" />
                Length:<input type="number" name="length" />
                <input type="submit"  name="add" value="Add Video"/></p>
            </form>
        </td>
    </tr>
</table>
<form action="betterStorage.php" method="post">
    <input type="submit" name= "delAll" value= "Delete All Videos" />
</form>
<form name="goSearch" action="betterStorage.php" method="post">
    <select name = "searchBy">
        <option value="ViewAll">All Movies</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['category'] ?>" > <?php echo $row['category'] ?> </option>
        <?php } ?>
    </select>
    <input type="submit" name= "search" value= "Filter by Category" />
</form>
</body>
</HTML>