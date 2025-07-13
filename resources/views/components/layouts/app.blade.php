<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>{{ $title ?? 'Page Title' }}</title>
        <style>
        html, body {
            background-color: #030712;
        }

        label {
            color: #7b82e3;
        }
        .error {
            color:rgb(219, 14, 14);
        }
    </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
