<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Ocultar scrollbar pero permitir desplazamiento */
            html, body {
                scrollbar-width: none; /* Firefox */
                -ms-overflow-style: none; /* IE/Edge */
            }
            ::-webkit-scrollbar {
                display: none; /* Chrome, Safari, Opera */
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-[#0d1516]">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-white/5 dark:bg-[#123338]">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Estadísticas')" class="grid">
                    <flux:navlist.item icon="dash" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Información')" class="grid">
                    <flux:navlist.item icon="doctor" :href="route('doctors.index')" :current="request()->routeIs('doctors.index')" wire:navigate>{{ __('Doctores') }}</flux:navlist.item>
                    <flux:navlist.item icon="states" :href="route('states.index')" :current="request()->routeIs('states.index')" wire:navigate>{{ __('Estados') }}</flux:navlist.item>
                    <flux:navlist.item icon="id-card" :href="route('licenses.index')" :current="request()->routeIs('licenses.index')" wire:navigate>{{ __('Licencias') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Herramientas')" class="grid">
                    <flux:navlist.item icon="clock" :href="route('time_difference')" :current="request()->routeIs('time_difference')" wire:navigate>{{ __('Diferencia Horaria') }}</flux:navlist.item>
                    <flux:navlist.item icon="calendar-days" :href="route('attendance.tracker')" :current="request()->routeIs('attendance.tracker')" wire:navigate>{{ __('Asistencia') }}</flux:navlist.item>
                    <flux:navlist.item icon="currency-dollar" :href="route('pricing')" :current="request()->routeIs('pricing')" wire:navigate>{{ __('Lista de precios') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Gestión de usuarios')" class="grid">
                    <flux:navlist.item icon="group-user" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>{{ __('Usuarios') }}</flux:navlist.item>
                    <flux:navlist.item icon="cake" :href="route('users.celebrations')" :current="request()->routeIs('users.celebrations')" wire:navigate>{{ __('Celebraciones') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="book-open-text" href="#" target="_blank">
                {{ __('Documentación') }}
                </flux:navlist.item>
            </flux:navlist>

            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    :avatar="auth()->user()->avatar_url"
                    icon:trailing="chevrons-up-down"
                    circle="true"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>