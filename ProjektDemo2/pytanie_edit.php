<?php
include 'header.php';

echo '<h2>Edytuj pytanie</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Ups, musisz być <a href="/ProjektDemo2/signin.php">zalogowany</a> aby edytować pytanie.';
}
else {
    $mysqli = new mysqli("localhost", "root", "admin", "myschema1");
    //the user is signed in
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        $sql = "SELECT
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat,
                    topic_by
                FROM
                    topics
                WHERE topic_id = " . $mysqli->real_escape_string($_GET['id']);


        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Błąd podczas wybierania z bazy danych. Spróbuj ponownie później.';
        } else {
            if (mysqli_num_rows($result) == 0) {

                if ($_SESSION['user_level'] == 1) {
                    echo 'Nie utworzyłeś jeszcze kategorii na forum.';
                } else {
                    echo 'Zanim napiszesz pytanie, upewnij się czy są kategorie na forum.';
                }
            } else {
                $row = mysqli_fetch_assoc($result);
                echo '<form method="post" action="pytanie_update.php?id=' . $_GET['id'] . '&cat_id=' . $_GET['cat_id'] . '">' .
                    '<textarea name="topic_subject">' . $row['topic_subject'] . '</textarea>' .
                    '<input type="submit" value="Zatwierdź" /> 
                    </form>';
            }
        }
    }
}
?>