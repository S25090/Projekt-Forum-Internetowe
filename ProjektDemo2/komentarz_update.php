<?php
include 'header.php';

echo "vvv: " .$_SERVER['REQUEST_METHOD'];
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

        $sql = "UPDATE posts
                SET post_content ='" . $_POST['post-content'] ."',".
               "post_date =NOW()
                WHERE post_id=" . $_GET['id'];

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Twoja odpowiedź nie została zapisana, spróbuj ponownie później.';
        }
        else
        {
            header("Location: komentarz_view.php?id=" . $_GET['topic_id'] );
        }
    }
}

include 'footer.php';
?>