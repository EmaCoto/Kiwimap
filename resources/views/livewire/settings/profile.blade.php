<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage; // NECESARIO
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads; // NECESARIO

new class extends Component {
    use WithFileUploads; // NECESARIO

    public string $name = '';
    public string $email = '';
    public $avatar = null; // NUEVO
    public bool $hasAvatar = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->hasAvatar = (bool) Auth::user()->avatar_path;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],

            'avatar' => ['nullable', 'image', 'max:2048'], // NUEVA REGLA
        ]);

        $user->fill([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // LÓGICA DE AVATAR (NUEVO)
        if ($this->avatar) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar_path = $path;
        }
        // FIN LÓGICA DE AVATAR

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
        $this->reset('avatar'); // Limpia el input de archivo
    }

    // NUEVO MÉTODO PARA ELIMINAR EL AVATAR
    public function deleteAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
            $user->save();
        }

        $this->hasAvatar = false; // Actualiza el estado
        $this->dispatch('profile-updated', name: $user->name);


    }
    // FIN NUEVO MÉTODO

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name, email and avatar')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6" enctype="multipart/form-data">

            {{-- BLOQUE DE AVATAR --}}
            <div class="flex items-center gap-4">
                {{-- Preview --}}
                <div class="shrink-0">
                    @php
                        $src = auth()->user()->avatar_url;
                        // Usa un placeholder si no hay URL
                        $placeholder = 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=E5E7EB&color=111827';
                    @endphp
                    <img
                        src="{{ $src ?: $placeholder }}"
                        alt="Avatar"
                        class="h-16 w-16 rounded-full object-cover border"
                    >
                </div>

                {{-- Input de archivo y botones --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">{{ __('Avatar') }}</label>
                    <input type="file" wire:model="avatar" accept="image/*" class="block w-full text-sm border px-1 hover:shadow-sm rounded-md hover:cursor-pointer active:bg-gray-100 bg-gray-200">

                    @error('avatar')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror

                    <div wire:loading wire:target="avatar" class="text-xs text-gray-500 mt-1">
                        {{ __('Uploading...') }}
                    </div>
                </div>
            </div>
            {{-- FIN BLOQUE DE AVATAR --}}

            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
        {{-- <livewire:settings.delete-user-form /> --}}
    </x-settings.layout>
</section>



