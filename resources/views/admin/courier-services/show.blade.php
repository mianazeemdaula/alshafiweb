@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <a href="{{ route('admin.courier-services.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Courier Services
                    </a>
                    <h1 class="text-2xl font-bold text-gray-800">{{ ucfirst($courier->courier) }} Service Details</h1>
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('admin.courier-services.edit', $courier->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <button onclick="testConnection({{ $courier->id }})"
                        class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plug mr-2"></i>Test Connection
                    </button>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $extra = json_decode($courier->extra, true) ?? [];
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Courier Service:</span>
                            <div>
                                @if ($courier->courier == 'trax')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-shipping-fast mr-1"></i>TRAX/Sonic
                                    </span>
                                @elseif($courier->courier == 'tcs')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-truck mr-1"></i>TCS
                                    </span>
                                @elseif($courier->courier == 'leopards')
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-box mr-1"></i>Leopards
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Status:</span>
                            <div>
                                @if ($courier->is_active)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Environment Mode:</span>
                            <div>
                                @php $mode = $extra['mode'] ?? 'production'; @endphp
                                @if ($mode == 'sandbox')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-flask mr-1"></i>Sandbox
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-globe mr-1"></i>Production
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Created:</span>
                            <span class="text-gray-800">{{ $courier->created_at->format('M d, Y H:i') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Last Updated:</span>
                            <span class="text-gray-800">{{ $courier->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Configuration Details -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Configuration Details</h3>

                    @if ($courier->courier == 'trax')
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">API Key:</span>
                                <span class="text-gray-800 font-mono text-sm">
                                    {{ $courier->api_key ? substr($courier->api_key, 0, 10) . '...' : 'Not configured' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Pickup Address ID:</span>
                                <span class="text-gray-800">{{ $extra['pickup_address_id'] ?? 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Store ID:</span>
                                <span class="text-gray-800">{{ $extra['store_id'] ?? 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Service Type ID:</span>
                                <span class="text-gray-800">{{ $extra['service_type_id'] ?? '1' }}</span>
                            </div>
                        </div>
                    @elseif($courier->courier == 'tcs')
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Username:</span>
                                <span class="text-gray-800">{{ $courier->username ?? 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Password:</span>
                                <span class="text-gray-800">{{ $courier->password ? '••••••••' : 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Cost Center:</span>
                                <span class="text-gray-800">{{ $extra['cost_center'] ?? 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Location ID:</span>
                                <span class="text-gray-800">{{ $extra['location_id'] ?? 'Not configured' }}</span>
                            </div>
                        </div>
                    @elseif($courier->courier == 'leopards')
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">API Key:</span>
                                <span class="text-gray-800 font-mono text-sm">
                                    {{ $courier->api_key ? substr($courier->api_key, 0, 10) . '...' : 'Not configured' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">API Password:</span>
                                <span
                                    class="text-gray-800">{{ $extra['api_password'] ? '••••••••' : 'Not configured' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Shipment Mode:</span>
                                <span class="text-gray-800">{{ $extra['shipment_mode'] ?? 'Normal' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Packet Type:</span>
                                <span class="text-gray-800">{{ $extra['packet_type'] ?? 'Normal Packet' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- API Endpoints -->
            <div class="mt-6 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">API Endpoints</h3>

                @php
                    $mode = $extra['mode'] ?? 'production';
                    $endpoints = [];

                    if ($courier->courier == 'trax') {
                        if ($mode == 'sandbox') {
                            $endpoints = [
                                'Book Shipment' => 'https://staging.sonic.pk/api/shipment/book',
                                'Track Shipment' => 'https://staging.sonic.pk/api/shipment/track',
                                'Cancel Shipment' => 'https://staging.sonic.pk/api/shipment/cancel',
                                'Get Cities' => 'https://staging.sonic.pk/api/cities',
                            ];
                        } else {
                            $endpoints = [
                                'Book Shipment' => 'https://sonic.pk/api/shipment/book',
                                'Track Shipment' => 'https://sonic.pk/api/shipment/track',
                                'Cancel Shipment' => 'https://sonic.pk/api/shipment/cancel',
                                'Get Cities' => 'https://sonic.pk/api/cities',
                            ];
                        }
                    } elseif ($courier->courier == 'tcs') {
                        if ($mode == 'sandbox') {
                            $endpoints = [
                                'Create Order' => 'https://apidev.tcscourier.com/production/v1/cod/create-order',
                                'Track Order' => 'https://apidev.tcscourier.com/production/track/v1/shipments/track',
                                'Cancel Order' => 'https://apidev.tcscourier.com/production/v1/cod/cancel-order',
                                'Get Cities' => 'https://apidev.tcscourier.com/production/cities',
                            ];
                        } else {
                            $endpoints = [
                                'Create Order' => 'https://api.tcscourier.com/production/v1/cod/create-order',
                                'Track Order' => 'https://api.tcscourier.com/production/track/v1/shipments/track',
                                'Cancel Order' => 'https://api.tcscourier.com/production/v1/cod/cancel-order',
                                'Get Cities' => 'https://api.tcscourier.com/production/cities',
                            ];
                        }
                    } elseif ($courier->courier == 'leopards') {
                        if ($mode == 'sandbox') {
                            $endpoints = [
                                'Book Shipment' => 'https://testapi.leopardscod.com/cn/api/packet/addOrder',
                                'Track Shipment' => 'https://testapi.leopardscod.com/cn/api/packet/tracking',
                                'Cancel Shipment' => 'https://testapi.leopardscod.com/cn/api/packet/cancel',
                                'Get Cities' => 'https://testapi.leopardscod.com/cn/api/packet/cities',
                            ];
                        } else {
                            $endpoints = [
                                'Book Shipment' => 'https://api.leopardscod.com/cn/api/packet/addOrder',
                                'Track Shipment' => 'https://api.leopardscod.com/cn/api/packet/tracking',
                                'Cancel Shipment' => 'https://api.leopardscod.com/cn/api/packet/cancel',
                                'Get Cities' => 'https://api.leopardscod.com/cn/api/packet/cities',
                            ];
                        }
                    }
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($endpoints as $name => $url)
                        <div class="bg-white rounded-lg p-4 border">
                            <div class="font-medium text-gray-800 mb-2">{{ $name }}</div>
                            <div class="text-sm text-gray-600 font-mono break-all">{{ $url }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-between items-center pt-6 border-t">
                <div class="flex space-x-3">
                    <form action="{{ route('admin.courier-services.toggle-status', $courier->id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="bg-{{ $courier->is_active ? 'orange' : 'green' }}-500 hover:bg-{{ $courier->is_active ? 'orange' : 'green' }}-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-{{ $courier->is_active ? 'pause' : 'play' }} mr-2"></i>
                            {{ $courier->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>

                <form action="{{ route('admin.courier-services.destroy', $courier->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this courier service? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Delete Service
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Test Connection Modal -->
    <div id="testModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Connection Test Result</h3>
                <div id="testResult"></div>
                <div class="mt-4 flex justify-end">
                    <button onclick="closeTestModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testConnection(courierId) {
            fetch(`/admin/courier-services/${courierId}/test-connection`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = document.getElementById('testResult');
                    if (data.success) {
                        resultDiv.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>${data.message}
                </div>
            `;
                    } else {
                        resultDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>${data.message}
                </div>
            `;
                    }
                    document.getElementById('testModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    const resultDiv = document.getElementById('testResult');
                    resultDiv.innerHTML = `
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>Connection test failed
            </div>
        `;
                    document.getElementById('testModal').classList.remove('hidden');
                });
        }

        function closeTestModal() {
            document.getElementById('testModal').classList.add('hidden');
        }
    </script>
@endsection
