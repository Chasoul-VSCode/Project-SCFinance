<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SC Finance</title>
    <script>
        // Redirect to login page
        window.location.href = "{{ route('login') }}";
    </script>
</head>
<body>
</body>
</html>
