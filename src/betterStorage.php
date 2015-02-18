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
    $mysqli->query("update video set rented =" . $rent . " WHERE id=" . $_POST['id']);
}
?>

<?php
// Delete POST request
if (isset($_POST['del']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $mysqli->query("DELETE FROM video WHERE id=" . $_POST['id']);
}

?>

<?php
// Add video POST request
if (isset($_POST['add']) and $_SERVER['REQUEST_METHOD'] == "POST") {
    // If length is below 1 or isn't a number, don't do anything
    if (empty($_POST['length']))
    {
        $str = "insert into video (name, category) values ('" .
            $_POST['name'] . "','" . $_POST['category'] . "')";
        $mysqli->query($str);
    }
    else if ((integer)($_POST['length']) < 1) {
        echo "Length must be a positive number!";
    }
    else if (empty($_POST['name']))
    {
        echo "Name cannot be empty!";
    }
    else{
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
// Filter by POST request
if (isset($_POST['filter']) and $_SERVER['REQUEST_METHOD'] == "POST" and $_POST['FilterBy'] != "ViewAll")
{
    $q = "select * from video WHERE category='" . $_POST['FilterBy'] . "'";
    $result = $mysqli->query($q);
}
else {
    $result = $mysqli->query("select * from video");
}
?>

<!DOCTYPE HTML>
<HTML>
<head>
    <title> MySQL ARW Assignment</title>
    <h1>Video Database</h1>
</head>
<body>
<table>
    <tr><th>id</th><th>Name</th><th>Category</th><th>Length</th><th>Rented</th></tr>
    <?php

        while ($row = $result->fetch_assoc()) {
        ?>
    <tr>
        <td><?php echo $row['id'] ?></td>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['category'] ?></td>
        <td><?php echo $row['length'] ?></td>
            <td><form action="betterStorage.php" method="post">
                    <input type="submit" name= "rent" value= <?php if ($row['rented'] == 1)
                        echo "available";
                    else echo "checked_out"; ?> />
                    <input type="submit" name= "del" value= "delete" />
                    <input type="hidden" name="id" value = "<?php echo $row['id'] ?>" />
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

<?php
// get the categories that are distinct and provide them to the filter
$result = $mysqli->query("select distinct category from video order by category");
?>
<form action="betterStorage.php" method="post">
    <p>What category would you like to filter the videos to?</p>
    <select name = "FilterBy">
        <option value="ViewAll">All Movies</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['category'] ?>" > <?php echo $row['category'] ?> </option>
        <?php } ?>
    </select>
    <input type="submit" name="filter" value="Filter by Category" />
</form>
</body>
</HTML>