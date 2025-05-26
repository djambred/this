@php
    use App\Models\Front\PageConfig;
    use App\Models\Product;

    $pageconf = PageConfig::first();
    $products = Product::with(['batch.course', 'batch.schedules'])->get();
@endphp

<main>
      <section class="banner bg-tertiary position-relative overflow-hidden">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
              <div class="block text-center text-lg-start pe-0 pe-xl-5">
                <h1 class="text-capitalize mb-4">{{ $pageconf->title }}</h1>
                <p class="mb-4">{{ $pageconf->description }}</p> <a wire:navigate type="button"
                  class="btn btn-primary" href="{{ $pageconf->url }}" data-bs-toggle="modal" data-bs-target="#apply">See More<span style="font-size: 14px;" class="ms-2 fas fa-arrow-right"></span></a>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="ps-lg-5 text-center">
                <img loading="lazy" decoding="async"
                  src="{{ asset('storage/' . $pageconf->image) }}"
                  alt="banner image" class="w-100">
              </div>
            </div>
          </div>
        </div>

      </section>

      <section class="section">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6">
              <div class="section-title pt-4">
                <p class="text-primary text-uppercase fw-bold mb-3">{{ $pageconf->name_services }}</p>
                <h1>{{ $pageconf->description_services }}</h1>
                <p>{{ $pageconf->detail_services }}</p>
              </div>
            </div>
            @foreach($products as $index => $product)
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="{{ route('register.batch', $product->batch->id) }}" target="_blank" rel="noopener noreferrer">
                        <div class="block">
                            <span class="colored-box text-center h3 mb-4">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->course->title ?? 'Course' }}"
                                    class="img-fluid mb-3 w-100"
                                    style="height: 200px; object-fit: cover; border-radius: 0.5rem;" />
                            @endif

                            <h3 class="mb-3 service-title">{{ $product->batch->name ?? '-' }}</h3>
                            <p class="mb-0 service-description">{{ $product->batch->course->title ?? 'Course' }}Course</p>

                            {{-- Show related schedules --}}
                            @if($product->batch && $product->batch->schedules->isNotEmpty())
                                <ul class="mt-2 ps-3">
                                    @foreach($product->batch->schedules as $schedule)
                                        <li>
                                            Location at {{ $schedule->location }}<br>
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('d M Y') }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mt-2">No schedules available</p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
          </div>
        </div>
      </section>
</main>
