<?php
include 'header.php';

if(!$_SESSION['signed_in'])
{
    echo 'Musisz być zalogowany, aby usunać komentarz.';
}
else
{
    $mysqli = new mysqli("localhost","root","admin","myschema1");

    $sql = "DELETE FROM posts
            WHERE post_id=" . $_GET['id'];

    $result = $mysqli->query($sql);

    if(!$result)
    {
        echo 'Twój komentarz nie został usunięty.';
    }
    else
    {
        header("Location: komentarz_view.php?id=" . $_GET['topic_id'] );
    }
}


include 'footer.php';
?>