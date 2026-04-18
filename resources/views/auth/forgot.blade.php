<x-auth-layout>
    <div class="text-center">
        <img class="mx-auto size-16" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
        <div class="mt-2">
            <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">@lang('locale.forgot_password')</h2>
            <p class="mt-1 text-sm text-slate-400 dark:text-navy-300">
                @lang('locale.forgot_password_hint')
            </p>
        </div>
    </div>

    <div class="card mt-5 rounded-sm p-5 lg:p-7">

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="block">
                <span>@lang('locale.email')</span>
                <span class="relative mt-1.5 flex">
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required autofocus
                        class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="@lang('locale.enter', ['param' => __('locale.email')])" />
                    <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </span>
                @error('email')
                    <span class="mt-1 text-xs text-error">{{ $message }}</span>
                @enderror
            </label>

            <button class="btn mt-5 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                @lang('locale.send_reset_link')
            </button>

            <div class="mt-4 text-center text-xs-plus">
                <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent" href="{{ route('login') }}">
                    ← @lang('locale.back_to_login')
                </a>
            </div>
        </form>
    </div>
</x-auth-layout>
