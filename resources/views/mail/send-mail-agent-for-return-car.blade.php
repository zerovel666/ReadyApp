<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Car Delivery Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 {
            color: #2c3e50;
        }
        p {
            margin: 5px 0;
        }
        .location {
            margin-bottom: 15px;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Car Return Task</h2>

        <p><strong>Deadline:</strong> {{ $deadlineTime }}</p>

        <div class="location">
            <h4>Pickup Location:</h4>
            <p>
                Coordinates: {{ $latitude_a }}, {{ $longitude_a }}<br>
                <a href="https://www.google.com/maps?q={{ $latitude_a }},{{ $longitude_a }}" target="_blank">
                    View on Google Maps
                </a>
            </p>
        </div>

        <div class="location">
            <h4>Drop-off Location:</h4>
            <p>
                Coordinates: {{ $latitude_b }}, {{ $longitude_b }}<br>
                <a href="https://www.google.com/maps?q={{ $latitude_b }},{{ $longitude_b }}" target="_blank">
                    View on Google Maps
                </a>
            </p>
        </div>

        <p>Please ensure the car is delivered before the deadline.</p>

        <div class="footer">
            This is an automated message from ReadyApp.
        </div>
    </div>
</body>
</html>
