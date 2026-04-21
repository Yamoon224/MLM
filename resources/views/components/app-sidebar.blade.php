<div class="sidebar print:hidden" x-data="{
    activePanel: @js(request()->routeIs('matrix.*') ? 'matrix' : 'dashboard'),
    togglePanel(section) {
        if (this.activePanel === section && $store.global.isSidebarExpanded) {
            $store.global.isSidebarExpanded = false;
        } else {
            this.activePanel = section;
            $store.global.isSidebarExpanded = true;
        }
    }
}">
    <!-- Main Sidebar -->
    <div class="main-sidebar">
        <div
            class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
            <!-- Application Logo -->
            <div class="flex pt-4">
                <a href="{{ route('dashboard') }}">
                    <img class="size-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg]" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
                </a>
            </div>

            <!-- Main Sections Links -->
            <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
                <!-- Dashobards -->
                <button @click="togglePanel('dashboard')"
                    :class="activePanel === 'dashboard' && $store.global.isSidebarExpanded ? 'bg-primary/10 text-primary dark:bg-navy-600 dark:text-accent-light' : 'text-slate-400 dark:text-navy-300 hover:bg-slate-100 dark:hover:bg-navy-600'"
                    class="flex size-11 items-center justify-center rounded-sm outline-hidden transition-colors duration-200"
                    x-tooltip.placement.right="'@lang('locale.dashboard')'">
                    <svg class="size-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-opacity=".3"
                            d="M5 14.059c0-1.01 0-1.514.222-1.945.221-.43.632-.724 1.453-1.31l4.163-2.974c.56-.4.842-.601 1.162-.601.32 0 .601.2 1.162.601l4.163 2.974c.821.586 1.232.88 1.453 1.31.222.43.222.935.222 1.945V19c0 .943 0 1.414-.293 1.707C18.414 21 17.943 21 17 21H7c-.943 0-1.414 0-1.707-.293C5 20.414 5 19.943 5 19v-4.94Z" />
                        <path fill="currentColor"
                            d="M3 12.387c0 .267 0 .4.084.441.084.041.19-.04.4-.204l7.288-5.669c.59-.459.885-.688 1.228-.688.343 0 .638.23 1.228.688l7.288 5.669c.21.163.316.245.4.204.084-.04.084-.174.084-.441v-.409c0-.48 0-.72-.102-.928-.101-.208-.291-.355-.67-.65l-7-5.445c-.59-.459-.885-.688-1.228-.688-.343 0-.638.23-1.228.688l-7 5.445c-.379.295-.569.442-.67.65-.102.208-.102.448-.102.928v.409Z" />
                        <path fill="currentColor"
                            d="M11.5 15.5h1A1.5 1.5 0 0 1 14 17v3.5h-4V17a1.5 1.5 0 0 1 1.5-1.5Z" />
                        <path fill="currentColor"
                            d="M17.5 5h-1a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5Z" />
                    </svg>
                </button>

                <!-- Matrix Tree -->
                <button @click="togglePanel('matrix')"
                    :class="activePanel === 'matrix' && $store.global.isSidebarExpanded ? 'bg-primary/10 text-primary dark:bg-navy-600 dark:text-accent-light' : 'text-slate-400 dark:text-navy-300 hover:bg-slate-100 dark:hover:bg-navy-600'"
                    class="flex size-11 items-center justify-center rounded-sm outline-hidden transition-colors duration-200"
                    x-tooltip.placement.right="'@lang('locale.matrix_tree')'">
                    <svg class="size-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 2a2 2 0 110 4 2 2 0 010-4zM5 10a2 2 0 110 4 2 2 0 010-4zm14 0a2 2 0 110 4 2 2 0 010-4zM12 6v4M5 14v4m14-4v4M8 12h8" />
                    </svg>
                </button>
            </div>

            <!-- Bottom Links -->
            <div class="flex flex-col items-center space-y-3 py-3">
                <!-- Profile -->
                <div x-data="usePopper({placement:'right-end',offset:12})"
                    @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
                    <button @click="isShowPopper = !isShowPopper" x-ref="popperRef"
                        class="avatar size-12 cursor-pointer">
                        <div class="flex size-12 items-center justify-center rounded-full bg-primary text-white text-base font-bold dark:bg-accent">
                            {{ mb_strtoupper(mb_substr(auth()->user()->full_name, 0, 1)) }}{{ mb_strtoupper(mb_substr(explode(' ', trim(auth()->user()->full_name))[1] ?? '', 0, 1)) }}
                        </div>
                        <span
                            class="absolute right-0 size-3.5 rounded-full border-2 border-white bg-success dark:border-navy-700"></span>
                    </button>

                    <div :class="isShowPopper && 'show'" class="popper-root fixed" x-ref="popperRoot">
                        <div
                            class="popper-box w-64 rounded-sm border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                            <div
                                class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                                <div class="flex size-14 items-center justify-center rounded-full bg-primary text-white text-xl font-bold dark:bg-accent">
                                    {{ mb_strtoupper(mb_substr(auth()->user()->full_name, 0, 1)) }}{{ mb_strtoupper(mb_substr(explode(' ', trim(auth()->user()->full_name))[1] ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('profile.edit') }}"
                                        class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                        {{ auth()->user()->full_name }}
                                    </a>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        {{ auth()->user()->referral_code }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col pt-2 pb-5">
                                <a href="{{ route('profile.edit') }}"
                                    class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-hidden transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                    <div
                                        class="flex size-8 items-center justify-center rounded-sm bg-warning text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <h2
                                            class="font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                            @lang('locale.profile')
                                        </h2>
                                        <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                            @lang('locale.your_profile')
                                        </div>
                                    </div>
                                </a>
                                <div class="mt-3 px-4">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>@lang('locale.logout')</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Panel -->
    <div class="sidebar-panel">
        <div class="flex h-full grow flex-col bg-white pl-[var(--main-sidebar-width)] dark:bg-navy-750">
            <!-- Sidebar Panel Header -->
            <div class="flex h-18 w-full items-center justify-between pl-4 pr-1">
                <p class="text-base tracking-wider text-slate-800 dark:text-navy-100">
                    <span x-show="activePanel === 'dashboard'">@lang('locale.dashboard')</span>
                    <span x-show="activePanel === 'matrix'" x-cloak>@lang('locale.matrix_tree')</span>
                </p>
                <button @click="$store.global.isSidebarExpanded = false"
                    class="btn size-7 rounded-full p-0 text-primary hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:text-accent-light/80 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 xl:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Panel Body -->
            <div x-data="{expandedItem:null}" class="h-[calc(100%-4.5rem)] overflow-x-hidden pb-6"
                x-init="$el._x_simplebar = new SimpleBar($el);">

                <!-- Section: Dashboard -->
                <template x-if="activePanel === 'dashboard'">
                    <ul class="flex flex-1 flex-col px-4 font-inter">
                        <li>
                            <a x-data="navLink" href="{{ route('dashboard') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                                @lang('locale.dashboard')
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="{{ route('wallet.withdraw') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                                @lang('locale.withdrawal', ['suffix'=>'s'])
                            </a>
                        </li>
                        @if (auth()->user()?->is_admin)
                        <li>
                            <a x-data="navLink" href="{{ route('admin.withdrawals.index') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                                @lang('locale.admin_withdrawals')
                            </a>
                        </li>
                        <li>
                            <a x-data="navLink" href="{{ route('admin.users.index') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                                @lang('locale.admin_users')
                            </a>
                        </li>
                        @endif
                    </ul>
                </template>

                <!-- Section: Matrix -->
                <template x-if="activePanel === 'matrix'">
                    <ul class="flex flex-1 flex-col px-4 font-inter">
                        <li>
                            <a x-data="navLink" href="{{ route('matrix.tree') }}"
                                :class="isActive ? 'font-medium text-primary dark:text-accent-light' : 'text-slate-600 hover:text-slate-900 dark:text-navy-200 dark:hover:text-navy-50'"
                                class="flex py-2 text-xs-plus tracking-wide outline-hidden transition-colors duration-300 ease-in-out">
                                @lang('locale.matrix_tree')
                            </a>
                        </li>
                    </ul>
                </template>

                <div class="my-3 mx-4 h-px bg-slate-200 dark:bg-navy-500"></div>
            </div>
        </div>
    </div>
</div>