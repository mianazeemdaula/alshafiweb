@extends('layouts.user')
@section('main')
    <div class="p-4">
        <h2 class="text-2xl font-semibold mb-4">My Referrals</h2>
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
                    <button onclick="copyReferralLink()"
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
        <div class="overflow-x-auto">
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
    </div>

    @push('js')
        <script>
            function copyReferralLink() {
                const input = document.getElementById('ref-link');
                input.select();
                input.setSelectionRange(0, 99999); // For mobile
                document.execCommand('copy');
                const msg = document.getElementById('copy-success');
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 1200);
            }
        </script>
    @endpush
@endsection
