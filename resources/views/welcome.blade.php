<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
       <div class="container mt-4">
           <h2>Welcome to API</h2>
       </div>
       <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
