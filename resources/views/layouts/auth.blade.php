<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

        <!-- CSS Assets -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <!-- Javascript Assets -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
        <script>
            /**
             * THIS SCRIPT REQUIRED FOR PREVENT FLICKERING IN SOME BROWSERS
             */
            localStorage.getItem("_x_darkMode_on") === "true" && document.documentElement.classList.add("dark");
        </script>
    </head>
    <body x-data class="is-header-blur" x-bind="$store.global.documentBody">
        <x-app-preloader></x-app-preloader>

        <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak>
            <div class="fixed top-0 hidden p-6 lg:block lg:px-12">
                <a href="pages-login-2.html#" class="flex items-center space-x-2">
                    <img class="size-12" src="{{ asset('images/app-logo.svg') }}" alt="LOGO" />
                    <p class="text-xl font-semibold uppercase text-slate-700 dark:text-navy-100">
                        MLM
                    </p>
                </a>
            </div>
            <div class="hidden w-full place-items-center lg:grid">
                <div class="w-full max-w-lg p-6">
                    <img class="w-full" x-show="!$store.global.isDarkModeEnabled"
                        src="{{ asset('images/illustrations/dashboard-meet.svg') }}" alt="image" />
                    <img class="w-full" x-show="$store.global.isDarkModeEnabled"
                        src="{{ asset('images/illustrations/dashboard-meet-dark.svg') }}" alt="image" />
                </div>
            </div>
            <main class="flex w-full flex-col items-center bg-white dark:bg-navy-700 lg:max-w-md">
                <div class="flex w-full max-w-sm grow flex-col justify-center p-5">
                    {{ $slot }}

                    <div class="mt-5 flex justify-center text-xs text-slate-400 dark:text-navy-300">
                        <a href="">Privacy Notice</a>
                        <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                        <a href="">Term of service</a>
                    </div>
                </div>
            </main>
        </div>

        <div id="x-teleport-target"></div>
        <script>
            window.addEventListener("DOMContentLoaded", () => Alpine.start());
        </script>
    </body>
</html>