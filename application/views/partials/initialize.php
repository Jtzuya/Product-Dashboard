<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shoppee</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/global.css') ?>" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>
    <body>
        <h1>WELCOME <?= $this->session->userdata('first_name'); ?>...</h1>