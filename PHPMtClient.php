<?php

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
if (!file_exists('sessions')) {
    mkdir('sessions');
}
include 'madeline.php';
global $MadelineProto;
$numb = file_get_contents("vNumber.txt");
$settings = ['madeline' => ['app_info' => ['api_id' => 303167, 'api_hash' => '241b450119dc19477484f15c94c8f272', 'lang_code' => 'it', 'app_version' => '4.7.0']], 'repeat' => "true"];
$MadelineProto = new \danog\MadelineProto\API("Voip$numb", $settings['madeline']);
if ($argv[0] == 'create') {
    echo "MTClient V1.0 by @NoMoreBadBoyZ, based on Madeline Proto\n";
    sleep(2);
    while ($settings['repeat'] == true) {
        echo "Please enter the phone number: ";
        $phoneNumber = trim(fgets(STDIN));
        $sentCode = $MadelineProto->phone_login($phoneNumber);
        echo "\nPlease enter the recieved code: ";
        $code = trim(fgets(STDIN));
        $authorization = $MadelineProto->complete_phone_login($code);
    if ($authorization['_'] === 'account.password') {
        echo "\nPlease enter the 2FA password: ";
        $password = trim(fgets(STDIN));
        $authorization = $MadelineProto->complete_2fa_login($password);
    }
    if ($authorization['_'] === 'account.needSignup') {
        echo "\nPlease enter the name for registration: ";
        $name = trim(fgets(STDIN));
        $authorization = $MadelineProto->complete_signup($name, '');
    }
    $MadelineProto->session = "sessions/Voip$numb";
    $MadelineProto->serialize("sessions/Voip$numb");
    file_put_contents("vNumber.txt", $numb++);
    echo "\n\nSession serialized!\n";
    sleep(2);
    }
}
