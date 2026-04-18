<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 space-y-5 lg:space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-slate-700 dark:text-navy-100">
            @lang('locale.withdrawal_history')
        </h1>
        <a href="{{ route('wallet.withdraw') }}"
           class="btn bg-primary text-white text-xs px-4 py-1.5 hover:bg-primary-focus">
            @lang('locale.withdrawal_new_request')
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($withdrawals->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center text-slate-400 dark:text-navy-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-12 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-sm">@lang('locale.withdrawal_empty_history')</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-navy-700 text-xs font-medium uppercase text-slate-500 dark:text-navy-300">
                        <tr>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_date')</th>
                            <th class="px-4 py-3 text-right">@lang('locale.withdrawal_amount')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_method')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_phone')</th>
                            <th class="px-4 py-3 text-center">@lang('locale.status')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_note')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-navy-600">
                        @foreach ($withdrawals as $wr)
                            <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50 transition">
                                <td class="px-4 py-3 text-slate-600 dark:text-navy-200 whitespace-nowrap">
                                    {{ $wr->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-700 dark:text-navy-100">
                                    {{ xaf($wr->amount) }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-navy-200">
                                    {{ $wr->method }}
                                </td>
                                <td class="px-4 py-3 font-mono text-slate-600 dark:text-navy-200">
                                    {{ $wr->phone_number }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $wr->statusColor() }}">
                                        {{ $wr->statusLabel() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-400 dark:text-navy-400">
                                    {{ $wr->admin_note ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($withdrawals->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 dark:border-navy-600">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
</x-app-layout>
