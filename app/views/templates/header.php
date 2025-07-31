<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SmartFarm POS' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* CSS Sederhana untuk Tema Hijau & Font */
        :root {
            --primary-green: #28a745; /* Hijau Bootstrap */
            --light-green: #e9f5e9;
            --dark-green: #1e7e34;
            --text-color: #333;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .bg-primary-green {
            background-color: var(--primary-green) !important;
        }
        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>