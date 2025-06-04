<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= isset($pageTitle) ? $pageTitle : 'Admin - Auth' ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <style>
        /* Tùy chỉnh CSS căn bản cho form auth */
        body {
            background-color: #f5f5f5;
        }
        .auth-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        .auth-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="auth-container">
