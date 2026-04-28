<?php
$errors = [];
$success = "";

$login = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $login = trim($_POST["login"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if (!filter_var($login, FILTER_VALIDATE_REGEXP, [
        "options" => ["regexp" => "/^[a-zA-Z0-9]+$/"]
    ])) {
        $errors[] = "Логін може містити тільки букви та цифри";
    }

    if ($password !== $confirm) {
        $errors[] = "Паролі не збігаються";
    }

    if (strlen($password) < 4) {
        $errors[] = "Пароль занадто короткий (мін 4 символи)";
    }

    if (empty($errors)) {
        $success = "Реєстрація успішна!";
        $login = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Реєстрація</title>
</head>
<body>

<h2>Форма реєстрації</h2>

<?php foreach ($errors as $error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endforeach; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    Логін: <br>
    <input type="text" name="login" value="<?= htmlspecialchars($login) ?>"><br><br>

    Пароль: <br>
    <input type="password" name="password"><br><br>

    Підтвердження паролю: <br>
    <input type="password" name="confirm"><br><br>

    <button type="submit">Зареєструватися</button>
</form>

</body>
</html>