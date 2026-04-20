<form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    @if (session('status') === 'profile-updated')
        <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-2 text-xs font-medium text-success">
            @lang('locale.profile_updated')
        </div>
    @endif

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.full_name')</span>
        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" required
               class="form-input mt-1 w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 text-sm
                      placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                      dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                      @error('full_name') border-error dark:border-error @enderror" />
        @error('full_name')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
        @enderror
    </label>

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.email')</span>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="form-input mt-1 w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 text-sm
                      placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                      dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                      @error('email') border-error dark:border-error @enderror" />
        @error('email')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
        @enderror
    </label>

    <label class="block">
        <span class="text-xs font-medium text-slate-600 dark:text-navy-200">@lang('locale.phone')</span>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
               class="form-input mt-1 w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 text-sm
                      placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                      dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                      @error('phone') border-error dark:border-error @enderror" />
        @error('phone')
            <p class="mt-1 text-xs text-error">{{ $message }}</p>
        @enderror
    </label>

    <button type="submit"
            class="btn mt-2 w-full rounded-sm bg-primary py-2 text-sm font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
        @lang('locale.save')
    </button>
</form>
