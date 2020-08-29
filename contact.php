<?php
$_POST = json_decode(file_get_contents("php://input"), true);

$errors = [];

if (!isset($_POST['name'])) {
    array_push($errors, ' Name key is Required');
}

if (!isset($_POST['email'])) {
    array_push($errors, ' Email Key is Required');
}

if (!isset($_POST['messageText'])) {
    array_push($errors, 'messageText Key is Required');
}

if (empty($_POST['name']) || strlen($_POST['name']) < 3) {
    array_push($errors, ' Name can Not be Empty or less than 3 letters');

}if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    array_push($errors, 'Invalid email address');

}if (empty($_POST['messageText']) || strlen($_POST['messageText']) < 10) {
    array_push($errors, 'Why Why and Why are u trying send small message');

}

sendMessage($errors);

function sendMessage($errors) {

    if (count($errors) > 0) {
        echo json_encode(['errors' => $errors]);

    } else {
        sendSuccess();
    }

}

function sendSuccess() {

    echo json_encode(['success' => ' Hurray ! Trust me I will contact with You']);
}

?>