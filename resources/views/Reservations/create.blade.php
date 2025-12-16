<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- LEFT: Section Info -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Section Information</h2>

                <p><strong>Code:</strong> {{ $section->code }}</p>
                <p><strong>Name:</strong> {{ $section->name }}</p>
                <p><strong>Email:</strong> {{ $section->email }}</p>
                <p><strong>Telephone:</strong> {{ $section->telephone }}</p>

                <p class="mt-3">
                    <strong>Description:</strong><br>
                    {{ $section->description }}
                </p>

                <p class="mt-3">
                    <strong>Resources:</strong><br>
                    {{ $section->resources }}
                </p>
            </div>

            <!-- RIGHT: Booking Form -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Book Your Appointment</h2>

                <form method="POST" action="{{ route('reservations.store', $section) }}">
                    <input type="hidden" name="time_slot" id="time_slot">
                    @csrf

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Date</label>
                        <input type="date" name="date"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <!-- Time Slots -->
                    <div style="display:flex; gap:10px; margin-top:10px;">
                        <button type="button" class="time-slot-btn" onclick="selectTime(this, '8am-11am')">
                            8am–11am
                        </button>

                        <button type="button" class="time-slot-btn" onclick="selectTime(this, '11am-2pm')">
                            11am–2pm
                        </button>

                        <button type="button" class="time-slot-btn" onclick="selectTime(this, '2pm-5pm')">
                            2pm–5pm
                        </button>
                    </div>

                    <p id="selectedTimeText" style="margin-top:8px; font-weight:bold;"></p>


                    <!-- Purpose -->
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Purpose</label>
                        <select name="purpose"
                                id="purpose"
                                onchange="togglePurposeFields()" 
                                class="w-full border rounded px-3 py-2" required>
                            <option value="" disabled selected hidden>
                                -- Select Purpose -- 
                            </option>

                            <option value="Document Pickup">Document Pickup</option>
                            <option value="Laptop Lending">Laptop Lending</option>
                            <option value="Use of Space">Use of Space</option>
                            <option value="Research and Use of Databases">
                                Research and Use of Databases
                            </option>
                            <option value="Reading / Browsing / Studying">
                                Reading / Browsing / Studying
                            </option>
                        </select>
                    </div>

                    <div id="resourceField" style="display:none;" class="mb-4">
                        <label class="block font-semibold mb-1">
                            Specific Resource Needed
                        </label>

                        <textarea name="resource_details"
                                rows="3"
                                class="w-full border rounded px-3 py-2"
                                placeholder="Specify the document, database, or resource you need. You can refer to https://tuklas.up.edu.ph/ for available resources."></textarea>
                    </div>

                    <div id="usageField" style="display:none;" class="mb-4">
                        <label class="block font-semibold mb-1">
                            Usage Details
                        </label>

                        <textarea name="usage_details"
                                rows="3"
                                class="w-full border rounded px-3 py-2"
                                placeholder="Specify how many of you will be using the room/space and for what activity."></textarea>
                    </div>



                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">
                            Book Appointment
                        </button>
                        <a href="{{ route('dashboard') }}"
                           class="bg-gray-400 text-white px-4 py-2 rounded">
                            Cancel
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </form>
            </div>

        </div>
    </div>
</x-app-layout>


<script>
function togglePurposeFields() {
    const purpose = document.getElementById('purpose').value;
    const resourceField = document.getElementById('resourceField');
    const usageField = document.getElementById('usageField');

    // Hide everything first
    resourceField.style.display = 'none';
    usageField.style.display = 'none';

    // Show resource field for these purposes
    if (
        purpose === 'Document Pickup' ||
        purpose === 'Research and Use of Databases' ||
        purpose === 'Reading / Browsing / Studying'
    ) {
        resourceField.style.display = 'block';
    }

    // Show usage details ONLY for use of space
    if (purpose === 'Use of Space') {
        usageField.style.display = 'block';
    }
}

function selectTime(button, slot) {
    // save value
    document.getElementById('time_slot').value = slot;

    // remove active class from all time slots
    document.querySelectorAll('.time-slot-btn')
        .forEach(btn => btn.classList.remove('active'));

    // add active class to clicked one
    button.classList.add('active');

    console.log('Selected time slot:', slot);
}

</script>


<style>
.time-slot-btn {
    border: 1px solid #2563eb;
    background: white;
    color: #2563eb;
    padding: 6px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.time-slot-btn:hover {
    background: #2563eb;
    color: white;
}

.time-slot-btn.active {
    background: #2563eb;
    color: white;
}
</style>
