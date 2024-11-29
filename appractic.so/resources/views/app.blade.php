<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <title inertia>Appractic{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/vendor/appractic/favicon.ico') }}">
    @routes
    {{ appracticAssets() }}
    @inertiaHead
</head>
<body class="font-sans">
@inertia
</body>
</html>
