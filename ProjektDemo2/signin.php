<?php
//signin.php
$conn="";
include 'connect.php';
include 'header.php';

echo '<h3>Zaloguj się</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Jesteś już zalogowany, możesz <a href="signout.php">wylogować się</a> jeśli chcesz.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
            Nazwa użytkownika: <input type="text" name="user_name" />
            Hasło: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
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
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "SELECT 
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_name = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";

            //echo "sql: " . $sql;

            $mysqli = new mysqli("localhost","root","admin","myschema1");

            $result = $mysqli->query($sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Podczas logowania coś poszło nie tak. Spróbuj ponownie później.';
                //echo mysql_error(); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'Podałeś niewłaściwą kombinację użytkownika/hasła. Spróbuj ponownie.';
                }
                else
                {
                   // session_start();
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc( $result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    echo 'Witaj, ' . $_SESSION['user_name'] . '. <a href="index.php">Przejdź do przeglądu forum</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>