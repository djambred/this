<main>
<section class="section">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-lg-6">
				<div class="section-title text-center">
					<p class="text-primary text-uppercase fw-bold mb-3">Register for Bootcamp</p>
					<h1>{{ $batch->name }}</h1>
					<p>{{ $batch->course->title }} Course</p>
                    <p>Rp. {{ number_format($paymentAmount, 2) }}</p>
				</div>
            </div>

            @if (session()->has('success'))
                <div class="bg-green-100 p-3 rounded mb-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="payAndRegister">
                <div class="form-group mb-4 pb-2">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" wire:model.defer="name" class="form-control shadow-none rounded" />
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-4 pb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" wire:model.defer="email" class="form-control shadow-none rounded" />
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone (optional)</label>
                    <input type="text" id="phone" wire:model.defer="phone" class="form-control shadow-none rounded" />
                    @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                @error('payment')
                    <div class="mb-3 text-red-600">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary w-100 rounded">
                    Pay & Register
                </button>
            </form>

        </div>
    </section>
</main>
