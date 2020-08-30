<?php
require_once 'class/sendSmsEmail.php';

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
    array_push($errors, ' Name can not be Empty or less than 3 letters');

}if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    array_push($errors, 'Invalid email address');

}if (empty($_POST['messageText']) || strlen($_POST['messageText']) < 10) {
    array_push($errors, 'Why Why and Why are u trying to send small message');

}

sendMessage($errors);

function sendMessage($errors) {

    if (count($errors) > 0) {
        echo json_encode(['errors' => $errors]);

    } else {
        $send = new sendSmsEmail();
        $send->name = $_POST['name'];
        $send->reply_email = $_POST['email'];
        $send->message = $_POST['messageText'];
        $send->subject = $_POST['name'] . ' Wants to Contact With You';

        if ($send->sendEmail()) {
            sendSuccess();
        } else {
            echo json_encode(['errors' => 'Sorry Error Occured,I will Fix This PROMISE!!']);
        }
    }

}

function sendSuccess() {

    echo json_encode(['success' => ' Hurray ! Trust me I will contact with You']);
}

?>