<main>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <h1>{{ $product->batch->name ?? 'Bootcamp Batch' }}</h1>
                        <p>{{ $product->course->title ?? 'Course Title' }} Course</p>
                        <p>Rp. {{ number_format($product->price ?? 0, 2) }}</p>
                    </div>

                    @if (session()->has('success'))
                        <div class="bg-green-100 p-3 rounded mb-4 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="payAndRegister">
                        @foreach (['name','student_id','student_origin','email','phone','address','github_name'] as $field)
                            <div class="form-group mb-3">
                                <label class="form-label text-capitalize" for="{{ $field }}">
                                    {{ str_replace('_', ' ', $field) }}
                                </label>
                                <input
                                    type="{{ $field === 'email' ? 'email' : 'text' }}"
                                    id="{{ $field }}"
                                    class="form-control"
                                    wire:model.defer="{{ $field }}"
                                >
                                @error($field)
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group mb-3">
                            <label for="github_url" class="form-label">GitHub URL</label>
                            <input
                                type="text"
                                id="github_url"
                                class="form-control"
                                wire:model="github_url"
                                readonly
                            >
                            @error('github_url')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="pay-button">
                            Pay & Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

@push('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        Livewire.on('midtrans:show-snap', ({ snapToken }) => {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    Livewire.emit('midtrans:payment-success', result);
                },
                onPending: function(result) {
                    alert('Payment pending. Please wait...');
                },
                onError: function(result) {
                    alert('Payment failed. Try again.');
                },
                onClose: function() {
                    alert('You closed the payment popup without finishing.');
                }
            });
        });
    </script>
@endpush
