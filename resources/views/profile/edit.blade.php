<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6">

    {{-- En-tête --}}
    <div class="mb-6 flex items-center gap-4">
        <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-primary text-white text-2xl font-bold dark:bg-accent">
            {{ mb_strtoupper(mb_substr(auth()->user()->full_name, 0, 1)) }}{{ mb_strtoupper(mb_substr(explode(' ', trim(auth()->user()->full_name))[1] ?? '', 0, 1)) }}
        </div>
        <div>
            <h2 class="text-base font-semibold text-slate-700 dark:text-navy-100">{{ auth()->user()->full_name }}</h2>
            <p class="text-xs text-slate-400 dark:text-navy-300">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

        {{-- Informations du profil --}}
        <div class="card p-5 space-y-4">
            <h3 class="text-sm font-semibold text-slate-600 dark:text-navy-200">@lang('locale.profile_info')</h3>
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Mot de passe --}}
        <div class="card p-5 space-y-4">
            <h3 class="text-sm font-semibold text-slate-600 dark:text-navy-200">@lang('locale.update_password')</h3>
            @include('profile.partials.update-password-form')
        </div>

    </div>

</div>
</x-app-layout>
