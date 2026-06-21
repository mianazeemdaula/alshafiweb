@extends('layouts.user')
@section('main')
    <div class="p-4">
        <h2 class="text-2xl font-semibold mb-4">My Referrals</h2>

        {{-- Referral Code Card --}}
        <div class="mb-6 p-6 rounded-xl border shadow flex flex-col md:flex-row items-center gap-6"
            style="background: linear-gradient(90deg, var(--bg-primary) 60%, var(--bg-secondary) 100%); border-color: var(--border-color);">
            <div class="flex-1">
                <div class="font-bold text-lg mb-1" style="color: var(--accent-blue);">
                    <i class="fa-solid fa-gift mr-2"></i> Your Referral Code
                </div>
                <div class="text-2xl font-mono mb-2" style="color: var(--accent-blue-hover); letter-spacing: 2px;">
                    {{ auth()->user()->ref_code }}
                </div>
                <div class="text-sm mb-2" style="color: var(--text-secondary);">
                    Share this link to invite friends and earn rewards:
                </div>
                <div class="flex items-center gap-2">
                    <input id="ref-link" type="text" readonly
                        value="{{ url('/register?ref=' . auth()->user()->ref_code) }}"
                        class="font-mono text-xs rounded px-2 py-1 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 w-full max-w-xs focus:outline-none"
                        style="color: var(--accent-blue);">
                    <button onclick="copyToClipboard('ref-link', 'copy-success')"
                        class="px-3 py-1 rounded bg-[var(--accent-blue)] hover:bg-[var(--accent-blue-hover)] text-white text-xs font-semibold flex items-center gap-1 transition-colors"
                        type="button">
                        <i class="fa-regular fa-copy"></i> Copy
                    </button>
                </div>
                <div id="copy-success" class="text-xs mt-1 text-green-600 hidden">Copied!</div>
            </div>
            <div class="hidden md:block flex-shrink-0">
                <img src="https://cdn-icons-png.flaticon.com/512/1041/1041916.png" alt="Referral"
                    class="w-24 h-24 opacity-80">
            </div>
        </div>

        {{-- Referred Users Table --}}
        <h3 class="text-xl font-semibold mb-3 flex items-center gap-2" style="color: var(--text-primary);">
            <i class="fa-solid fa-users" style="color: var(--accent-blue);"></i> Referred Users
        </h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full rounded-lg shadow border"
                style="background: var(--bg-primary); border-color: var(--border-color);">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Name</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Email</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Total Shopping</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Your Earning</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referrals as $ref)
                        <tr>
                            <td class="px-4 py-2" style="color: var(--text-primary);">{{ $ref->name }}</td>
                            <td class="px-4 py-2" style="color: var(--text-secondary);">{{ $ref->email }}</td>
                            <td class="px-4 py-2" style="color: var(--accent-green);">RS. {{ $ref->total_shopping }}</td>
                            <td class="px-4 py-2 font-semibold" style="color: var(--accent-blue);">RS. {{ $ref->earning }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center" style="color: var(--text-muted);">No referrals
                                yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Product Referral Orders Section --}}
        <h3 class="text-xl font-semibold mb-3 flex items-center gap-2" style="color: var(--text-primary);">
            <i class="fa-solid fa-link" style="color: var(--accent-blue);"></i> Product Referral Orders
        </h3>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="p-4 rounded-xl border shadow" style="background: var(--bg-primary); border-color: var(--border-color);">
                <div class="text-sm mb-1" style="color: var(--text-secondary);">Orders via Your Links</div>
                <div class="text-2xl font-bold" style="color: var(--accent-blue);">{{ $referredOrdersCount }}</div>
            </div>
            <div class="p-4 rounded-xl border shadow" style="background: var(--bg-primary); border-color: var(--border-color);">
                <div class="text-sm mb-1" style="color: var(--text-secondary);">Total Revenue from Referrals</div>
                <div class="text-2xl font-bold" style="color: var(--accent-green);">RS. {{ number_format($referredOrdersTotal, 2) }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full rounded-lg shadow border"
                style="background: var(--bg-primary); border-color: var(--border-color);">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Order #</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Customer</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Product(s)</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Total</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Status</th>
                        <th class="px-4 py-2 text-left" style="color: var(--accent-blue);">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($referredOrders as $order)
                        <tr class="border-t" style="border-color: var(--border-color);">
                            <td class="px-4 py-2 font-mono text-sm" style="color: var(--text-primary);">
                                {{ $order->number }}
                            </td>
                            <td class="px-4 py-2" style="color: var(--text-secondary);">
                                {{ $order->user ? $order->user->name : ($order->customer_name ?? 'Guest') }}
                            </td>
                            <td class="px-4 py-2" style="color: var(--text-primary);">
                                @foreach ($order->orderDetails as $detail)
                                    <span class="inline-block text-xs px-2 py-0.5 rounded-full mb-1"
                                        style="background: var(--bg-secondary); color: var(--text-primary);">
                                        {{ $detail->product->name ?? 'N/A' }} &times;{{ $detail->qty }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 font-semibold" style="color: var(--accent-green);">
                                RS. {{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColors = [
                                        'open' => 'bg-yellow-100 text-yellow-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-indigo-100 text-indigo-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $colorClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm" style="color: var(--text-secondary);">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center" style="color: var(--text-muted);">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-share-nodes text-3xl opacity-40"></i>
                                    <p>No referral orders yet.</p>
                                    <p class="text-xs">Share product links with your referral code to earn rewards!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        <script>
            function copyToClipboard(inputId, successId) {
                const input = document.getElementById(inputId);
                input.select();
                input.setSelectionRange(0, 99999); // For mobile
                document.execCommand('copy');
                const msg = document.getElementById(successId);
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 1200);
            }
        </script>
    @endpush
@endsection
