<x-app-layout>
    <div class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
        <div class="col-span-12 lg:col-span-8">
            {{-- BALANCE CARD --}}
            <div class="card bg-gradient-to-br from-purple-500 to-indigo-600 px-4 pb-4 sm:px-5">
                <div class="flex items-center justify-between py-3 text-white">
                    <h2 class="text-sm-plus font-medium tracking-wide">@lang('locale.your_balance')</h2>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:gap-6">
                    <div>
                        <div class="flex w-9/12 items-center space-x-1">
                            <p class="text-xs text-indigo-100 line-clamp-1">{{ auth()->user()->referral_code }}</p>
                            <button
                                class="btn size-5 shrink-0 rounded-full p-0 text-white hover:bg-white/20 focus:bg-white/20 active:bg-white/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" />
                                    <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-3 text-3xl font-semibold text-white">{{ auth()->user()->wallet->balance }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:gap-5 lg:gap-6">
                        <div>
                            <p class="text-indigo-100">@lang('locale.referral_bonus')</p>
                            <div class="mt-1 flex items-center space-x-2">
                                <div
                                    class="flex size-7 items-center justify-center rounded-full bg-black/20 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-white">{{ $referral_bonus }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-indigo-100">@lang('locale.level_bonus')</p>
                            <div class="mt-1 flex items-center space-x-2">
                                <div
                                    class="flex size-7 items-center justify-center rounded-full bg-black/20 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                    </svg>
                                </div>
                                <p class="text-base font-medium text-white">{{ $level_bonus }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 sm:mt-5 lg:mt-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        @lang('locale.member', ['suffix'=>'s'])
                    </h2>
                </div>
                <div class="card mt-2">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                        <table class="is-hoverable w-full text-left">
                            <thead class="rounded-tl-sm rounded-tr-sm">
                                <th class="whitespace-nowrap rounded-tl-md bg-slate-200 p-2 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                    @lang('locale.referral_code')
                                </th>
                                <th class="whitespace-nowrap bg-slate-200 p-2 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                    @lang('locale.created_at')
                                </th>
                                <th class="whitespace-nowrap bg-slate-200 p-2 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                    @lang('locale.full_name')
                                </th>
                                <th class="whitespace-nowrap bg-slate-200 p-2 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                    @lang('locale.level')
                                </th>
                            </thead>
                            <tbody>
                                @forelse($descendants as $descendant)
                                <tr class="border-y border-transparent px-2 border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap p-2 text-primary dark:text-accent-light">
                                        {{ $descendant->referral_code }}
                                    </td>

                                    <td class="whitespace-nowrap p-2">
                                        {{ $descendant->created_at->format('d M Y h:i A') }}
                                    </td>

                                    <td class="whitespace-nowrap p-2 font-medium text-slate-700 dark:text-navy-100">
                                        {{ $descendant->full_name }}
                                    </td>

                                    <td class="whitespace-nowrap p-2 overflow-hidden text-ellipsis text-xs-plus">
                                        @lang('locale.level') {{ $descendant->pivot->depth }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-slate-500">
                                        No descendants found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col justify-between space-y-2 px-4 py-2 sm:flex-row sm:items-center sm:space-y-0 sm:px-2">
                        {{-- Select per page --}}
                        <div class="flex items-center space-x-2 text-xs-plus">
                            <span>Show</span>
                            <form method="GET" id="perPageForm">
                                <label class="block">
                                    <select name="per_page"
                                            onchange="document.getElementById('perPageForm').submit()"
                                            class="form-select rounded-sm border border-slate-300 bg-white px-2 py-1 pr-6
                                                hover:border-slate-400 focus:border-primary
                                                dark:border-navy-450 dark:bg-navy-700
                                                dark:hover:border-navy-400 dark:focus:border-accent">

                                        @foreach([10,30,50] as $size)
                                            <option value="{{ $size }}"
                                                {{ request('per_page',10) == $size ? 'selected' : '' }}>
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                            </form>
                            <span>entries</span>
                        </div>

                        {{-- Pagination Links --}}
                        <ol class="pagination flex -space-x-px">

                            {{-- Previous --}}
                            @if ($descendants->onFirstPage())
                                <li class="rounded-l-sm bg-slate-150 dark:bg-navy-500 opacity-50">
                                    <span class="flex size-8 items-center justify-center">‹</span>
                                </li>
                            @else
                                <li class="rounded-l-sm bg-slate-150 dark:bg-navy-500">
                                    <a href="{{ $descendants->previousPageUrl() }}"
                                    class="flex size-8 items-center justify-center rounded-sm hover:bg-slate-300 dark:hover:bg-navy-450">
                                        ‹
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($descendants->links()->elements[0] ?? [] as $page => $url)
                                <li class="bg-slate-150 dark:bg-navy-500">
                                    <a href="{{ $url }}"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-sm px-3
                                    {{ $page == $descendants->currentPage()
                                            ? 'bg-primary text-white dark:bg-accent'
                                            : 'hover:bg-slate-300 dark:hover:bg-navy-450' }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- Next --}}
                            @if ($descendants->hasMorePages())
                                <li class="rounded-r-sm bg-slate-150 dark:bg-navy-500">
                                    <a href="{{ $descendants->nextPageUrl() }}"
                                    class="flex size-8 items-center justify-center rounded-sm hover:bg-slate-300 dark:hover:bg-navy-450">
                                        ›
                                    </a>
                                </li>
                            @else
                                <li class="rounded-r-sm bg-slate-150 dark:bg-navy-500 opacity-50">
                                    <span class="flex size-8 items-center justify-center">›</span>
                                </li>
                            @endif

                        </ol>

                        {{-- Info --}}
                        <div class="text-xs-plus">
                            {{ $descendants->firstItem() }} - {{ $descendants->lastItem() }}
                            of {{ $descendants->total() }} entries
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 grid grid-cols-1 gap-4 sm:gap-5 lg:col-span-4 lg:gap-4">
            <div class="grid grid-cols-3 mt-2 gap-2 sm:grid-cols-2 sm:gap-2 lg:gap-2">
                <div class="card justify-center p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                56
                            </p>
                            <p class="text-xs-plus line-clamp-1">Projects</p>
                        </div>
                        <div
                            class="mask is-star flex size-10 shrink-0 items-center justify-center bg-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div
                            class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                            <span>10%</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 1286 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card justify-center p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">324</p>
                            <p class="text-xs-plus line-clamp-1">Total hours</p>
                        </div>
                        <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                            <span>6%</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 1286 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card justify-center p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">7</p>
                            <p class="text-xs-plus line-clamp-1">Support Ticket</p>
                        </div>
                        <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="badge mt-2 space-x-1 bg-success/10 py-1 px-1.5 text-success dark:bg-success/15">
                            <span>9%</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 1286 7H12z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="card justify-center p-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">56</p>
                            <p class="text-xs-plus line-clamp-1">Active Task</p>
                        </div>
                        <div
                            class="mask is-star flex size-10 shrink-0 items-center justify-center bg-warning">
                            <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5293 18L20.9999 8.40002" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M3 13.2L7.23529 18L17.8235 6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="badge mt-2 space-x-1 bg-error/10 py-1 px-1.5 text-error dark:bg-error/15">
                            <span>6%</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card pb-2">
                <div class="p-4 sm:px-5">
                    <div x-data="{activeTab:'tabReceive'}" class="tabs mt-3 flex flex-col">
                        <div class="is-scrollbar-hidden overflow-x-auto rounded-sm bg-slate-150 text-slate-600 dark:bg-navy-800 dark:text-navy-200">
                            <div class="tabs-list flex p-1">
                                <button @click="activeTab = 'tabReceive'"
                                    :class="activeTab === 'tabReceive' ? 'bg-white shadow-sm dark:bg-navy-500 dark:text-navy-100' : 'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                    class="btn flex-1 space-x-2 px-3 py-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span> @lang('locale.withdrawal', ['suffix'=>'']) </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="pt-4">
                            <p class="text-xs-plus">You send</p>
                            <div
                                class="mt-1 flex justify-between space-x-2 rounded-2xl bg-slate-150 p-1.5 dark:bg-navy-800">
                                <select
                                    class="form-select h-8 rounded-2xl border border-transparent bg-white px-4 py-0 pr-9 text-xs-plus hover:border-slate-400 focus:border-primary dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <option>Bitcoin</option>
                                    <option>Ethereum</option>
                                    <option>Solana</option>
                                    <option>Litecoin</option>
                                </select>
                                <input
                                    class="form-input w-full bg-transparent px-2 text-right placeholder:text-slate-400/70"
                                    placeholder="Amount" type="text" />
                            </div>
                        </div>
                        <div class="pt-4">
                            <p class="text-xs-plus">You receive</p>
                            <div
                                class="mt-1 flex justify-between space-x-2 rounded-2xl bg-slate-150 p-1.5 dark:bg-navy-800">
                                <select
                                    class="form-select h-8 rounded-2xl border border-transparent bg-white px-4 py-0 pr-9 text-xs-plus hover:border-slate-400 focus:border-primary dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <option>Dollar</option>
                                    <option>Ethereum</option>
                                    <option>Solana</option>
                                    <option>Litecoin</option>
                                </select>
                                <input
                                    class="form-input w-full bg-transparent px-2 text-right placeholder:text-slate-400/70"
                                    placeholder="Amount" type="text" />
                            </div>
                        </div>
                        <div class="absolute right-0 top-1/2 mt-1">
                            <button
                                class="btn mask is-hexagon size-7 bg-primary p-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button
                        class="btn mt-6 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Buy BTC
                    </button>
                </div>
            </div>

            {{-- <div class="card px-4 pb-5 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Top Countries
                    </h2>
                </div>
                <div>
                    <p>
                        <span class="text-2xl text-slate-700 dark:text-navy-100">64</span>
                    </p>
                    <p class="text-xs-plus">Countries</p>
                </div>
                <div class="mt-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img class="size-6" src="images/flags/australia-round.svg" alt="flag" />
                            <p>Australia</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm-plus text-slate-800 dark:text-navy-100">
                                $6.41k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img class="size-6" src="images/flags/brazil-round.svg" alt="flag" />
                            <p>Brazil</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm-plus text-slate-800 dark:text-navy-100">
                                $2.33k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img class="size-6" src="images/flags/china-round.svg" alt="flag" />
                            <p>China</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm-plus text-slate-800 dark:text-navy-100">
                                $7.21k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img class="size-6" src="images/flags/india-round.svg" alt="flag" />
                            <p>India</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm-plus text-slate-800 dark:text-navy-100">
                                $754
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-error" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <img class="size-6" src="images/flags/italy-round.svg" alt="flag" />
                            <p>Italy</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <p class="text-sm-plus text-slate-800 dark:text-navy-100">
                                $699
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
