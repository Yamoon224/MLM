<x-app-layout>

    <div class="mt-4 sm:mt-5 lg:mt-6">

        {{-- En-tête page --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    @lang('locale.matrix_tree')
                </h2>
                <p class="text-xs text-slate-400 dark:text-navy-300 mt-0.5">
                    @lang('locale.matrix_tree_subtitle', ['name' => $user->full_name])
                </p>
            </div>
            @if($user->id !== auth()->id())
                <a href="{{ route('matrix.tree') }}"
                   class="btn rounded-sm border border-slate-300 bg-white font-medium text-slate-700 hover:bg-slate-150
                          dark:border-navy-450 dark:bg-navy-700 dark:text-navy-100 dark:hover:bg-navy-600 text-xs px-3 py-1.5">
                    ← @lang('locale.back_to_my_tree')
                </a>
            @endif
        </div>

        {{-- Stats par niveau --}}
        <div class="mb-6 space-y-3">
            {{-- Ligne 1 : niveaux 1-3 --}}
            <div class="grid grid-cols-3 gap-3">
                @foreach(array_slice($stats, 0, 3, true) as $level => $count)
                <div class="card flex flex-col items-center py-4 px-3">
                    <span class="flex size-8 items-center justify-center rounded-full
                                 {{ $count > 0 ? 'bg-primary/10 text-primary dark:bg-navy-600 dark:text-accent-light' : 'bg-slate-100 text-slate-400 dark:bg-navy-700 dark:text-navy-400' }}
                                 text-sm font-bold mb-1">
                        {{ $count }}
                    </span>
                    <p class="text-xs text-slate-500 dark:text-navy-300 text-center">
                        @lang('locale.level') {{ $level }}
                    </p>
                    <div class="mt-1.5 w-full bg-slate-100 dark:bg-navy-600 rounded-full h-1">
                        @php
                            $max = pow(5, $level);
                            $percent = $max > 0 ? min(100, round($count / $max * 100)) : 0;
                        @endphp
                        <div class="h-1 rounded-full {{ $count > 0 ? 'bg-primary' : 'bg-slate-200 dark:bg-navy-500' }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-2xs text-slate-400 dark:text-navy-400 mt-1">{{ $percent }}%</p>
                </div>
                @endforeach
            </div>
            {{-- Ligne 2 : niveaux 4-5 --}}
            <div class="grid grid-cols-2 gap-3">
                @foreach(array_slice($stats, 3, 2, true) as $level => $count)
                <div class="card flex flex-col items-center py-4 px-3">
                    <span class="flex size-8 items-center justify-center rounded-full
                                 {{ $count > 0 ? 'bg-primary/10 text-primary dark:bg-navy-600 dark:text-accent-light' : 'bg-slate-100 text-slate-400 dark:bg-navy-700 dark:text-navy-400' }}
                                 text-sm font-bold mb-1">
                        {{ $count }}
                    </span>
                    <p class="text-xs text-slate-500 dark:text-navy-300 text-center">
                        @lang('locale.level') {{ $level }}
                    </p>
                    <div class="mt-1.5 w-full bg-slate-100 dark:bg-navy-600 rounded-full h-1">
                        @php
                            $max = pow(5, $level);
                            $percent = $max > 0 ? min(100, round($count / $max * 100)) : 0;
                        @endphp
                        <div class="h-1 rounded-full {{ $count > 0 ? 'bg-primary' : 'bg-slate-200 dark:bg-navy-500' }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-2xs text-slate-400 dark:text-navy-400 mt-1">{{ $percent }}%</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Arbre généalogique --}}
        <div class="card p-4 sm:p-6 overflow-x-auto my-2">
            <div id="matrix-tree-wrapper"
                 class="min-w-max mx-auto py-4 px-2">
                @include('matrix._node', ['node' => $tree])
            </div>
        </div>

        {{-- Légende --}}
        <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-navy-300">
            <div class="flex items-center gap-1.5">
                <div class="size-4 rounded-full bg-primary"></div>
                <span>@lang('locale.root_node')</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="size-4 rounded-full bg-slate-200 dark:bg-navy-600"></div>
                <span>@lang('locale.active_member')</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="size-4 rounded-full bg-red-100 ring-2 ring-red-300 dark:bg-red-900/30 dark:ring-red-700"></div>
                <span>@lang('locale.inactive_member')</span>
            </div>
            <div class="flex items-center gap-1.5">
                <div class="size-4 rounded-full border-2 border-dashed border-slate-300 dark:border-navy-500"></div>
                <span>@lang('locale.empty_slot')</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="flex size-4 items-center justify-center rounded-full bg-accent text-white text-2xs font-bold">N</span>
                <span>@lang('locale.depth_badge')</span>
            </div>
        </div>

    </div>

</x-app-layout>
