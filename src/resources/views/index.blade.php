<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LARA_LABEL</title>
  <style>
    [v-cloak] {
      display: none;
    }
    body {
      min-height: 100%;
    }
  </style>

  <script src="{{ mix('js/app.js') }}" defer></script>

</head>
<body>
  <div id="app" v-colak></div>
</body>
</html>