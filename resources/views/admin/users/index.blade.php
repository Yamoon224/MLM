<x-app-layout>
<div class="mt-4 sm:mt-5 lg:mt-6 space-y-5">

    {{-- Titre --}}
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-slate-700 dark:text-navy-100">
            @lang('locale.admin_users')
        </h1>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div class="rounded-xl border border-success/30 bg-success/10 px-4 py-3 text-sm font-medium text-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Recherche --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ $search }}"
               placeholder="@lang('locale.search_user')"
               class="form-input w-full max-w-sm rounded-sm border border-slate-300 bg-transparent px-3 py-2 text-sm
                      placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary
                      dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
        <button type="submit"
                class="btn rounded-sm bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-focus dark:bg-accent dark:hover:bg-accent-focus">
            @lang('locale.search')
        </button>
        @if ($search)
            <a href="{{ route('admin.users.index') }}"
               class="btn rounded-sm border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600
                      hover:bg-slate-100 dark:border-navy-450 dark:text-navy-200 dark:hover:bg-navy-600">
                ✕
            </a>
        @endif
    </form>

    {{-- Tableau --}}
    <div class="card overflow-hidden">
        @if ($users->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-slate-400 dark:text-navy-300">
                <p class="text-sm">@lang('locale.no_users_found')</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-navy-700 text-xs font-medium uppercase text-slate-500 dark:text-navy-300">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">@lang('locale.user')</th>
                            <th class="px-4 py-3 text-left">@lang('locale.phone')</th>
                            <th class="px-4 py-3 text-center">@lang('locale.status')</th>
                            <th class="px-4 py-3 text-right">@lang('locale.actions')</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-navy-600">
                        @foreach ($users as $u)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-navy-700/50">
                                <td class="px-4 py-3 text-slate-400 dark:text-navy-400">{{ $u->id }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">{{ $u->full_name }}</p>
                                    <p class="text-xs text-slate-400 dark:text-navy-400">{{ $u->email }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-500 dark:text-navy-300">{{ $u->phone }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($u->is_active)
                                        <span class="rounded-full bg-success/10 px-2 py-0.5 text-xs font-medium text-success">
                                            @lang('locale.active')
                                        </span>
                                    @else
                                        <span class="rounded-full bg-error/10 px-2 py-0.5 text-xs font-medium text-error">
                                            @lang('locale.inactive')
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.users.reset-password', $u) }}"
                                       class="inline-flex items-center gap-1 rounded-sm border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium
                                              text-slate-600 hover:bg-slate-50 dark:border-navy-450 dark:bg-navy-700 dark:text-navy-200 dark:hover:bg-navy-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                        @lang('locale.reset_password')
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-slate-100 dark:border-navy-600">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
</x-app-layout>
