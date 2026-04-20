<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    @if (session('status') === 'password-updated')
        <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-2 text-xs font-medium text-success">
            @lang('locale.password_updated')
        </div>
    @endif

    @php $eyeIcons = '
        <svg class="pw-eye size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        <svg class="pw-eye-off size-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        </svg>'; @endphp

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.current_password')</span>
        <span class="relative mt-1 flex" data-pw-wrapper>
            <input type="password" name="current_password" autocomplete="current-password"
                   class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pr-9 text-sm
                          placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                          dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                          @error('current_password', 'updatePassword') border-error dark:border-error @enderror" />
            <button type="button" onclick="togglePw(this)"
                    style="position:absolute;top:0;bottom:0;right:0.5rem;display:flex;align-items:center;z-index:20;"
                    class="text-slate-400 hover:text-primary dark:hover:text-accent focus:outline-none">
                {!! $eyeIcons !!}
            </button>
        </span>
        @error('current_password', 'updatePassword')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
        @enderror
    </label>

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.new_password')</span>
        <span class="relative mt-1 flex" data-pw-wrapper>
            <input type="password" name="password" autocomplete="new-password"
                   class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pr-9 text-sm
                          placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                          dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                          @error('password', 'updatePassword') border-error dark:border-error @enderror" />
            <button type="button" onclick="togglePw(this)"
                    style="position:absolute;top:0;bottom:0;right:0.5rem;display:flex;align-items:center;z-index:20;"
                    class="text-slate-400 hover:text-primary dark:hover:text-accent focus:outline-none">
                {!! $eyeIcons !!}
            </button>
        </span>
        @error('password', 'updatePassword')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
        @enderror
    </label>

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.confirm_password')</span>
        <span class="relative mt-1 flex" data-pw-wrapper>
            <input type="password" name="password_confirmation" autocomplete="new-password"
                   class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pr-9 text-sm
                          placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                          dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
            <button type="button" onclick="togglePw(this)"
                    style="position:absolute;top:0;bottom:0;right:0.5rem;display:flex;align-items:center;z-index:20;"
                    class="text-slate-400 hover:text-primary dark:hover:text-accent focus:outline-none">
                {!! $eyeIcons !!}
            </button>
        </span>
    </label>

    <button type="submit"
            class="btn mt-2 w-full rounded-sm bg-primary py-2 text-sm font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
        @lang('locale.save')
    </button>
</form>
