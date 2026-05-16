<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .maintenance-container {
            text-align: center;
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
        }

        .maintenance-icon {
            width: auto;
            height: 100px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 15px;
        }

        p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 30px;
        }

        .progress-bar {
            background: #e0e0e0;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            height: 15px;
        }

        .progress {
            background: linear-gradient(90deg, #4caf50, #81c784);
            width: 60%;
            height: 100%;
            animation: loading 2s infinite;
        }

        @keyframes loading {
            0% {
                width: 0;
            }
            100% {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-content">
            <img src="young.png" alt="Maintenance Icon" class="maintenance-icon">
            <h1>We'll Be Back Soon!</h1>
            <p>
                Our site is currently undergoing scheduled maintenance. 
                We apologize for any inconvenience and appreciate your patience. 
                Please check back later.
            </p>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
        </div>
    </div>
</body>
</html>
