<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Login' }}</title>

    <!-- Import Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css') {{-- kalau kamu pakai vite atau mix --}}

</head>
<body class="bg-[#0D1235] font-sans min-h-screen flex items-center justify-center">

    {{ $slot }}

</body>
</html>
