<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Reservation Details</h1>

        <div class="bg-white p-6 rounded shadow space-y-3">
            <p><strong>Section:</strong> {{ $reservation->section->name }}</p>
            <p><strong>Date:</strong> {{ $reservation->date }}</p>
            <p><strong>Time Slot:</strong> {{ $reservation->time_slot }}</p>
            <p><strong>Purpose:</strong> {{ $reservation->purpose }}</p>

            @if($reservation->resource_details)
                <p><strong>Resource Details:</strong><br>{{ $reservation->resource_details }}</p>
            @endif

            @if($reservation->usage_details)
                <p><strong>Usage Details:</strong><br>{{ $reservation->usage_details }}</p>
            @endif

            <p><strong>Status:</strong> {{ ucfirst($reservation->status) }}</p>
        </div>

        <a href="{{ route('reservations.my') }}"
           class="inline-block mt-6 text-blue-600 hover:underline">
            ← Back to My Bookings
        </a>
    </div>
</x-app-layout>
