@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.courier-services.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Courier Services
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Add New Courier Service</h1>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.courier-services.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Courier Selection -->
                <div>
                    <label for="courier" class="block text-sm font-medium text-gray-700 mb-2">
                        Courier Service <span class="text-red-500">*</span>
                    </label>
                    <select name="courier" id="courier"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="showCourierFields()" required>
                        <option value="">Select Courier Service</option>
                        <option value="trax" {{ old('courier') == 'trax' ? 'selected' : '' }}>TRAX/Sonic</option>
                        <option value="tcs" {{ old('courier') == 'tcs' ? 'selected' : '' }}>TCS</option>
                        <option value="leopards" {{ old('courier') == 'leopards' ? 'selected' : '' }}>Leopards</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <!-- Mode -->
                <div>
                    <label for="mode" class="block text-sm font-medium text-gray-700 mb-2">
                        Environment Mode <span class="text-red-500">*</span>
                    </label>
                    <select name="mode" id="mode"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="sandbox" {{ old('mode') == 'sandbox' ? 'selected' : '' }}>Sandbox (Testing)</option>
                        <option value="production" {{ old('mode', 'production') == 'production' ? 'selected' : '' }}>
                            Production (Live)</option>
                    </select>
                </div>

                <!-- TRAX Fields -->
                <div id="trax-fields" class="hidden space-y-4">
                    <h3 class="text-lg font-medium text-gray-800 border-b pb-2">TRAX/Sonic Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="trax_api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                API Key <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="api_key" id="trax_api_key" value="{{ old('api_key') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter TRAX API Key">
                        </div>

                        <div>
                            <label for="trax_pickup_address_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Pickup Address ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pickup_address_id" id="trax_pickup_address_id"
                                value="{{ old('pickup_address_id') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Pickup Address ID">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="trax_store_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Store ID
                            </label>
                            <input type="text" name="store_id" id="trax_store_id" value="{{ old('store_id') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Store ID (optional)">
                        </div>

                        <div>
                            <label for="trax_service_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Service Type ID
                            </label>
                            <input type="text" name="service_type_id" id="trax_service_type_id"
                                value="{{ old('service_type_id', '1') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Default: 1">
                        </div>
                    </div>
                </div>

                <!-- TCS Fields -->
                <div id="tcs-fields" class="hidden space-y-4">
                    <h3 class="text-lg font-medium text-gray-800 border-b pb-2">TCS Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tcs_username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="username" id="tcs_username" value="{{ old('username') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter TCS Username">
                        </div>

                        <div>
                            <label for="tcs_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="tcs_password" value="{{ old('password') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter TCS Password">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tcs_cost_center" class="block text-sm font-medium text-gray-700 mb-2">
                                Cost Center <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="cost_center" id="tcs_cost_center"
                                value="{{ old('cost_center') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Cost Center">
                        </div>

                        <div>
                            <label for="tcs_location_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Location ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location_id" id="tcs_location_id"
                                value="{{ old('location_id') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Location ID">
                        </div>
                    </div>
                </div>

                <!-- Leopards Fields -->
                <div id="leopards-fields" class="hidden space-y-4">
                    <h3 class="text-lg font-medium text-gray-800 border-b pb-2">Leopards Configuration</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="leopards_api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                API Key <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="api_key" id="leopards_api_key" value="{{ old('api_key') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Leopards API Key">
                        </div>

                        <div>
                            <label for="leopards_api_password" class="block text-sm font-medium text-gray-700 mb-2">
                                API Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="api_password" id="leopards_api_password"
                                value="{{ old('api_password') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter API Password">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="leopards_shipment_mode" class="block text-sm font-medium text-gray-700 mb-2">
                                Shipment Mode
                            </label>
                            <select name="shipment_mode" id="leopards_shipment_mode"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Normal" {{ old('shipment_mode', 'Normal') == 'Normal' ? 'selected' : '' }}>
                                    Normal</option>
                                <option value="Overnight" {{ old('shipment_mode') == 'Overnight' ? 'selected' : '' }}>
                                    Overnight</option>
                                <option value="Express" {{ old('shipment_mode') == 'Express' ? 'selected' : '' }}>Express
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="leopards_packet_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Packet Type
                            </label>
                            <select name="packet_type" id="leopards_packet_type"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Normal Packet"
                                    {{ old('packet_type', 'Normal Packet') == 'Normal Packet' ? 'selected' : '' }}>Normal
                                    Packet</option>
                                <option value="Document" {{ old('packet_type') == 'Document' ? 'selected' : '' }}>Document
                                </option>
                                <option value="Fragile" {{ old('packet_type') == 'Fragile' ? 'selected' : '' }}>Fragile
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.courier-services.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Save Courier Service
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showCourierFields() {
            const courier = document.getElementById('courier').value;

            // Hide all fields
            document.getElementById('trax-fields').classList.add('hidden');
            document.getElementById('tcs-fields').classList.add('hidden');
            document.getElementById('leopards-fields').classList.add('hidden');

            // Show relevant fields
            if (courier) {
                document.getElementById(courier + '-fields').classList.remove('hidden');
            }

            // Clear other courier fields
            if (courier !== 'trax') {
                document.getElementById('trax_api_key').value = '';
                document.getElementById('trax_pickup_address_id').value = '';
                document.getElementById('trax_store_id').value = '';
                document.getElementById('trax_service_type_id').value = '1';
            }

            if (courier !== 'tcs') {
                document.getElementById('tcs_username').value = '';
                document.getElementById('tcs_password').value = '';
                document.getElementById('tcs_cost_center').value = '';
                document.getElementById('tcs_location_id').value = '';
            }

            if (courier !== 'leopards') {
                document.getElementById('leopards_api_key').value = '';
                document.getElementById('leopards_api_password').value = '';
                document.getElementById('leopards_shipment_mode').value = 'Normal';
                document.getElementById('leopards_packet_type').value = 'Normal Packet';
            }
        }

        // Show fields on page load if courier is already selected
        document.addEventListener('DOMContentLoaded', function() {
            showCourierFields();
        });
    </script>
@endsection
