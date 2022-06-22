<?php
include 'header.php';

if(!$_SESSION['signed_in'])
{
    echo 'Musisz być zalogowany, aby usunać pytanie.';
}
else
{
    $mysqli = new mysqli("localhost","root","admin","myschema1");

    $sql = "DELETE FROM topics
            WHERE topic_id=" . $_GET['id'];

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