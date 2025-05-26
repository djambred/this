<main>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-center mb-4">
                        <h1>{{ $product->batch->name ?? 'Bootcamp Batch' }}</h1>
                        <p>{{ $product->course->title ?? 'Course Title' }} Course</p>
                        <p><strong>Rp. {{ number_format($product->price, 2) }}</strong></p>
                    </div>

                    <form id="payment-form">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">

                        @foreach (['name','email','student_id','student_origin','phone','address','github_name'] as $field)
                            <div class="form-group mb-3">
                                <label class="form-label text-capitalize" for="{{ $field }}">
                                    {{ str_replace('_', ' ', $field) }}
                                </label>
                                <input
                                    type="{{ $field === 'email' ? 'email' : 'text' }}"
                                    class="form-control"
                                    id="{{ $field }}"
                                    name="{{ $field }}"
                                    required
                                >
                            </div>
                        @endforeach

                        <div class="form-group mb-4">
                            <label for="github_url">GitHub URL (autofilled)</label>
                            <input type="text" id="github_url" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="pay-button">Pay & Register</button>
                    </form>

                    <div id="payment-message" class="mt-3 text-success fw-bold" style="display: none;">
                        Payment successful! You’re registered.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


{{-- @push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const githubInput = document.getElementById('github_name');
        const githubUrl = document.getElementById('github_url');

        githubInput.addEventListener('input', function () {
            githubUrl.value = this.value ? `https://github.com/${this.value}` : '';
        });

        document.getElementById('payment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const payButton = document.getElementById('pay-button');
            payButton.disabled = true;
            payButton.textContent = 'Processing...';

            const formData = new FormData(form);

            fetch("{{ route('midtrans.snap-token') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        document.getElementById('payment-message').style.display = 'block';
                        console.log('Success:', result);

                        // Optionally: Send result to server to store order/user data
                        // fetch('/midtrans/store-result', {...})
                    },
                    onPending: function(result) {
                        alert("Payment pending...");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("Payment failed.");
                        console.error(result);
                        payButton.disabled = false;
                        payButton.textContent = 'Pay & Register';
                    },
                    onClose: function() {
                        alert('You closed the payment popup.');
                        payButton.disabled = false;
                        payButton.textContent = 'Pay & Register';
                    }
                });
            })
            .catch(error => {
                alert("Failed to get Snap Token.");
                console.error(error);
                payButton.disabled = false;
                payButton.textContent = 'Pay & Register';
            });
        });
    });
</script>
@endpush --}}


@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const githubInput = document.getElementById('github_name');
    const githubUrl = document.getElementById('github_url');

    githubInput.addEventListener('input', function () {
        githubUrl.value = this.value ? `https://github.com/${this.value}` : '';
    });

    document.getElementById('payment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const payButton = document.getElementById('pay-button');
        payButton.disabled = true;
        payButton.textContent = 'Processing...';

        const formData = new FormData(form);

        fetch("{{ route('midtrans.snap-token') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    const payload = {
                        name: form.name.value,
                        email: form.email.value,
                        student_id: form.student_id.value,
                        student_origin: form.student_origin.value,
                        phone: form.phone.value,
                        address: form.address.value,
                        github_name: form.github_name.value,
                        github_url: githubUrl.value,
                        product_id: form.product_id.value,
                        midtrans_result: result,
                    };

                    fetch("/midtrans/store-result", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(res => {
                        alert("Registration successful! Please check your email.");
                        form.reset();
                        document.getElementById('payment-message').style.display = 'block';
                        payButton.disabled = false;
                        payButton.textContent = 'Pay & Register';
                    })
                    .catch(err => {
                        alert("Registration failed after payment.");
                        console.error(err);
                        payButton.disabled = false;
                        payButton.textContent = 'Pay & Register';
                    });
                },
                onPending: function(result) {
                    alert("Payment pending...");
                    console.log(result);
                },
                onError: function(result) {
                    alert("Payment failed.");
                    console.error(result);
                    payButton.disabled = false;
                    payButton.textContent = 'Pay & Register';
                },
                onClose: function() {
                    alert('You closed the payment popup.');
                    payButton.disabled = false;
                    payButton.textContent = 'Pay & Register';
                }
            });
        })
        .catch(error => {
            alert("Failed to get Snap Token.");
            console.error(error);
            payButton.disabled = false;
            payButton.textContent = 'Pay & Register';
        });
    });
});
</script>
@endpush
