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
        $sql = "UPDATE komentarze
                SET komentarz_content ='" . $_POST['post-content'] ."',".
               "komentarz_date =NOW()
                WHERE komentarz_id=" . $_GET['id'];

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Twoja odpowiedź nie została zapisana, spróbuj ponownie później.';
        }
        else
        {
            header("Location: komentarz_view.php?id=" . $_GET['pytanie_id'] );
        }
    }
}

include 'footer.php';
?>