<!-- App Header Wrapper-->
<nav class="header before:bg-white dark:before:bg-navy-750 print:hidden">
    <!-- App Header  -->
    <div class="header-container relative flex w-full print:hidden">
        <!-- Header Items -->
        <div class="flex w-full items-center justify-between">
            <!-- Left: Sidebar Toggle Button -->
            <div class="size-7">
                <button
                    class="menu-toggle cursor-pointer ml-0.5 flex size-7 flex-col justify-center space-y-1.5 text-primary outline-hidden focus:outline-hidden dark:text-accent-light/80"
                    :class="$store.global.isSidebarExpanded && 'active'"
                    @click="$store.global.isSidebarExpanded = !$store.global.isSidebarExpanded">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <!-- Right: Header buttons -->
            <div class="-mr-1.5 flex items-center space-x-2">
                <!-- Mobile Search Toggle -->
                <button @click="$store.global.isSearchbarActive = !$store.global.isSearchbarActive"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5.5 text-slate-500 dark:text-navy-100"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Dark Mode Toggle -->
                <button @click="$store.global.isDarkModeEnabled = !$store.global.isDarkModeEnabled"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg x-show="$store.global.isDarkModeEnabled"
                        x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                        x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                        class="size-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M11.75 3.412a.818.818 0 01-.07.917 6.332 6.332 0 00-1.4 3.971c0 3.564 2.98 6.494 6.706 6.494a6.86 6.86 0 002.856-.617.818.818 0 011.1 1.047C19.593 18.614 16.218 21 12.283 21 7.18 21 3 16.973 3 11.956c0-4.563 3.46-8.31 7.925-8.948a.818.818 0 01.826.404z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" x-show="!$store.global.isDarkModeEnabled"
                        x-transition:enter="transition-transform duration-200 ease-out absolute origin-top"
                        x-transition:enter-start="scale-75" x-transition:enter-end="scale-100 static"
                        class="size-6 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Language Switcher -->
                <div class="flex items-center gap-0.5 rounded-full bg-slate-100 p-0.5 dark:bg-navy-700">
                    <a href="{{ route('locale.switch', 'fr') }}"
                       class="flex items-center rounded-full px-2 py-0.5 text-xs font-semibold transition
                              {{ app()->getLocale() === 'fr' ? 'bg-white text-primary shadow dark:bg-navy-500 dark:text-accent-light' : 'text-slate-500 hover:text-slate-700 dark:text-navy-300 dark:hover:text-navy-100' }}">
                        FR
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}"
                       class="flex items-center rounded-full px-2 py-0.5 text-xs font-semibold transition
                              {{ app()->getLocale() === 'en' ? 'bg-white text-primary shadow dark:bg-navy-500 dark:text-accent-light' : 'text-slate-500 hover:text-slate-700 dark:text-navy-300 dark:hover:text-navy-100' }}">
                        EN
                    </a>
                </div>

                <!-- User Avatar Dropdown -->
                @php
                    $fullName = auth()->user()->full_name ?? auth()->user()->name ?? '';
                    $parts = explode(' ', trim($fullName));
                    $initials = mb_strtoupper(mb_substr($parts[0] ?? '', 0, 1))
                              . mb_strtoupper(mb_substr($parts[1] ?? '', 0, 1));
                @endphp
                <div x-data="usePopper({placement:'bottom-end',offset:8})"
                    @click.outside="isShowPopper && (isShowPopper = false)" class="flex">
                    <button @click="isShowPopper = !isShowPopper" x-ref="popperRef"
                        class="flex size-8 items-center justify-center rounded-full bg-primary text-xs font-bold text-white hover:opacity-90 focus:ring-2 focus:ring-primary/40 transition dark:bg-accent">
                        {{ $initials }}
                    </button>

                    <div :class="isShowPopper && 'show'" class="popper-root" x-ref="popperRoot">
                        <div class="popper-box mt-1 w-48 rounded-lg border border-slate-150 bg-white py-1.5 shadow-soft dark:border-navy-800 dark:bg-navy-700 dark:shadow-soft-dark">
                            {{-- En-tête --}}
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-navy-600">
                                <p class="text-xs font-semibold text-slate-700 dark:text-navy-100 truncate">{{ $fullName }}</p>
                                <p class="text-xs text-slate-400 dark:text-navy-300 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            {{-- Liens --}}
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 dark:text-navy-100 dark:hover:bg-navy-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                @lang('locale.profile')
                            </a>

                            <div class="my-1 h-px bg-slate-100 dark:bg-navy-600"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-error hover:bg-slate-100 dark:hover:bg-navy-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    @lang('locale.logout')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>