<main>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center">Register for Batch: {{ $batch->name }}</h1>
                    <p class="text-center">Course: {{ $batch->course->title }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Available Schedules</h2>
                    <ul>
                        @foreach ($batch->schedules as $schedule)
                            <li>{{ $schedule->location }} - {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <form wire:submit.prevent="register">
                <label for="name">Your Name:</label>
                <input type="text" id="name" wire:model="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" wire:model="email" required>

                <!-- Add more fields as needed -->

                <button type="submit">Pay & Register</button>
            </form>
        </div>
    </section>
</main>

