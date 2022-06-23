<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h3>Rejestracja</h3>';

echo "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '<form method="post" action="">
        <table>
          <tr>
            <td>Nazwa użytkownika:</td> 
            <td><input type="text" name="user_name" /></td>
          </tr>
          <tr>
            <td>Hasło:</td> 
            <td><input type="password" name="user_pass" /></td>
          </tr>
          <tr>
            <td>Powtórz hasło:</td> 
            <td><input type="password" name="user_pass_check" /></td>
          </tr>
          <tr>
            <td>E-mail:</td> 
            <td><input type="email" name="user_email"></td>
          </tr>
        </table> 
        <input type="submit" value="Potwierdź" />
     </form>';
} else {

    $errors = array();

    if (isset($_POST['user_name'])) {
        if (!ctype_alnum($_POST['user_name'])) {
            $errors[] = 'Nazwa użytkownika może zawierać tylko litery i cyfry.';
        }
        if (strlen($_POST['user_name']) > 30) {
            $errors[] = 'Nazwa użytkownika nie może być dłuższa niż 30 znaków.';
        }
    } else {
        $errors[] = 'Pole nazwy użytkownika nie może być puste.';
    }

    if (isset($_POST['user_pass'])) {
        if ($_POST['user_pass'] != $_POST['user_pass_check']) {
            $errors[] = 'Podane hasła do siebie nie pasują..';
        }
    } else {
        $errors[] = 'Pole hasła nie może być puste.';
    }

    if (!empty($errors)) {
        echo 'Uh-oh.. kilka pól nie jest wypełnionych poprawnie..';
        echo '<ul>';
        foreach ($errors as $key => $value) {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
    } else {
        date_default_timezone_set('UTC');

        $user_name = $_POST['user_name'];
        $user_pass = $_POST['user_pass'];
        $user_email = $_POST['user_email'];
        $user_date = date('Y-m-d H:i:s');

        $user_level = 0;

        $sql = "INSERT INTO
                    uzytkownicy(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . $mysqli->real_escape_string($_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . $mysqli->real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)";

        if ($mysqli->query($sql) === TRUE) {
            echo 'Zarejestrowano pomyślnie. Możesz teraz <a href="login.php">zalogować się</a> i zacząć publikować! :-)';
        } else {
            echo "'Coś poszło nie tak podczas rejestracji. Spróbuj ponownie później.'" . $sql . "<br>";
        }
        $mysqli->close();
    }
}

?>