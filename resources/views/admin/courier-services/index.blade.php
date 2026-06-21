@extends('layouts.web')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Courier Services Management</h1>
                <a href="{{ route('admin.courier-services.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Add New Courier
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Courier Services Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Courier</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Mode</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">API Key</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Last Updated</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($couriers as $courier)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if ($courier->courier == 'trax')
                                            <span
                                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-shipping-fast mr-1"></i>TRAX
                                            </span>
                                        @elseif($courier->courier == 'tcs')
                                            <span
                                                class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-truck mr-1"></i>TCS
                                            </span>
                                        @elseif($courier->courier == 'leopards')
                                            <span
                                                class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-box mr-1"></i>Leopards
                                            </span>
                                        @elseif($courier->courier == 'manual')
                                            <span
                                                class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-box mr-1"></i>Manual
                                            </span>
                                        @elseif($courier->courier == 'postex')
                                            <span
                                                class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-box mr-1"></i>PostEx
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($courier->is_active)
                                        <span
                                            class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-times-circle mr-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $extra = json_decode($courier->extra, true);
                                        $mode = $extra['mode'] ?? 'production';
                                    @endphp
                                    @if ($mode == 'sandbox')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-flask mr-1"></i>Sandbox
                                        </span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-globe mr-1"></i>Production
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($courier->api_key)
                                        <span class="text-gray-600">{{ substr($courier->api_key, 0, 10) }}...</span>
                                    @else
                                        <span class="text-gray-400">Not configured</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $courier->updated_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <!-- View -->
                                        <a href="{{ route('admin.courier-services.show', $courier->id) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.courier-services.edit', $courier->id) }}"
                                            class="text-green-600 hover:text-green-800 text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.courier-services.toggle-status', $courier->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="{{ $courier->is_active ? 'text-orange-600 hover:text-orange-800' : 'text-green-600 hover:text-green-800' }} text-sm">
                                                <i class="fas fa-{{ $courier->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Test Connection -->
                                        <button onclick="testConnection({{ $courier->id }})"
                                            class="text-purple-600 hover:text-purple-800 text-sm">
                                            <i class="fas fa-plug"></i>
                                        </button>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.courier-services.destroy', $courier->id) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this courier service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-shipping-fast text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg mb-2">No courier services configured</p>
                                    <p class="text-sm">Get started by adding your first courier service</p>
                                    <a href="{{ route('admin.courier-services.create') }}"
                                        class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                        Add Courier Service
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
