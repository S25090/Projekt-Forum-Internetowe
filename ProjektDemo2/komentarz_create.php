<?php
include 'header.php';

echo '<h2>Dodaj komentarz</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Ups, musisz być <a href="/ProjektDemo2/signin.php">zalogowany</a> aby zadać pytanie.';
}
else
{
    $mysqli = new mysqli("localhost","root","admin","myschema1");
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST') {

        $sql = "SELECT
                    topic_id
                FROM
                    topics
                WHERE topic_id = " . $mysqli->real_escape_string($_GET['id']);


        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Błąd podczas wybierania z bazy danych. Spróbuj ponownie później.';
        } else {
            if (mysqli_num_rows($result) == 0) {

                if ($_SESSION['user_level'] == 1) {
                    echo 'Nie utworzyłeś jeszcze pytań na forum.';
                } else {
                    echo 'Zanim napiszesz komentarz, upewnij się czy są pytania na forum.';
                }
            } else {
                $row = mysqli_fetch_assoc($result);

                echo '<form method="post" action="komentarz_insert.php?id=' . $row['topic_id'] . '">' .
                    '<textarea name="post-content"></textarea>
                    <input type="submit" value="Zatwierdź" /> 
                    </form>';
            }
        }
    }
}

include 'footer.php';
?>