<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <meta name="session-id" value="{{ session()->getId() }}" />
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    </head>
    <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">

        <div id="app">
            <shop-component></shop-component>
         </div>            
                 
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
