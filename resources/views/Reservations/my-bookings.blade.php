<x-app-layout>

    <div class="py-8 max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6">My Bookings</h1>

        @if ($reservations->isEmpty())
            <p>You have no reservations yet.</p>
        @else

        <div class="flex items-center justify-between mb-4">
        <input
            type="text"
            placeholder="Search bookings..."
            class="border rounded-md px-4 py-2 w-64 focus:outline-none focus:ring focus:ring-maroon-300"
            onkeyup="filterBookings(this.value)"
        >
    </div>
            <table class="w-full border-collapse bg-white border-gray-300 shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Section</th>
                        <th class="border px-3 py-2">Date</th>
                        <th class="border px-3 py-2">Time Slot</th>
                        <th class="border px-3 py-2">Purpose</th>
                        <th class="border px-3 py-2">Status</th>
                        <th class="border px-3 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr>
                            <td class="border px-3 py-2">
                                {{ $reservation->section->name }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $reservation->date }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $reservation->time_slot }}
                            </td>

                            <td class="border px-3 py-2">
                                {{ $reservation->purpose }}
                            </td>

                            {{-- Status Badge --}}
                                @php
                                    $statusCellClasses = match ($reservation->status) {
                                        'approved' => 'bg-green-600 text-white',
                                        'pending' => 'bg-yellow-500 text-black',
                                        'disapproved' => 'bg-red-600 text-white',
                                        'no show' => 'bg-gray-400 text-white',
                                        default => 'bg-gray-300 text-black',
                                    };
                                @endphp

                            <td class="border text-center font-semibold p-0">
                                        <div class="w-full h-full py-3 {{ $statusCellClasses }}">
                                    {{ strtoupper(str_replace('_', ' ', $reservation->status)) }}
                                </div>
                            </td>


                            {{-- ACTION --}}
                            <td class="text-sm border px-3 py-2 pl-6">
                                <div class="flex items-center gap-4">

                                    {{-- View Details --}}
                                    <button
                                        type="button"
                                        onclick="toggleDetails({{ $reservation->id }})"
                                        class="text-blue-600 underline hover:text-blue-800"
                                    >
                                        View Details
                                    </button>

                                    {{-- Add to Calendar (approved only) --}}
                                    @if ($reservation->status === 'approved')
                                        <a
                                            href="{{ $reservation->google_calendar_url ?? 'https://calendar.google.com/calendar/render?action=TEMPLATE' }}"
                                            title="Add to Calendar"
                                            class="text-blue-600 hover:text-blue-800 text-xl"
                                        >
                                            📅
                                        </a>
                                    @endif

                                    @php
                                        $isPast = now()->greaterThan($reservation->date);
                                    @endphp

                                    {{-- Cancel (disable ONLY if date passed) --}}
                                @if(!$isPast)
                                    <form action="{{ route('reservations.cancel', $reservation->id) }}"
                                        method="POST"
                                        class="inline-flex items-center gap-2"
                                        onsubmit="return confirm('Cancel this appointment?')">
                                        @csrf

                                        @if(strtolower($reservation->status) === 'approved')
                                            <input
                                                type="text"
                                                name="cancel_reason"
                                                placeholder="Reason for cancellation required!"
                                                class="hidden border rounded px-2 py-1 text-sm mb-1 w-40"
                                            >
                                        @endif

                                        <button type="button"
                                                onclick="return confirm('Cancel this appointment?') ? this.closest('form').submit() : null;"
                                                title="Cancel booking"
                                                class="text-xl text-red-600 hover:scale-110 transition">
                                            ❌
                                        </button>
                                    </form>
                                @endif

                                </div>
                            </td>
                        </tr>

                        <!-- DETAILS ROW (HIDDEN) -->
                        <tr id="details-{{ $reservation->id }}" class="hidden bg-gray-50">
                            <td colspan="6" class="px-6 py-4 text-sm">
                                @if ($reservation->resource_details)
                                    <p>
                                        <strong>Specific Resource:</strong>
                                        {{ $reservation->resource_details }}
                                    </p>
                                @endif

                                @if ($reservation->usage_details)
                                    <p class="mt-2">
                                        <strong>Usage Details:</strong>
                                        {{ $reservation->usage_details }}
                                    </p>
                                @endif

                                @if (!$reservation->resource_details && !$reservation->usage_details)
                                    <p class="text-gray-500 italic">
                                        No additional details provided.
                                    </p>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                No bookings yet.
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        @endforelse
    </div>


<script>
function toggleCancelReason(button) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="cancel_reason"]');

    if (input) {
        input.classList.toggle('hidden');
        input.focus();
    } else {
        // No reason required → submit immediately
        if (confirm('Cancel this appointment?')) {
            form.submit();
        }
    }
}

function handleCancelSubmit(form) {
    const input = form.querySelector('input[name="cancel_reason"]');

    if (input && input.value.trim() === '') {
        alert('Please provide a reason for cancellation.');
        return false;
    }

    return confirm('Cancel this appointment?');
}
</script>


</x-app-layout>

<script>
function toggleDetails(id) {
    const row = document.getElementById('details-' + id);
    row.classList.toggle('hidden');
}
</script>

<script>
function filterBookings(value) {
    value = value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value)
            ? ''
            : 'none';
    });
}
</script>
