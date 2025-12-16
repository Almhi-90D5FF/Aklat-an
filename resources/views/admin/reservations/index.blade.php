<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Admin – Reservations</h1>

        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">User</th>
                    <th class="border p-2">Section</th>
                    <th class="border p-2">Date</th>
                    <th class="border p-2">Time</th>
                    <th class="border p-2">Purpose</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td class="border p-2">{{ $reservation->user->name }}</td>
                    <td class="border p-2">{{ $reservation->section->name }}</td>
                    <td class="border p-2">{{ $reservation->date }}</td>
                    <td class="border p-2">{{ $reservation->time_slot }}</td>
                    <td class="border p-2">{{ $reservation->purpose }}</td>
                    <td class="border p-2 font-bold">{{ ucfirst($reservation->status) }}</td>
                    <td class="border p-2">
                        <form method="POST"
                              action="{{ route('admin.reservations.update-status', $reservation) }}"
                              class="flex gap-2">
                            @csrf
                            @method('PATCH')

                            <button name="status" value="approved"
                                class="px-2 py-1 bg-green-600 text-white rounded">
                                ✓
                            </button>

                            <button name="status" value="disapproved"
                                class="px-2 py-1 bg-red-600 text-white rounded">
                                ✕
                            </button>

                            <button name="status" value="no_show"
                                class="px-2 py-1 bg-gray-600 text-white rounded">
                                NS
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
