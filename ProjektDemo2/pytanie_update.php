<?php
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'Tego pliku nie można wywołać bezpośrednio.';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'Musisz być zalogowany, aby edytować pytanie.';
    }
    else
    {
        $mysqli = new mysqli("localhost","root","admin","myschema1");

        $sql = "UPDATE topics
                SET topic_subject ='" . $_POST['topic_subject'] ."',".
               "topic_date =NOW()
                WHERE topic_id=" . $_GET['id'];

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