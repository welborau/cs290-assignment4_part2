<?php
/*
ini_set('display_errors', 'On');
*/
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "welborau-db", "$myPassword", "welborau-db");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Connection worked!<br>";
}
?>

<!DOCTYPE HTML>
<HTML>
<head>
    <title> MySQL Assignment</title>
    <h1>Video Database</h1>
</head>
<body>
<?php
$result = $mysqli->query("select * from video");
echo $results;
?>

<?php function rented($rent) {
    if ($rent == 1)
    {
        echo "yes";
    }
    else
    {
        echo "no";
    }
}
?>

<table>
  <tr><th>id</th><th>name</th><th>category</th><th>length</th><th>rented</th></tr>
    <?php
        while ($row = $result->fetch_assoc()) {
            ?><tr><td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['category'] ?></td>
            <td><?php echo $row['length'] ?></td>
            <td><?php rented($row['rented']) ?></td>
            <td><form action="dataStorage.php" method="post">
                    <input type="submit" value="delete" onclick="<?php delete($row['id']);?>">
                </form>
            </td>
            </tr>
    <?php }  ?>

    <tr>
        <td></td>
        <td><p>Add video:<input type="text" name="name" /></p></td>
        <td><p>Category:<input type="text" name="category" /></p></td>
        <td><p>Length:<input type="text" name="length" /></p></td>
        <td><p>Rented:<input type="checkbox" checked="true"/></p></td>
        <td><input type="submit"  value="add video"/></td>
    </tr>
</table>

</body>
</HTML>

<?php
function delete($id)
{
    $_POST['id'] = $id;

}

if ($_POST['id']) {
    $del = $_POST['id'];
    $mysqli->query("DELETE FROM video WHERE id=$del");
}
?>

<?php
/*
function add($post)
{
    $_name = $post['name'];
    $_cat = $post['category'];
    $_len = $post['length'];
    $_rented = $post['rented'];
}
*/
?>



