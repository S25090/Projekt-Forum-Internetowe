<?php
//kategoria_create.php
//include 'connect.php';
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
        echo 'Musisz być zalogowany, aby opublikować odpowiedź.';
    }
    else
    {
        $mysqli = new mysqli("localhost","root","admin","myschema1");

        //a real user posted a real reply
        $sql = "INSERT INTO 
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by) 
                VALUES ('" . $_POST['post-content'] . "',
                        NOW(),
                        " . $mysqli->real_escape_string($_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Twoja odpowiedź nie została zapisana, spróbuj ponownie później.';
        }
        else
        {
            header("Location: komentarz_view.php?id=" . $_GET['id'] );
            //echo 'Your reply has been saved, check out <a href="post_view.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}

include 'footer.php';
?>