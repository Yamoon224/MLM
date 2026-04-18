<x-app-layout>
<div class="flex items-center justify-center min-h-[70vh] px-4">
    <div class="w-full max-w-lg">

        {{-- Carte principale --}}
        <div class="card overflow-hidden">

            {{-- En-tête dégradé --}}
            <div class="bg-gradient-to-r from-red-500 to-orange-500 p-6 text-center text-white">
                <div class="mx-auto mb-4 flex size-16 items-center justify-center rounded-full bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">@lang('locale.account_expired_title')</h1>
                <p class="mt-1 text-sm text-red-100">@lang('locale.account_expired_subtitle')</p>
            </div>

            <div class="p-6 space-y-6">

                {{-- Info compte --}}
                <div class="rounded-xl bg-slate-50 p-4 dark:bg-navy-700 flex items-center gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-slate-700 dark:text-navy-100">{{ $user->full_name }}</p>
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            @lang('locale.expired_since')&nbsp;:
                            <span class="font-semibold text-red-500">
                                {{ $user->expires_at?->format('d/m/Y') ?? '—' }}
                            </span>
                        </p>
                    </div>
                </div>

                {{-- Instructions de paiement --}}
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-700 dark:bg-amber-900/20">
                    <p class="font-semibold text-amber-800 dark:text-amber-300 mb-2">
                        @lang('locale.payment_instructions_title')
                    </p>
                    <ol class="space-y-1 text-sm text-amber-700 dark:text-amber-400 list-decimal list-inside">
                        <li>@lang('locale.payment_step_1', ['amount' => number_format($amount, 0, ',', ' ')])</li>
                        <li>@lang('locale.payment_step_2')</li>
                        <li>@lang('locale.payment_step_3')</li>
                    </ol>
                </div>

                {{-- Montant mis en avant --}}
                <div class="flex items-center justify-between rounded-xl bg-primary/10 px-4 py-3 dark:bg-accent/10">
                    <span class="text-sm font-medium text-slate-600 dark:text-navy-200">
                        @lang('locale.renewal_amount')
                    </span>
                    <span class="text-xl font-bold text-primary dark:text-accent-light">
                        {{ number_format($amount, 0, ',', ' ') }}&nbsp;FCFA
                    </span>
                </div>

                {{-- Formulaire de soumission de référence --}}
                <form method="POST" action="{{ route('account.renewal.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="payment_reference" class="block text-sm font-medium text-slate-700 dark:text-navy-100 mb-1">
                            @lang('locale.payment_reference')
                        </label>
                        <input
                            type="text"
                            id="payment_reference"
                            name="payment_reference"
                            required
                            maxlength="100"
                            placeholder="Ex: TXN-12345678"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-primary focus:ring-1 focus:ring-primary dark:border-navy-500 dark:bg-navy-700 dark:text-navy-100"
                            value="{{ old('payment_reference') }}"
                        />
                        @error('payment_reference')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="btn w-full bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus">
                        @lang('locale.renew_account')
                    </button>
                </form>

                {{-- Lien déconnexion --}}
                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-slate-400 hover:text-slate-600 underline dark:text-navy-300 dark:hover:text-navy-100">
                            @lang('locale.logout')
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
</x-app-layout>
