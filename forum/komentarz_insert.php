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
        echo 'Musisz być zalogowany, aby opublikować odpowiedź.';
    }
    else
    {
        $sql = "INSERT INTO 
                    komentarze(komentarz_content,
                          komentarz_date,
                          komentarz_topic,
                          komentarz_by) 
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
        }
    }
}

include 'footer.php';
?>