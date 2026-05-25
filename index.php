<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "base_for_calculator";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

if (isset($_POST['login'])) {

    $username = $_POST['username'] ?? null;
    $mail = $_POST['mail'] ?? null;

    if (!$username || !$mail) {
        echo "Wypełnij wszystkie pola";
    } else {

        $check = $conn->prepare("SELECT * FROM users WHERE username=? AND mail=?");

        if (!$check) {
            die("Błąd SQL: " . $conn->error);
        }

        $check->bind_param("ss", $username, $mail);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {
            header("Location: calculator.php");
            exit;
        } else {
            $create = $conn->prepare("INSERT INTO users (username, mail) VALUES (?, ?)");
            $create->bind_param("ss", $username, $mail);
            $create->execute();

            header("Location: calculator.php");
            exit;
        }
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nazwa użytkownika" required><br>
    <input type="email" name="mail" placeholder="Email" required><br>
    <button type="submit" name="login">Zaloguj się</button>
</form>
