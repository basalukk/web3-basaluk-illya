<?php

// ==========================
// ВАРІАНТ 1: КОРИСТУВАЧІ
// ==========================

$users = [
    ["name" => "Ivan", "age" => 17, "email" => "ivan@gmail.com"],
    ["name" => "Oleh", "age" => 22, "email" => "oleh@gmail.com"],
    ["name" => "Anna", "age" => 19, "email" => "anna@gmail.com"],
    ["name" => "Marta", "age" => 16, "email" => "marta@gmail.com"],
    ["name" => "Dmytro", "age" => 25, "email" => "dmytro@gmail.com"],
    ["name" => "Sofia", "age" => 18, "email" => "sofia@gmail.com"],
    ["name" => "Pavlo", "age" => 30, "email" => "pavlo@gmail.com"],
    ["name" => "Ira", "age" => 21, "email" => "ira@gmail.com"],
    ["name" => "Yurii", "age" => 14, "email" => "yurii@gmail.com"],
    ["name" => "Kateryna", "age" => 20, "email" => "katya@gmail.com"],
];

// Фільтр 18+
function filterAdults($users) {
    return array_filter($users, fn($u) => $u["age"] >= 18);
}

// сортування по довжині імені
function compareByNameLength($a, $b) {
    return strlen($a["name"]) <=> strlen($b["name"]);
}

$adults = filterAdults($users);
usort($adults, "compareByNameLength");


// ==========================
// ВАРІАНТ 2: ПАРОЛІ
// ==========================

// генерація пароля
function generatePassword($length) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }

    return $password;
}

// перевірка складності
function isStrongPassword($password) {
    return preg_match('/[A-Z]/', $password) &&   // велика літера
           preg_match('/[0-9]/', $password) &&   // цифра
           strlen($password) >= 8;               // довжина
}

// генерація тільки сильних паролів
function generateStrongPasswords($count, $length) {
    $result = [];
    $tries = 0;

    while (count($result) < $count) {
        $tries++;

        $pass = generatePassword($length);

        if (isStrongPassword($pass)) {
            $result[] = $pass;
        }
    }

    return $result;
}

// ====== Ввід з форми ======
$passwords = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $count = $_POST["count"];
    $length = $_POST["length"];

    $passwords = generateStrongPasswords($count, $length);
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Практична PHP</title>
    <style>
        table { border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>

<h2>ВАРІАНТ 1: Користувачі 18+</h2>

<table>
    <tr>
        <th>Ім'я</th>
        <th>Вік</th>
        <th>Email</th>
    </tr>

    <?php foreach ($adults as $u): ?>
        <tr>
            <td><?= $u["name"] ?></td>
            <td><?= $u["age"] ?></td>
            <td><?= $u["email"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>

<h2>ВАРІАНТ 2: Генерація паролів</h2>

<form method="POST">
    <label>Кількість паролів:</label>
    <input type="number" name="count" required>

    <br><br>

    <label>Довжина пароля:</label>
    <input type="number" name="length" required>

    <br><br>

    <button type="submit">Згенерувати</button>
</form>

<?php if (!empty($passwords)): ?>
    <h3>Результат:</h3>
    <ul>
        <?php foreach ($passwords as $p): ?>
            <li><?= $p ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>