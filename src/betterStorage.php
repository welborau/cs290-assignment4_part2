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
// Available function
?>

<?php
// Delete function
?>

<?php
// Add video function
?>

<?php
// Delete all videos function
?>

<?php
// Search by function
?>

<?php
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
    <tr><th>id</th><th>Name</th><th>Category</th><th>Length</th><th>Availability</th></tr>
    <?php

        while ($row = $result->fetch_assoc()) {
        ?>
    <tr>
        <td><?php echo $row['id'] ?></td>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['category'] ?></td>
        <td><?php echo $row['length'] ?></td>
            <td><form action="dataStorage.php" method="post">
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
            <form action="dataStorage.php" method="post">
                <p>Name:<input type="text" name="name" />
                Category:<input type="text" name="category" />
                Length:<input type="number" name="length" />
                <input type="submit"  name="add" value="Add Video"/></p>
            </form>
        </td>
    </tr>
</table>
<form action="dataStorage.php" method="post">
    <input type="submit" name= "delAll" value= "Delete All Videos" />
</form>
<form name="goSearch" action="dataStorage.php" method="post">
    <select name = "searchBy">
        <option value="ViewAll">All Movies</option>
    </select>
    <input type="submit" name= "search" value= "Filter by Category" />
</form>
</body>
</HTML>