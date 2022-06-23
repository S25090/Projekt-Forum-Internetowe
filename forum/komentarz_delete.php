<?php
include 'header.php';
require_once 'db_connect.php';

$db_connect = new db_connect();
$mysqli = $db_connect->connect();


if(!$_SESSION['signed_in'])
{
    echo 'Musisz być zalogowany, aby usunać komentarz.';
}
else
{
    $sql = "DELETE FROM komentarze
            WHERE komentarz_id=" . $_GET['id'];

    $result = $mysqli->query($sql);

    if(!$result)
    {
        echo 'Twój komentarz nie został usunięty.';
    }
    else
    {
        header("Location: komentarz_view.php?id=" . $_GET['pytanie_id'] );
    }
}


include 'footer.php';
?>