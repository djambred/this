@php
    $seo = \App\Models\Front\Seo::first();
@endphp

<head>
<meta charset="utf-8">
<title>{{ $title ?? $seo->title }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
<meta name="description" content="{{ $seo->description }}">
<meta name="keywords" content="{{ $seo->keywords }}">
<meta name="author" content="djambred">
<meta name="robots" content="{{ $seo->robots }}">

<!-- Canonical -->
<link rel="canonical" href="{{ $seo->canonical_url }}">

<!-- Open Graph -->
<meta property="og:title" content="{{ $title ?? $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('storage/' . $seo->og_image) }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? 'BOOTCAMP' }}">
<meta name="twitter:description" content="{{ $description ?? 'Explore services offered by PemWeb' }}">
<meta name="twitter:image" content="{{ asset('storage/' . $seo->og_image) }}">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('storage/' . $seo->og_image) }}" type="image/x-icon">
<link rel="icon" href="{{ asset('storage/' . $seo->og_image) }}" type="image/x-icon">

<!-- Fonts & CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('front/plugins/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('front/plugins/font-awesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('front/plugins/font-awesome/brands.css') }}">
<link rel="stylesheet" href="{{ asset('front/plugins/font-awesome/solid.css') }}">
<link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

@livewireStyles
</head>
