<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 space-y-5 lg:space-y-6 max-w-2xl mx-auto">

    {{-- Titre de page --}}
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-slate-700 dark:text-navy-100">
            @lang('locale.withdrawal_title')
        </h1>
        <a href="{{ route('wallet.history') }}"
           class="text-xs text-primary hover:underline dark:text-accent-light">
            @lang('locale.withdrawal_history') →
        </a>
    </div>

    {{-- Flash success --}}
    @if (session('success'))
        <div class="rounded-xl border border-success/30 bg-success/10 px-4 py-3 text-sm font-medium text-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Carte solde --}}
    <div class="card bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 p-5 text-white">
        <p class="text-xs font-medium uppercase tracking-wider text-purple-200">@lang('locale.your_balance')</p>
        <p class="mt-1 text-3xl font-bold">{{ xaf($wallet->balance ?? 0) }}</p>
        <p class="mt-1 text-xs text-purple-300">
            @lang('locale.withdrawal_min_amount', ['min' => xaf(\App\Services\WithdrawalService::MIN_AMOUNT)])
        </p>
    </div>

    {{-- Demande en cours --}}
    @if ($pending)
        <div class="card p-5 border-l-4 border-amber-400 bg-amber-50 dark:bg-amber-900/20">
            <div class="flex items-start gap-3">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-800/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-amber-600 dark:text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800 dark:text-amber-300">@lang('locale.withdrawal_pending_title')</p>
                    <p class="mt-1 text-sm text-amber-700 dark:text-amber-400">
                        {{ xaf($pending->amount) }} — {{ $pending->method }} ({{ $pending->phone_number }})
                    </p>
                    <p class="mt-0.5 text-xs text-amber-600 dark:text-amber-500">
                        {{ $pending->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- Formulaire de retrait --}}
        <div class="card p-6">
            <h2 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-4">
                @lang('locale.withdrawal_new_request')
            </h2>

            <form method="POST" action="{{ route('wallet.withdraw.store') }}" class="space-y-4">
                @csrf

                {{-- Montant --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-navy-200 mb-1">
                        @lang('locale.withdrawal_amount')
                    </label>
                    <div class="relative">
                        <input type="number"
                               name="amount"
                               value="{{ old('amount') }}"
                               min="{{ \App\Services\WithdrawalService::MIN_AMOUNT }}"
                               max="{{ $wallet->balance ?? 0 }}"
                               step="1"
                               placeholder="{{ \App\Services\WithdrawalService::MIN_AMOUNT }}"
                               class="form-input w-full rounded-lg border border-slate-200 dark:border-navy-500 pr-16
                                      focus:border-primary dark:bg-navy-700 dark:text-navy-100 @error('amount') border-error @enderror">
                        <span class="absolute inset-y-0 right-3 flex items-center text-sm text-slate-400">FCFA</span>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mode de paiement --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-navy-200 mb-1">
                        @lang('locale.withdrawal_method')
                    </label>
                    <select name="method"
                            class="form-select w-full rounded-lg border border-slate-200 dark:border-navy-500
                                   dark:bg-navy-700 dark:text-navy-100 @error('method') border-error @enderror">
                        <option value="">— @lang('locale.withdrawal_select_method') —</option>
                        @foreach (\App\Services\WithdrawalService::METHODS as $m)
                            <option value="{{ $m }}" {{ old('method') === $m ? 'selected' : '' }}>{{ $m }} Money</option>
                        @endforeach
                    </select>
                    @error('method')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Numéro de téléphone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-navy-200 mb-1">
                        @lang('locale.withdrawal_phone')
                    </label>
                    <input type="text"
                           name="phone_number"
                           value="{{ old('phone_number') }}"
                           placeholder="6XXXXXXXX"
                           maxlength="20"
                           class="form-input w-full rounded-lg border border-slate-200 dark:border-navy-500
                                  dark:bg-navy-700 dark:text-navy-100 @error('phone_number') border-error @enderror">
                    @error('phone_number')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bouton --}}
                <div class="pt-2">
                    <button type="submit"
                            class="btn w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                        @lang('locale.withdrawal_submit')
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Derniers retraits --}}
    @if ($recent->count())
        <div class="card p-5">
            <h2 class="text-sm font-semibold text-slate-700 dark:text-navy-100 mb-4">@lang('locale.withdrawal_recent')</h2>
            <div class="space-y-3">
                @foreach ($recent as $wr)
                    <div class="flex items-center justify-between rounded-lg bg-slate-50 dark:bg-navy-700 px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-700 dark:text-navy-100">{{ xaf($wr->amount) }}</p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                {{ $wr->method }} — {{ $wr->phone_number }} — {{ $wr->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="badge {{ $wr->statusColor() }} text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $wr->statusLabel() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
</x-app-layout>
