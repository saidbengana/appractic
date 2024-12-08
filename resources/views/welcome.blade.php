<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Appractic</title>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: #f7fafc;
            }
            .container {
                text-align: center;
                padding: 2rem;
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                width: 90%;
            }
            h1 {
                color: #2d3748;
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            p {
                color: #4a5568;
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            .logo {
                margin-bottom: 2rem;
                font-size: 3rem;
                color: #4299e1;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">🚀</div>
            <h1>Welcome to Appractic</h1>
            <p>Your application is ready to go! Start building something amazing.</p>
        </div>
    </body>
</html>
