<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Edytuj użytkownika</h2>';
if($_SESSION['signed_in'] == false)
{
    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a> aby edytować pytanie.';
}
else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $sql = "SELECT
                    user_id,
                    user_name,
                    user_pass,
                    user_email
                FROM
                    uzytkownicy
                WHERE user_id = " . $_SESSION['user_id'];
            ;

        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Błąd podczas odczytu z bazy danych. Spróbuj ponownie później.';
        } else {
                $row = $result->fetch_assoc();

            echo '<form method="post" action="">
                <table>
                  <tr>
                    <td>Nazwa użytkownika:</td> 
                    <td><input type="text" name="user_name" value="'. $row['user_name'] . '"/></td>
                  </tr>
                  <tr>
                    <td>Hasło:</td> 
                    <td><input type="password" name="user_pass" value="'. $row['user_name']. '"/></td>
                  </tr>
                  <tr>
                    <td>Powtórz hasło:</td> 
                    <td><input type="password" name="user_pass_check" value="'. $row['user_name']. '"/></td>
                  </tr>
                  <tr>
                    <td>E-mail:</td> 
                    <td><input type="email" name="user_email" value="'. $row['user_email']. '"/></td>
                  </tr>
                </table> 
                <input type="submit" value="Potwierdź" />
            </form>';
        }
    } else {
        $sql = "UPDATE uzytkownicy
                SET user_name ='" . $_POST['user_name'] ."',".
                   "user_pass ='" . $_POST['user_pass'] ."',".
                   "user_email ='" . $_POST['user_email'] ."'".
                "WHERE user_id = " . $_SESSION['user_id'];

        echo $sql;
        $result = $mysqli->query($sql);
        header("Location: index.php" );
    }
}
?>