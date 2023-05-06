<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = $_POST['name'];
    $surname          = $_POST['surname'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['password2'];

    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Невірний формат email';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Паролі не співпадають';
    }
    $existing_users = [
        ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'password' => 'password1'],
        ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com', 'password' => 'password2'],
        ['id' => 3, 'name' => 'Bob', 'email' => 'bob@example.com', 'password' => 'password3'],
    ];
    $existing_user  = null;
    foreach ($existing_users as $user) {
        if ($user['email'] === $email) {
            $existing_user = $user;
            break;
        }
    }

    if ($existing_user) {
        $log_message = "Користувач з email {$email} вже існує";
    } else {
        $log_message = "Користувач з email {$email} не існує і може бути створений";
    }
    file_put_contents('log.txt', $log_message);

    if (!$existing_user) {
        $new_user         = [
            'id'       => count($existing_users) + 1,
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ];
        $existing_users[] = $new_user;
    }

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => implode(", ", $errors)]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Користувача успішно зареєстровано']);
    }
}