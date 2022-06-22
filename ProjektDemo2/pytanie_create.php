<?php
//pytanie_create.php
include 'header.php';

echo '<h2>Zadaj pytanie</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Ups, musisz być <a href="/ProjektDemo2/signin.php">zalogowany</a>,aby zadać pytanie.';
}
else
{
    $mysqli = new mysqli("localhost","root","admin","myschema1");
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";

        $result = $mysqli->query($sql);

        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Błąd podczas wybierania danych z bazy. Spróbuj ponownie później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_level'] == 1)
                {
                    echo 'Nie utworzyłeś jeszcze żadnych kategorii.';
                }
                else
                {
                    echo 'Zanim będziesz mógł opublikować pytanie, musisz poczekać, aż administrator utworzy kilka kategorii.';
                }
            }
            else
            {

                echo '<form method="post" action="">
                    Pytanie: <input type="text" name="topic_subject" />
                    Kategoria:';

                echo '<select name="topic_cat">';
                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select>';

                echo 'Treść pytania: <textarea name="post_content" /></textarea>
                    <input type="submit" value="Zadaj pytanie" />
                 </form>';
            }
        }
    }
    else
    {
        try {

            $mysqli = new mysqli("localhost", "root", "admin", "myschema1");

            if(!empty($_POST['topic_subject']) && !ctype_space($_POST['topic_subject'])) {
                $sql = "INSERT INTO 
                    topics(topic_subject,
                           topic_date,
                           topic_cat,
                           topic_by)
               VALUES('" . $mysqli->real_escape_string($_POST['topic_subject']) . "',
                           NOW(),
                           " . $mysqli->real_escape_string($_POST['topic_cat']) . ",
                           " . $_SESSION['user_id'] . "
                           )";

                $result = $mysqli->query($sql);
                header('Location: index.php');
            } else {
                echo 'Nazwa pytania nie moze byc pusta!';
            }
        } catch (Exception $e) {
            header('Location: index.php');
        }

    }
}

include 'footer.php';
?>