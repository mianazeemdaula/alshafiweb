<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alshaafi Online </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
  </head>
  <body>
    <main class="flex-1 p-6 bg-gray-100 overflow-y-auto">
          @yield('content')
    </main>
  </body>
</html>
