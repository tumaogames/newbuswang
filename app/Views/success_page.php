<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Registration Successful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }

        h1 {
            color: #2ecc71;
        }

        p {
            color: #333;
            font-size: 18px;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2ecc71;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <i class="fas fa-check-circle success-icon"></i>
    <h1>Registration Successful!</h1>
    <p>Thank you for registering with us.</p>
    <button class="btn" onclick="window.location.href = '/admin_login';">Login</button>
</body>
</html>
