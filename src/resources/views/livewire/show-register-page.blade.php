<main>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-center mb-4">
                        <h1>{{ $product->batch->name ?? 'Bootcamp Batch' }}</h1>
                        <p>{{ $product->course->name ?? 'Course Title' }} Course</p>
                        <p><strong>Rp. {{ number_format($product->price, 2) }}</strong></p>
                    </div>

                    <form id="payment-form">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="student_id" class="form-label">Student ID</label>
                            <input type="text" id="student_id" name="student_id" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="student_origin" class="form-label">Student Origin</label>
                            <select id="student_origin" name="student_origin" class="form-control" required>
                                <option value="">-- Select Origin --</option>
                                <option value="KJ">KJ</option>
                                <option value="CR">CR</option>
                                <option value="KHI">KHI</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="github_name" class="form-label">GitHub Username</label>
                            <input type="text" id="github_name" name="github_name" class="form-control" required>
                        </div>

                        <div class="form-group mb-4">
                            <label for="github_url">GitHub URL (autofilled)</label>
                            <input type="text" id="github_url" class="form-control" readonly>
                        </div>

                        <div class="form-group mb-4">
                            <label>What is {{ $a }} + {{ $b }}?</label>
                            <input type="number" name="captcha" id="captcha" required class="form-control">
                            <div id="captcha-error" class="text-danger mt-1" style="display:none;"></div>
                        </div>

                        <div id="general-error" class="text-danger mb-3" style="display:none;"></div>

                        <button type="submit" class="btn btn-primary w-100" id="pay-button">
                            Pay & Register
                        </button>
                    </form>

                    <div id="payment-message" class="mt-3 text-success fw-bold" style="display: none;">
                        Payment successful! You’re registered.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const githubInput = document.getElementById('github_name');
    const githubUrl = document.getElementById('github_url');
    const form = document.getElementById('payment-form');
    const payButton = document.getElementById('pay-button');
    const captchaError = document.getElementById('captcha-error');
    const generalError = document.getElementById('general-error');

    githubInput.addEventListener('input', function () {
        githubUrl.value = this.value ? `https://github.com/${this.value}` : '';
    });

    form.addEventListener('submit', function (e) {
    e.preventDefault();

    captchaError.style.display = 'none';
    captchaError.textContent = '';
    generalError.style.display = 'none';
    generalError.textContent = '';

    payButton.disabled = true;
    payButton.textContent = 'Processing...';

    const email = form.email.value.trim();

    // Step 2a: Check if email exists
    fetch("{{ route('midtrans.check-email') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: JSON.stringify({ email: email })
    })
    .then(res => res.json())
    .then(data => {
        if (data.exists) {
            // Email already registered
            generalError.textContent = "Email is already registered. Please use a different email.";
            generalError.style.display = 'block';
            payButton.disabled = false;
            payButton.textContent = 'Pay & Register';
            throw new Error('Email already registered');
        } else {
            // Email does not exist, proceed with payment snap token request
            const formData = new FormData(form);

            return fetch("{{ route('midtrans.snap-token') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: formData
            });
        }
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            if (response.status === 422 && errorData.error) {
                captchaError.textContent = errorData.error;
                captchaError.style.display = 'block';
            } else {
                generalError.textContent = errorData.error || 'Failed to get Snap Token.';
                generalError.style.display = 'block';
            }
            throw new Error(errorData.error || 'Validation failed');
        }
        return response.json();
    })
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

                fetch("{{ route('midtrans.store-result') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(res => {
                    alert(res.message || "Registration successful! Please check your email.");
                    form.reset();
                    if (document.getElementById('payment-message')) {
                        document.getElementById('payment-message').style.display = 'block';
                    }
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
                payButton.disabled = false;
                payButton.textContent = 'Pay & Register';
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
        console.error(error);
        payButton.disabled = false;
        payButton.textContent = 'Pay & Register';
    });
    });
});
</script>
@endpush
