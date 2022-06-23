<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo 'Tego pliku nie można wywołać bezpośrednio.';
}
else
{
    if(!$_SESSION['signed_in'])
    {
        echo 'Musisz być zalogowany, aby edytować pytanie.';
    }
    else
    {
        $sql = "UPDATE pytania
                SET pytanie_subject ='" . $_POST['pytanie_subject'] ."',".
               "pytanie_date =NOW()
                WHERE pytanie_id=" . $_GET['id'];

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Twoja pytanie nie zostało zapisane, spróbuj ponownie później.';
        }
        else
        {
            header("Location: pytanie_view.php?id=" . $_GET['cat_id'] );
        }
    }
}

include 'footer.php';
?>