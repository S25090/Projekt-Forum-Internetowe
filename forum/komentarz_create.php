<?php
include 'header.php';
require_once 'db_connect.php';

$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Dodaj komentarz</h2>';
if($_SESSION['signed_in'] == false)
{
    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a> aby zadać pytanie.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST') {

        $sql = "SELECT
                    pytanie_id
                FROM
                    pytania
                WHERE pytanie_id = " . $mysqli->real_escape_string($_GET['id']);


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
                $row = $result->fetch_assoc();

                echo '<form method="post" action="komentarz_insert.php?id=' . $row['pytanie_id'] . '">' .
                    '<textarea name="post-content"></textarea>
                    <input type="submit" value="Zatwierdź" /> 
                    </form>';
            }
        }
    }
}

include 'footer.php';
?>