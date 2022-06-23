<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

if(!$_SESSION['signed_in'])
{
    echo 'Musisz być zalogowany, aby usunać pytanie.';
}
else
{
    $sql = "DELETE FROM pytania
            WHERE pytanie_id=" . $_GET['id'];

    $result = $mysqli->query($sql);

    if(!$result)
    {
        echo 'Twoje pytanie nie zostało usunięte.';
    }
    else
    {
        header("Location: pytanie_view.php?id=" . $_GET['cat_id'] );
    }
}


include 'footer.php';
?>