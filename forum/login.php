<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h3>Zaloguj się</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Jesteś już zalogowany, możesz <a href="logout.php">wylogować się</a> jeśli chcesz.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
            Nazwa użytkownika: <input type="text" name="user_name" />
            Hasło: <input type="password" name="user_pass">
            <input type="submit" value="Zaloguj" />
         </form>';
    }
    else
    {
        $errors = array();

        if(!isset($_POST['user_name']))
        {
            $errors[] = 'Pole nazwy użytkownika nie może być puste.';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'Pole hasła nie może być puste.';
        }

        if(!empty($errors))
        {
            echo 'Uh-oh.. kilka pól nie jest wypełnionych poprawnie..';
            echo '<ul>';
            foreach($errors as $key => $value)
            {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        }
        else
        {
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level
                    FROM
                        uzytkownicy
                    WHERE
                        user_name = '" . $mysqli->real_escape_string($_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";

            $result = $mysqli->query($sql);
            if(!$result)
            {
                echo 'Podczas logowania coś poszło nie tak. Spróbuj ponownie później.';
            }
            else
            {
                if($result->num_rows == 0)
                {
                    echo 'Podałeś niewłaściwą kombinację użytkownika/hasła. Spróbuj ponownie.';
                }
                else
                {
                    $_SESSION['signed_in'] = true;

                    while($row = $result->fetch_assoc( ))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    $message = "";
                    switch($_SESSION['user_level']) {
                        case ADMINISTRATOR_LEVEL:
                            $message = " Pełnisz rolę ADMINISTRATORA. Możesz edytować lub usuwać wszystkie pytania!";
                            break;
                        case MODERATOR_LEVEL:
                            $message = " Pełnisz rolę MODERATORA. Możesz usuwać wszystkie pytania lub komentarze!";
                            break;
                    }

                    echo 'Witaj, ' . $_SESSION['user_name'] . $message . '<br>'. '<a href="index.php">Przejdź do przeglądu forum</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>