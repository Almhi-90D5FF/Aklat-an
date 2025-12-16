<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Library services available for booking
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Code</th>
                            <th class="border px-4 py-2">Section Name</th>
                            <th class="border px-4 py-2">Email Address</th>
                            <th class="border px-4 py-2">Telephone #</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Resources</th>
                            <th class="border px-4 py-2 w-32 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($sections)
                            @foreach ($sections as $section)
                
                        <tr>
                            <td class="border px-4 py-2">{{ $section->code }}</td>
                            <td class="border px-4 py-2">{{ $section->name }}</td>
                            <td class="border px-4 py-2">{{ $section->email }}</td>
                            <td class="border px-4 py-2">{{ $section->telephone }}</td>
                            <td class="border px-4 py-2">{{ $section->description }}</td>
                            <td class="border px-4 py-2">{{ $section->resources }}</td>
                            <td class="border px-4 py-2 text-center whitespace-nowrap">
                                <a href="{{ route('reservations.create', $section) }}"
                                class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-semibold">
                                    Book Now
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
