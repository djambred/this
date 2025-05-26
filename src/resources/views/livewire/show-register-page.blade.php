<main>
<section class="section">
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-lg-6">
				<div class="section-title text-center">
					<p class="text-primary text-uppercase fw-bold mb-3">Register for Bootcamp</p>
					<h1>{{ $product->batch->name }}</h1>
                    <p>{{ $product->course->title }} Course</p>
                    <p>Rp. {{ number_format($product->price ?? 0, 2) }}</p>
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
                    <label for="student_id" class="form-label">Student ID (NIM)</label>
                    <input type="text" id="student_id" wire:model.defer="student_id" class="form-control shadow-none rounded" />
                    @error('student_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-4 pb-2">
                    <label for="student_origin" class="form-label">Student Origin (Asal Kampus)</label>
                    <input type="text" id="student_origin" wire:model.defer="student_origin" class="form-control shadow-none rounded" />
                    @error('student_origin') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mb-4 pb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" wire:model.defer="email" class="form-control shadow-none rounded" />
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" id="phone" wire:model.defer="phone" class="form-control shadow-none rounded" />
                    @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" wire:model.defer="address" class="form-control shadow-none rounded"></textarea>
                    @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="github_name" class="form-label">Github Name</label>
                    <input type="text" id="github_name" wire:model.defer="github_name" class="form-control shadow-none rounded" />
                    @error('github_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="github_url" class="form-label">Github URL</label>
                    <input type="text" id="github_url" wire:model.defer="github_url" class="form-control shadow-none rounded" />
                    @error('github_url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded" name="payAndRegister" id="payAndRegister" wire:click.prevent="payAndRegister">
                    Pay & Register
                </button>
            </form>
                @if (session()->has('success'))
                    <div class="alert alert-success mt-4">{{ session('success') }}</div>
                @endif
        </div>
    </section>
</main>

<!-- Midtrans Snap Payment Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key={{ config('midtrans.client_key') }}></script>

<script>
    window.addEventListener('midtrans:show-snap', event => {
        const snapToken = event.detail.snapToken;

        if (!snapToken) {
            alert('Payment token not found!');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                Livewire.emit('midtrans:payment-success', result);
            },
            onPending: function(result) {
                alert('Please complete the payment!');
            },
            onError: function(result) {
                alert('Payment failed!');
            },
            onClose: function() {
                alert('You closed the payment popup without finishing.');
            }
        });
    });
</script>

