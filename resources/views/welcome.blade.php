<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
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
            }
            h1 {
                color: #2d3748;
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }
            p {
                color: #4a5568;
                margin-bottom: 2rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Welcome to Laravel on Platform.sh</h1>
            <p>Your application is now running on Platform.sh!</p>
        </div>
    </body>
</html>
