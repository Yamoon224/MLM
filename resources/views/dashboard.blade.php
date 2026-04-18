<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 space-y-5 lg:space-y-6">

    {{-- ══════════════════════════════════════════════════
         LIGNE 1 : Solde + Stats réseau
    ══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

        {{-- CARTE SOLDE & BONUS --}}
        <div class="col-span-12 lg:col-span-5">
            <div class="card h-full bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 p-5 text-white">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-purple-200">@lang('locale.your_balance')</p>
                        <p class="mt-1 text-3xl font-bold">
                            {{ xaf(auth()->user()->wallet->balance ?? 0) }}
                        </p>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>

                {{-- Code parrainage --}}
                <div class="mt-4 flex items-center gap-2 rounded-lg bg-white/10 px-3 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0 text-purple-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    <span class="flex-1 font-mono text-xs text-purple-100">{{ auth()->user()->referral_code }}</span>
                    <button onclick="navigator.clipboard.writeText('{{ auth()->user()->referral_code }}')"
                            class="rounded bg-white/20 px-2 py-0.5 text-xs font-medium hover:bg-white/30 transition">
                        @lang('locale.copy')
                    </button>
                </div>

                {{-- Bonus --}}
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-white/10 p-3">
                        <p class="text-xs text-purple-200">@lang('locale.referral_bonus')</p>
                        <p class="mt-1 text-lg font-semibold">{{ xaf($referral_bonus) }}</p>
                        <p class="mt-1 text-xs text-green-300">5 000 FCFA / filleul</p>
                    </div>
                    <div class="rounded-xl bg-white/10 p-3">
                        <p class="text-xs text-purple-200">@lang('locale.level_bonus')</p>
                        <p class="mt-1 text-lg font-semibold">{{ xaf($level_bonus) }}</p>
                        <p class="mt-1 text-xs text-yellow-300">@lang('locale.unlocked_levels')</p>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between border-t border-white/20 pt-3">
                    <span class="text-xs text-purple-200">@lang('locale.total_earned')</span>
                    <span class="text-sm font-bold">{{ xaf($total_bonus) }}</span>
                </div>
            </div>
        </div>

        {{-- STATS RÉSEAU PAR NIVEAU --}}
        <div class="col-span-12 lg:col-span-7">
            <div class="card h-full p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-navy-100">@lang('locale.network_stats')</h2>
                    <a href="{{ route('matrix.tree') }}"
                       class="text-xs text-primary hover:underline dark:text-accent-light">
                        @lang('locale.view_tree') →
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="rounded-lg bg-primary/5 dark:bg-navy-600 p-3 text-center">
                        <p class="text-2xl font-bold text-primary dark:text-accent-light">{{ $total_members }}</p>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-navy-300">@lang('locale.total_members')</p>
                    </div>
                    <div class="rounded-lg bg-success/5 dark:bg-navy-600 p-3 text-center">
                        <p class="text-2xl font-bold text-success">{{ $direct_members }}</p>
                        <p class="mt-0.5 text-xs text-slate-500 dark:text-navy-300">@lang('locale.direct_referrals')</p>
                    </div>
                </div>

                @php
                    $levelColors  = ['bg-violet-500','bg-indigo-500','bg-blue-500','bg-cyan-500','bg-teal-500'];
                    $levelAmounts = [1=>10000, 2=>25000, 3=>50000, 4=>100000, 5=>250000];
                @endphp
                <div class="space-y-3">
                    @foreach($network_stats as $lvl => $stat)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="flex size-5 items-center justify-center rounded-full {{ $levelColors[$lvl-1] }} text-white font-bold" style="font-size:10px">{{ $lvl }}</span>
                                <span class="text-slate-600 dark:text-navy-200">@lang('locale.level') {{ $lvl }}</span>
                                <span class="text-slate-400 dark:text-navy-400">— {{ xaf($levelAmounts[$lvl]) }}</span>
                            </div>
                            <span class="font-medium text-slate-700 dark:text-navy-100">{{ $stat['count'] }}/{{ $stat['max'] }}</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-slate-100 dark:bg-navy-600">
                            <div class="h-2 rounded-full {{ $levelColors[$lvl-1] }} transition-all duration-500"
                                 style="width: {{ $stat['percent'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════
         LIGNE 2 : Transactions récentes + Tableau membres
    ══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

        {{-- DERNIÈRES TRANSACTIONS --}}
        <div class="col-span-12 lg:col-span-4">
            <div class="card h-full p-5">
                <h2 class="mb-4 text-sm font-semibold text-slate-700 dark:text-navy-100">@lang('locale.recent_transactions')</h2>
                <div class="space-y-3">
                    @forelse($recent_transactions as $tx)
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 shrink-0 items-center justify-center rounded-full
                            {{ $tx->type === 'REFERRAL_BONUS'
                                ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400'
                                : 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                            @if($tx->type === 'REFERRAL_BONUS')
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium text-slate-700 dark:text-navy-100">
                                {{ $tx->type === 'REFERRAL_BONUS' ? __('locale.referral_bonus') : __('locale.level_bonus') }}
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-400">{{ $tx->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-sm font-semibold text-success">+{{ xaf($tx->amount) }}</span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-8 text-slate-400 dark:text-navy-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 size-10 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-xs">@lang('locale.no_transactions')</p>
                    </div>
                    @endforelse
                </div>

                @if($level_bonuses_earned->count())
                <div class="mt-4 border-t border-slate-100 pt-4 dark:border-navy-600">
                    <p class="mb-2 text-xs font-medium text-slate-500 dark:text-navy-400">@lang('locale.unlocked_levels')</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($level_bonuses_earned->unique('reference') as $lb)
                        @php preg_match('/(\d+)/', $lb->reference ?? '', $m); $lvl = $m[1] ?? '?'; @endphp
                        <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-semibold text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                            Niv.{{ $lvl }} ✓
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- TABLE MEMBRES --}}
        <div class="col-span-12 lg:col-span-8">
            <div class="card">
                <div class="flex items-center justify-between px-4 pb-2 pt-4 sm:px-5">
                    <h2 class="text-sm font-semibold text-slate-700 dark:text-navy-100">
                        @lang('locale.member', ['suffix' => 's'])
                        <span class="ml-1 rounded-full bg-primary/10 px-2 py-0.5 text-xs font-medium text-primary dark:bg-navy-600 dark:text-accent-light">
                            {{ $descendants->total() }}
                        </span>
                    </h2>
                    <a href="{{ route('matrix.tree') }}"
                       class="btn rounded border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-700
                              hover:bg-slate-50 dark:border-navy-450 dark:bg-navy-700 dark:text-navy-100 dark:hover:bg-navy-600">
                        @lang('locale.view_tree')
                    </a>
                </div>

                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="is-hoverable w-full text-left text-sm">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap bg-slate-100 px-4 py-2.5 text-xs font-semibold uppercase text-slate-500 dark:bg-navy-800 dark:text-navy-300">#</th>
                                <th class="whitespace-nowrap bg-slate-100 px-4 py-2.5 text-xs font-semibold uppercase text-slate-500 dark:bg-navy-800 dark:text-navy-300">@lang('locale.full_name')</th>
                                <th class="whitespace-nowrap bg-slate-100 px-4 py-2.5 text-xs font-semibold uppercase text-slate-500 dark:bg-navy-800 dark:text-navy-300">@lang('locale.referral_code')</th>
                                <th class="whitespace-nowrap bg-slate-100 px-4 py-2.5 text-xs font-semibold uppercase text-slate-500 dark:bg-navy-800 dark:text-navy-300">@lang('locale.level')</th>
                                <th class="whitespace-nowrap bg-slate-100 px-4 py-2.5 text-xs font-semibold uppercase text-slate-500 dark:bg-navy-800 dark:text-navy-300">@lang('locale.created_at')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($descendants as $i => $descendant)
                            <tr class="border-b border-slate-100 transition-colors hover:bg-slate-50 dark:border-navy-600 dark:hover:bg-navy-700/50">
                                <td class="px-4 py-2.5 text-xs text-slate-400 dark:text-navy-400">
                                    {{ $descendants->firstItem() + $i }}
                                </td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-semibold text-primary dark:bg-navy-600 dark:text-accent-light">
                                            {{ strtoupper(substr($descendant->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-slate-700 dark:text-navy-100">{{ $descendant->full_name }}</p>
                                            <p class="text-xs text-slate-400 dark:text-navy-400">{{ $descendant->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    <span class="font-mono text-xs text-primary dark:text-accent-light">{{ $descendant->referral_code }}</span>
                                </td>
                                <td class="px-4 py-2.5">
                                    @php
                                        $depth = $descendant->pivot->depth;
                                        $depthClasses = [
                                            1 => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
                                            2 => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
                                            3 => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            4 => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                            5 => 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $depthClasses[$depth] ?? 'bg-slate-100 text-slate-600' }}">
                                        N{{ $depth }}
                                    </span>
                                </td>
                                <td class="px-4 py-2.5 text-xs text-slate-500 dark:text-navy-300">
                                    {{ $descendant->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2 text-slate-400 dark:text-navy-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-12 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p class="text-sm">@lang('locale.no_members_yet')</p>
                                        <p class="text-xs">@lang('locale.share_referral_hint')</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col justify-between gap-3 px-4 py-3 sm:flex-row sm:items-center">
                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-navy-400">
                        <span>@lang('locale.show')</span>
                        <form method="GET" id="perPageForm">
                            <select name="per_page"
                                    onchange="document.getElementById('perPageForm').submit()"
                                    class="form-select rounded border border-slate-300 bg-white px-2 py-1 pr-6 text-xs
                                           hover:border-slate-400 focus:border-primary
                                           dark:border-navy-450 dark:bg-navy-700
                                           dark:hover:border-navy-400 dark:focus:border-accent">
                                @foreach([10,30,50] as $size)
                                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                        </form>
                        <span>@lang('locale.entries')</span>
                    </div>

                    <ol class="pagination flex -space-x-px text-xs">
                        @if($descendants->onFirstPage())
                            <li class="rounded-l bg-slate-100 opacity-50 dark:bg-navy-600"><span class="flex size-7 items-center justify-center">‹</span></li>
                        @else
                            <li class="rounded-l bg-slate-100 dark:bg-navy-600">
                                <a href="{{ $descendants->previousPageUrl() }}" class="flex size-7 items-center justify-center hover:bg-slate-200 dark:hover:bg-navy-500">‹</a>
                            </li>
                        @endif

                        @foreach($descendants->links()->elements[0] ?? [] as $page => $url)
                            <li class="bg-slate-100 dark:bg-navy-600">
                                <a href="{{ $url }}" class="flex h-7 min-w-[1.75rem] items-center justify-center px-2
                                    {{ $page == $descendants->currentPage() ? 'bg-primary text-white dark:bg-accent' : 'hover:bg-slate-200 dark:hover:bg-navy-500' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        @if($descendants->hasMorePages())
                            <li class="rounded-r bg-slate-100 dark:bg-navy-600">
                                <a href="{{ $descendants->nextPageUrl() }}" class="flex size-7 items-center justify-center hover:bg-slate-200 dark:hover:bg-navy-500">›</a>
                            </li>
                        @else
                            <li class="rounded-r bg-slate-100 opacity-50 dark:bg-navy-600"><span class="flex size-7 items-center justify-center">›</span></li>
                        @endif
                    </ol>

                    <p class="text-xs text-slate-500 dark:text-navy-400">
                        {{ $descendants->firstItem() ?? 0 }}–{{ $descendants->lastItem() ?? 0 }} / {{ $descendants->total() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
</x-app-layout>
