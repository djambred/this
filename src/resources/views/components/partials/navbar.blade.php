@php
    use App\Models\Front\Logo;
    $logo = Logo::first();
@endphp

<!-- navigation -->
<header class="navigation bg-tertiary">
	<nav class="navbar navbar-expand-xl navbar-light text-center py-3">
		<div class="container">
            <a class="navbar-brand" href="{{ route ('home') }}">
            @if (!empty($logo->image))
            <img
                loading="preload"
                decoding="async"
                class="img-fluid"
                width="160"
                src="{{ asset('storage/' . $logo->image) }}"
                alt="{{ $logo->title }}"
            >
        @else
            <span class="h4 text-primary">{{ $logo->title }}</span>
        @endif
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav m-auto mb-2 mb-lg-0">
					<li class="nav-item"> <a wire:navigate class="nav-link" href="{{ route ('home') }}">Home</a></li>
			</div>
		</div>
	</nav>
</header>
<!-- /navigation -->
