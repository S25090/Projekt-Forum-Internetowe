<?php
$conn="";
//include 'connect.php';
include 'header.php';


echo '<h3>Sign up</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="">
        Nazwa użytkownika: <input type="text" name="user_name" /><br>
        Hasło: <input type="password" name="user_pass"><br>
        Powtórz hasło: <input type="password" name="user_pass_check"><br>
        E-mail: <input type="email" name="user_email"><br>
        <input type="submit" value="Potwierdź" /><br>
     </form>';
}
else
{

    $errors = array();

    if(isset($_POST['user_name']))
    {
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'Nazwa użytkownika może zawierać tylko litery i cyfry.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'Nazwa użytkownika nie może być dłuższa niż 30 znaków.';
        }
    }
    else
    {
        $errors[] = 'Pole nazwy użytkownika nie może być puste.';
    }


    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'Podane hasła do siebie nie pasują..';
        }
    }
    else
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
        date_default_timezone_set('UTC');


        $user_name = $_POST['user_name'];
        $user_pass = $_POST['user_pass'];
        $user_email = $_POST['user_email'];
        $user_date = date('Y-m-d H:i:s');

        $user_level = 0;

        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . mysqli_real_escape_string($conn, $_POST['user_name']). "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "',
                        NOW(),
                        0)";

        if ($conn->query($sql) === TRUE) {
            echo 'Zarejestrowano pomyślnie. Możesz teraz <a href="signin.php">zalogować się</a> i zacząć publikować! :-)';
        } else {
            echo "'Coś poszło nie tak podczas rejestracji. Spróbuj ponownie później.'" . $sql . "<br>" . $conn->error;
        }

        mysqli_close($conn);

    }
}

?>