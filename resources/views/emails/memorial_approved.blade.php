<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mémorial NAC</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            color: #000;
            padding: 20px;
            text-align: center;
            width: 100%;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        header p {
            margin: 5px 0 0;
            font-size: 1.2em;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mascot {
            text-align: center;
            margin: 20px 0;
        }

        .mascot img {
            max-width: 200px;
            border-radius: 50%;
            border: 4px solid #8dc6bf;
        }

        .content h2 {
            color: #633942;
        }

        .content p {
            line-height: 1.6;
        }

        footer {
            color: #000;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        footer a {
            color: #000;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <img src="https://nac.memorial/assets/frontend/images/hero/logo1.png" width="150px">
    </header>
    <div class="container">
        <div class="content">
            <h2>{{ $content->title }}</h2>
            <p>{{ $content->subtitle }}</p>
            <p>{{ $content->content }}</p>
            <p>Click here to view your memorial {{ route('show.obituary', [$memorial->id, $memorial->slug]) }}</p>
        </div>
    </div>
    <footer>
        <p>{{ $content->footer }}<a href="{{ route('contact') }}" style="color: #000; text-decoration: none;"> &middot;
                Contect
                us</a></p>
    </footer>
</body>

</html>
