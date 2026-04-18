{{-- Partiel récursif : affiche un nœud et ses enfants --}}
@props(['node', 'maxChildren' => 5])

@php
    $user     = $node['user'];
    $depth    = $node['depth'];
    $children = $node['children'];
    $filledSlots  = count($children);
    $emptySlots   = $maxChildren - $filledSlots;
    $isInactive   = !$user->is_active;
@endphp

<div class="matrix-node flex flex-col items-center" data-depth="{{ $depth }}">

    {{-- Carte utilisateur --}}
    <a href="{{ route('matrix.tree.node', $user->id) }}"
       class="group relative flex flex-col items-center">
        <div class="flex size-14 items-center justify-center rounded-full
                    {{ $depth === 0 ? 'bg-primary ring-4 ring-primary/30' : ($isInactive ? 'bg-red-100 dark:bg-red-900/30 ring-2 ring-red-300 dark:ring-red-700' : 'bg-slate-200 dark:bg-navy-600') }}
                    transition-all duration-200 group-hover:ring-4 group-hover:ring-primary/30">
            @if($isInactive && $depth !== 0)
                {{-- Icône verrou pour les comptes désactivés --}}
                <svg class="size-7 text-red-400 dark:text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            @else
                <svg class="size-7 {{ $depth === 0 ? 'text-white' : 'text-slate-500 dark:text-navy-200' }}"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            @endif
        </div>

        {{-- Badge niveau --}}
        <span class="absolute -top-1 -right-1 flex size-4 items-center justify-center
                     rounded-full bg-accent text-white text-2xs font-bold leading-none">
            {{ $depth }}
        </span>
    </a>

    {{-- Infos utilisateur --}}
    <div class="mt-1 text-center">
        <p class="text-xs font-semibold {{ $isInactive ? 'text-red-400 dark:text-red-500' : 'text-slate-700 dark:text-navy-100' }} line-clamp-1 max-w-[80px]">
            {{ $user->full_name }}
        </p>
        <p class="text-2xs text-slate-400 dark:text-navy-300 line-clamp-1">
            {{ $user->referral_code }}
        </p>
        @if($isInactive)
            <span class="inline-block mt-0.5 rounded px-1 py-0 text-2xs font-medium bg-red-100 text-red-500 dark:bg-red-900/30 dark:text-red-400">
                @lang('locale.inactive_member')
            </span>
        @endif
    </div>

    {{-- Enfants --}}
    @if($depth < 5 && ($filledSlots > 0 || $depth < 5))
        <div class="relative mt-4 flex items-start justify-center gap-4">

            {{-- Ligne verticale descendante --}}
            @if($filledSlots > 0 || $emptySlots > 0)
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-px h-4 bg-slate-300 dark:bg-navy-500 -mt-4"></div>
            @endif

            {{-- Ligne horizontale qui relie les enfants --}}
            @if($filledSlots + $emptySlots > 1)
            <div class="absolute top-0 left-0 right-0 h-px bg-slate-300 dark:bg-navy-500"></div>
            @endif

            {{-- Nœuds enfants remplis --}}
            @foreach($children as $child)
                <div class="flex flex-col items-center">
                    <div class="w-px h-4 bg-slate-300 dark:bg-navy-500"></div>
                    @include('matrix._node', ['node' => $child])
                </div>
            @endforeach

            {{-- Slots vides --}}
            @if($depth < 5)
                @for($i = 0; $i < $emptySlots; $i++)
                <div class="flex flex-col items-center">
                    <div class="w-px h-4 bg-slate-300 dark:bg-navy-500"></div>
                    <div class="flex size-14 items-center justify-center rounded-full
                                border-2 border-dashed border-slate-300 dark:border-navy-500 bg-slate-50 dark:bg-navy-700">
                        <svg class="size-5 text-slate-300 dark:text-navy-400"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <p class="mt-1 text-2xs text-slate-300 dark:text-navy-500">@lang('locale.empty_slot')</p>
                </div>
                @endfor
            @endif

        </div>
    @endif

</div>
