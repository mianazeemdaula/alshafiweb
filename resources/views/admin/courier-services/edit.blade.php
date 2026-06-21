@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex items-center mb-6">
                <a href="{{ route('admin.courier-services.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Courier Services
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Edit {{ ucfirst($courier->courier) }} Service</h1>
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

            <form action="{{ route('admin.courier-services.update', $courier->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Courier Display (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Courier Service</label>
                    <div class="flex items-center">
                        @if ($courier->courier == 'trax')
                            <span class="bg-blue-100 text-blue-800 px-3 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-shipping-fast mr-1"></i>TRAX/Sonic
                            </span>
                        @elseif($courier->courier == 'tcs')
                            <span class="bg-green-100 text-green-800 px-3 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-truck mr-1"></i>TCS
                            </span>
                        @elseif($courier->courier == 'leopards')
                            <span class="bg-orange-100 text-orange-800 px-3 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-box mr-1"></i>Leopards
                            </span>
                        @endif
                    </div>
                    <input type="hidden" name="courier" value="{{ $courier->courier }}">
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $courier->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                @php
                    $extra = json_decode($courier->extra, true) ?? [];
                @endphp

                <!-- Mode -->
                <div>
                    <label for="mode" class="block text-sm font-medium text-gray-700 mb-2">
                        Environment Mode <span class="text-red-500">*</span>
                    </label>
                    <select name="mode" id="mode"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="sandbox"
                            {{ old('mode', $extra['mode'] ?? 'production') == 'sandbox' ? 'selected' : '' }}>Sandbox
                            (Testing)</option>
                        <option value="production"
                            {{ old('mode', $extra['mode'] ?? 'production') == 'production' ? 'selected' : '' }}>Production
                            (Live)</option>
                    </select>
                </div>

                @if ($courier->courier == 'trax')
                    <!-- TRAX Fields -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800 border-b pb-2">TRAX/Sonic Configuration</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                    API Key <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="api_key" id="api_key"
                                    value="{{ old('api_key', $courier->api_key) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter TRAX API Key" required>
                            </div>

                            <div>
                                <label for="pickup_address_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pickup Address ID <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="pickup_address_id" id="pickup_address_id"
                                    value="{{ old('pickup_address_id', $extra['pickup_address_id'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter Pickup Address ID" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="store_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Store ID
                                </label>
                                <input type="text" name="store_id" id="store_id"
                                    value="{{ old('store_id', $extra['store_id'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter Store ID (optional)">
                            </div>

                            <div>
                                <label for="service_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Type ID
                                </label>
                                <input type="text" name="service_type_id" id="service_type_id"
                                    value="{{ old('service_type_id', $extra['service_type_id'] ?? '1') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Default: 1">
                            </div>
                        </div>
                    </div>
                @elseif($courier->courier == 'tcs')
                    <!-- TCS Fields -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800 border-b pb-2">TCS Configuration</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="token" class="block text-sm font-medium text-gray-700 mb-2">
                                    Token <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="token" id="token"
                                    value="{{ old('token', $courier->token) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter TCS Token" required>
                            </div>

                            <div>
                                <label for="token_expiry" class="block text-sm font-medium text-gray-700 mb-2">
                                    Token Expiry <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="token_expiry" id="token_expiry"
                                    value="{{ old('token_expiry', $courier->token_expiry) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter TCS Token Expiry" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="costcentercode" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cost Center Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="costcentercode" id="costcentercode"
                                    value="{{ old('costcentercode', $extra['costcentercode'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter Cost Center Code" required>
                            </div>

                            <div>
                                <label for="location_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Location ID <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="location_id" id="location_id"
                                    value="{{ old('location_id', $extra['location_id'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter Location ID" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="cost_center_endpoint" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cost Center Endpoint (optional)
                                </label>
                                <input type="text" name="cost_center_endpoint" id="cost_center_endpoint"
                                    value="{{ old('cost_center_endpoint', $extra['cost_center_endpoint'] ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Optional API endpoint to generate cost center code">
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="generate-costcenter"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                    Generate Cost Center
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif($courier->courier == 'leopards')
                    <!-- Leopards Fields -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800 border-b pb-2">Leopards Configuration</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                    API Key <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="api_key" id="api_key"
                                    value="{{ old('api_key', $courier->api_key) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter Leopards API Key" required>
                            </div>

                            <div>
                                <label for="api_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    API Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="api_password" id="api_password"
                                    value="{{ old('api_password', $courier->api_password) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter API Password" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="shipment_mode" class="block text-sm font-medium text-gray-700 mb-2">
                                    Shipment Mode
                                </label>
                                <select name="shipment_mode" id="shipment_mode"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Normal"
                                        {{ old('shipment_mode', $extra['shipment_mode'] ?? 'Normal') == 'Normal' ? 'selected' : '' }}>
                                        Normal</option>
                                    <option value="Overnight"
                                        {{ old('shipment_mode', $extra['shipment_mode'] ?? 'Normal') == 'Overnight' ? 'selected' : '' }}>
                                        Overnight</option>
                                    <option value="Express"
                                        {{ old('shipment_mode', $extra['shipment_mode'] ?? 'Normal') == 'Express' ? 'selected' : '' }}>
                                        Express</option>
                                </select>
                            </div>

                            <div>
                                <label for="packet_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Packet Type
                                </label>
                                <select name="packet_type" id="packet_type"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Normal Packet"
                                        {{ old('packet_type', $extra['packet_type'] ?? 'Normal Packet') == 'Normal Packet' ? 'selected' : '' }}>
                                        Normal Packet</option>
                                    <option value="Document"
                                        {{ old('packet_type', $extra['packet_type'] ?? 'Normal Packet') == 'Document' ? 'selected' : '' }}>
                                        Document</option>
                                    <option value="Fragile"
                                        {{ old('packet_type', $extra['packet_type'] ?? 'Normal Packet') == 'Fragile' ? 'selected' : '' }}>
                                        Fragile</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.courier-services.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update Courier Service
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('generate-costcenter');
            if (!btn) return;

            btn.addEventListener('click', async function() {
                btn.disabled = true;
                btn.textContent = 'Generating...';
                try {
                    const courierId = {{ $courier->id }};
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    const res = await fetch(
                        `{{ url('admin/courier-services') }}/${courierId}/generate-costcenter`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        });
                    const data = await res.json();
                    if (data.success && data.costcentercode) {
                        document.getElementById('costcentercode').value = data.costcentercode;
                        alert('Cost center generated: ' + data.costcentercode);
                    } else {
                        alert('Failed to generate cost center: ' + (data.message || 'Unknown'));
                    }
                } catch (err) {
                    alert('Error generating cost center: ' + err.message);
                } finally {
                    btn.disabled = false;
                    btn.textContent = 'Generate Cost Center';
                }
            });
        });
    </script>
@endsection
