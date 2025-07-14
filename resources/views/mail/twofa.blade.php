<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Код подтверждения</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #2d3748;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #1a202c;
            background-color: #edf2f7;
            padding: 15px 25px;
            display: inline-block;
            border-radius: 8px;
            letter-spacing: 4px;
            margin: 20px 0;
            cursor: pointer;
            user-select: all;
        }
        p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #a0aec0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Здравствуйте!</h2>
        <p>Ваш код подтверждения:</p>

        <div class="code">{{ $code }}</div>
        <p style="font-size: 14px; color: #718096;">(Выделите и нажмите <b>Ctrl+C</b>, чтобы скопировать)</p>

        <p>Этот код действителен в течение 10 минут.</p>

        <div class="footer">
            С уважением,<br>ReadyApp
        </div>
    </div>
</body>
</html>
