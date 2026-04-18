<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 space-y-5 lg:space-y-6">

    {{-- Titre --}}
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-slate-700 dark:text-navy-100">
            @lang('locale.admin_withdrawals')
        </h1>
        @if ($counts['PENDING'] > 0)
            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                {{ $counts['PENDING'] }} @lang('locale.withdrawal_pending_badge')
            </span>
        @endif
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="rounded-xl border border-success/30 bg-success/10 px-4 py-3 text-sm font-medium text-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->has('approve') || $errors->has('reject'))
        <div class="rounded-xl border border-error/30 bg-error/10 px-4 py-3 text-sm font-medium text-error">
            {{ $errors->first('approve') ?: $errors->first('reject') }}
        </div>
    @endif

    {{-- Onglets de filtre --}}
    <div class="flex gap-2 border-b border-slate-200 dark:border-navy-600 pb-0">
        @foreach (['PENDING' => 'amber', 'APPROVED' => 'success', 'REJECTED' => 'error', 'ALL' => 'slate'] as $tab => $color)
            <a href="{{ route('admin.withdrawals.index', ['status' => $tab]) }}"
               class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium border-b-2 transition
                      {{ $status === $tab
                          ? 'border-primary text-primary dark:border-accent dark:text-accent-light'
                          : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-navy-300 dark:hover:text-navy-100' }}">
                {{ __('locale.withdrawal_' . strtolower($tab)) }}
                @if (isset($counts[$tab]))
                    <span class="rounded-full bg-slate-100 dark:bg-navy-600 px-1.5 py-0.5 text-xs">{{ $counts[$tab] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Table des demandes --}}
    <div class="card overflow-hidden">
        @if ($withdrawals->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-400 dark:text-navy-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-12 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm">@lang('locale.withdrawal_empty_list')</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-navy-700 text-xs font-medium uppercase text-slate-500 dark:text-navy-300">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">@lang('locale.user')</th>
                            <th class="px-4 py-3 text-right">@lang('locale.withdrawal_amount')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_method')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_phone')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.withdrawal_date')</th>
                            <th class="px-4 py-3 text-center">@lang('locale.status')</th>
                            <th class="px-4 py-3 text-center">@lang('locale.actions')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-navy-600">
                        @foreach ($withdrawals as $wr)
                            <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50 transition" id="wr-{{ $wr->id }}">
                                <td class="px-4 py-3 text-slate-400 dark:text-navy-400 text-xs">#{{ $wr->id }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">{{ $wr->user->full_name ?? '—' }}</p>
                                    <p class="text-xs text-slate-400 dark:text-navy-400">{{ $wr->user->email ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-700 dark:text-navy-100 whitespace-nowrap">
                                    {{ xaf($wr->amount) }}
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-navy-200">{{ $wr->method }}</td>
                                <td class="px-4 py-3 font-mono text-slate-600 dark:text-navy-200">{{ $wr->phone_number }}</td>
                                <td class="px-4 py-3 text-slate-500 dark:text-navy-300 whitespace-nowrap text-xs">
                                    {{ $wr->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $wr->statusColor() }}">
                                        {{ $wr->statusLabel() }}
                                    </span>
                                    @if ($wr->admin_note)
                                        <p class="mt-0.5 text-xs text-slate-400 dark:text-navy-400 italic">{{ $wr->admin_note }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($wr->isPending())
                                        <div class="flex flex-col items-center gap-2">
                                            {{-- Approuver --}}
                                            <form method="POST" action="{{ route('admin.withdrawals.approve', $wr) }}"
                                                  onsubmit="return confirm('@lang('locale.withdrawal_confirm_approve')')">
                                                @csrf
                                                <button type="submit"
                                                        class="btn bg-success/10 text-success hover:bg-success hover:text-white text-xs px-3 py-1 transition w-full">
                                                    ✓ @lang('locale.withdrawal_approve')
                                                </button>
                                            </form>

                                            {{-- Rejeter --}}
                                            <button data-reject-toggle="{{ $wr->id }}"
                                                    class="btn bg-error/10 text-error hover:bg-error hover:text-white text-xs px-3 py-1 transition w-full">
                                                ✕ @lang('locale.withdrawal_reject')
                                            </button>

                                            {{-- Formulaire de rejet (caché par défaut) --}}
                                            <div id="reject-form-{{ $wr->id }}" class="hidden w-full mt-1">
                                                <form method="POST" action="{{ route('admin.withdrawals.reject', $wr) }}" class="flex flex-col gap-1">
                                                    @csrf
                                                    <input type="text" name="admin_note"
                                                           placeholder="@lang('locale.withdrawal_reject_note')"
                                                           class="form-input w-full rounded border border-slate-200 dark:border-navy-500 dark:bg-navy-700 dark:text-navy-100 text-xs py-1">
                                                    <button type="submit" class="btn bg-error text-white text-xs px-3 py-1 w-full">
                                                        @lang('locale.confirm')
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-navy-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($withdrawals->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 dark:border-navy-600">
                    {{ $withdrawals->links() }}
                </div>
            @endif
        @endif
    </div>

</div>

{{-- Script pour toggle formulaire de rejet --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-reject-toggle]').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.rejectToggle;
            const form = document.getElementById('reject-form-' + id);
            if (form) form.classList.toggle('hidden');
        });
    });
});
</script>
</x-app-layout>
