<?php
$mysqli=null;
require_once 'db_connect.php';

$db_connect = new db_connect();
$mysqli = $db_connect->connect();


echo '<h2>Edytuj komentarz</h2>';
if($_SESSION['signed_in'] == false)
{
    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a> aby edytować komentarz.';
}
else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $sql = "SELECT
                    komentarz_id,
                    komentarz_content,
                    komentarz_date,
                    komentarz_topic,
                    komentarz_by
                FROM
                    komentarze
                WHERE komentarz_id = " . $mysqli->real_escape_string($_GET['id']);

        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Błąd podczas wybierania z bazy danych. Spróbuj ponownie później.';
        } else {
            if ($result->num_rows == 0) {

                if ($_SESSION['user_level'] == 1) {
                    echo 'Nie utworzyłeś jeszcze pytań na forum.';
                } else {
                    echo 'Zanim napiszesz komentarz, upewnij się czy są pytania na forum.';
                }
            } else {
                $row = $result->fetch_assoc( );
                echo '<form method="post" action="komentarz_update.php?id=' . $_GET['id'] . '&pytanie_id=' . $_GET['pytanie_id'] . '">' .
                    '<textarea name="post-content">' . $row['komentarz_content'] . '</textarea>' .
                    '<input type="submit" value="Zatwierdź" /> 
                    </form>';
            }
        }
    }
}
?>