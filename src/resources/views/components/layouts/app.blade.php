<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.partials.header')

<body>

@include('components.partials.navbar')

{{ $slot }}

@include('components.partials.footer')
@include('components.partials.scripts')
</body>
</html>
