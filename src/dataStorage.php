<?php

ini_set('display_errors', 'On');

include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "welborau-db", "$myPassword", "welborau-db");
// need to hide my password in storeInfo.php on .gitignore properly
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    echo "Connection worked!<br>";
}

?>

<!DOCTYPE HTML>
<HTML>
<head>
    <title> MySQL ARW Assignment</title>
    <h1>Video Database</h1>
</head>
<body>
<?php
// How do I use the pull down menu to update my search by category, Ethan?
// How do I force the page to reload after an update, Ethan?
// Why can't we use the reload button on the browser but we can click on the url and hit return, Ethan?
if (isset($_POST['Submit'])) {
    if (isset($_POST['searchBy'])) echo "SEARCH By = " . $_POST['searchBy'];
    else echo "SEARCH By = Not Set";
   // $result = $mysqli->query("select * from video where category = " . );
}
else
    $result = $mysqli->query("select * from video");
?>

<table>
  <tr><th>id</th><th>name</th><th>category</th><th>length</th></tr>
    <?php
        while ($row = $result->fetch_assoc()) {
            ?><tr><td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['category'] ?></td>
            <td><?php echo $row['length'] ?></td>
                     <td><form action="dataStorage.php" method="post">
                             <!-- is onclick properly used here for a post request? -->
                    <input type="submit" name= "del" value= "delete" onclick="<?php delete($row['id']);?>" />
                    <input type="hidden" name="id" value = "<?php echo $row['id'] ?>" />
                     <input type="submit" name= "rent" value= <?php if ($row['rented'] == 1)
                                                                    echo "available";
                                                                    else echo "checked out"; ?>
                           "onclick="<?php rent($row['id']);?>" />
                 </form>
            </td>
            </tr>
    <?php }  ?>
</table>
<!-- Is there any way to put each text input from below into the above table while remaining in a separate form?-->
<table>
    <tr>
        <td>
            <form action="dataStorage.php" method="post">
                <p>Add video:<input type="text" name="name" required/></p>
                <p>Category:<input type="text" name="category" required/></p>
                <p>Length:<input type="number" name="length" min="1" max="4000"/></p>
                <!-- Why does the input above not force me to enter a great 1 or greater, Ethan? -->
                <input type="submit"  name="add" value="add video" onclick="<?php add();?>"/>
            </form>
        </td>
    </tr>
</table>

<form action="dataStorage.php" method="post">
    <input type="submit" name= "delAll" value= "Delete All Videos" onclick="<?php delall();?>" />
</form>

<?php
    $result = $mysqli->query("select distinct category from video order by category");
?>

<form name="goSearch" action="dataStorage.php" method="post">
    <select name = "searchBy">
        <option value="ViewAll">All Movies</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?php echo $row['category'] ?>" > <?php echo $row['category'] ?> </option>
        <?php } ?>
    </select>

    <input type="submit" name= "search" value= "Filter by Category" onclick="<?php search();?>" />
</form>
</body>
</HTML>

<?php
function search()
{
    echo "alert('searching')";
    $_POST['sss'] = 'search';
}

function add() {

    $_POST['aaa'] = 'add';
    // How do I grab attributes from form and validate them Ethan?
    // window.location.reload(); why can't I see the error Ethan?
}
function delall()
{
    // Why can't I get rid of these functions, the code only seems to work if we have them
    // modifying $_POST, Ethan?
    $_POST['zzz'] = 'delAll';
}
function rent($id)
{
    $_POST['xxx'] = 'rent';
}
function delete($id)
{
    $_POST['yyy'] = 'del';
}

// Is there a better way to do this Ethan?
if (isset($_POST['search']) and $_SERVER['REQUEST_METHOD'] == "POST") {
    echo "SEARCH = " . $_POST['searchBy'];
}
if (isset($_POST['del']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
   $mysqli->query("DELETE FROM video WHERE id=" . $_POST['id']);
}

if (isset($_POST['delAll']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    $mysqli->query("delete from video");
}

if (isset($_POST['rent']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    if ($_POST['rent'] == 'available')
        $rent = 0;
    else $rent = 1;
    $mysqli->query("update video set rented =" . $rent ." WHERE id=" . $_POST['id']);
}

// The id is primary key, auto incremental, but the table will place new videos in wrong places,
// is the DB on the server set up wrong?
if (isset($_POST['add']) and $_SERVER['REQUEST_METHOD'] == "POST")
{
    echo "*********" .  $_POST['name'] . "," . $_POST['category'] . "," . $_POST['length'] ;

    $str = "insert into video (name, category, length) values ('" .
        $_POST['name'] . "','" . $_POST['category'] . "','" . $_POST['length'] . "')";
        echo $str;
    $mysqli->query($str);
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



