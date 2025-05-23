@php
    use App\Models\Front\FooterLink;
    use App\Models\Front\Jargon;
    $sections = FooterLink::orderBy('order')->get()->groupBy('section');
    $jargon = Jargon::first();
@endphp

<footer class="section-sm bg-tertiary">
	<div class="container">
		<div class="row justify-content-between">
			@foreach($sections as $section => $links)
				<div class="col-lg-2 col-md-4 col-6 mb-4">
					<div class="footer-widget">
						<h5 class="mb-4 text-primary font-secondary">{{ ucwords(str_replace('_', ' ', $section)) }}</h5>
						<ul class="list-unstyled">
							@foreach($links as $link)
								<li class="mb-2"><a href="{{ $link->url }}">{{ $link->label }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			@endforeach
		</div>
        <div class="container d-flex justify-content-center">
            <a wire:navigate href="{{ route ('home') }}">{{ $jargon->slogan }}</a>
        </div>
	</div>
</footer>
