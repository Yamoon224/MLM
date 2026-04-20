<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 max-w-lg mx-auto space-y-5">

    {{-- Titre --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.index') }}"
           class="btn size-8 rounded-full p-0 text-slate-400 hover:bg-slate-100 dark:hover:bg-navy-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-lg font-semibold text-slate-700 dark:text-navy-100">
            @lang('locale.reset_password')
        </h1>
    </div>

    {{-- Info utilisateur --}}
    <div class="card px-5 py-4 flex items-center gap-4">
        <div class="flex size-11 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-navy-600 dark:text-accent-light font-bold text-lg">
            {{ mb_substr($user->full_name, 0, 1) }}
        </div>
        <div>
            <p class="font-medium text-slate-700 dark:text-navy-100">{{ $user->full_name }}</p>
            <p class="text-xs text-slate-400 dark:text-navy-400">{{ $user->email }} · {{ $user->phone }}</p>
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="card px-5 py-6">
        <form method="POST" action="{{ route('admin.users.reset-password.update', $user) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <label class="block">
                <span class="text-sm font-medium text-slate-600 dark:text-navy-200">
                    @lang('locale.new_password')
                </span>
                <span class="relative mt-1.5 flex" data-pw-wrapper>
                    <input type="password" name="password"
                           class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pr-9
                                  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                                  dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent
                                  @error('password') border-error dark:border-error @enderror"
                           placeholder="••••••••" required minlength="8" autocomplete="new-password" />
                    <button type="button" onclick="togglePw(this)"
                            style="position:absolute;top:0;bottom:0;right:0.5rem;display:flex;align-items:center;z-index:20;"
                            class="text-slate-400 hover:text-primary dark:hover:text-accent focus:outline-none">
                        <svg class="pw-eye size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="pw-eye-off size-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </span>
                @error('password')
                    <p class="mt-1 text-xs text-error">{{ $message }}</p>
                @enderror
            </label>

            <label class="block">
                <span class="text-sm font-medium text-slate-600 dark:text-navy-200">
                    @lang('locale.confirm_password')
                </span>
                <span class="relative mt-1.5 flex" data-pw-wrapper>
                    <input type="password" name="password_confirmation"
                           class="form-input peer w-full rounded-sm border border-slate-300 bg-transparent px-3 py-2 pr-9
                                  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                                  dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                           placeholder="••••••••" required minlength="8" autocomplete="new-password" />
                    <button type="button" onclick="togglePw(this)"
                            style="position:absolute;top:0;bottom:0;right:0.5rem;display:flex;align-items:center;z-index:20;"
                            class="text-slate-400 hover:text-primary dark:hover:text-accent focus:outline-none">
                        <svg class="pw-eye size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="pw-eye-off size-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </span>
            </label>

            <button type="submit"
                    class="btn mt-2 w-full rounded-sm bg-primary py-2.5 font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
                @lang('locale.save_new_password')
            </button>
        </form>
    </div>

</div>
</x-app-layout>
