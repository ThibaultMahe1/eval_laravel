<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Créer un joueur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('joueurs.store') }}">
                        @csrf

                        <!-- Nom -->
                        <div class="mb-4">
                            <x-input-label for="nom" :value="__('Nom')" />
                            <x-text-input id="nom" class="block w-full mt-1" type="text" name="nom" :value="old('nom')" required autofocus />
                            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                        </div>

                        <!-- Prénom -->
                        <div class="mb-4">
                            <x-input-label for="prenom" :value="__('Prénom')" />
                            <x-text-input id="prenom" class="block w-full mt-1" type="text" name="prenom" :value="old('prenom')" required />
                            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Numéro de téléphone -->
                        <div class="mb-4">
                            <x-input-label for="numero_telephone" :value="__('Numéro de téléphone')" />
                            <x-text-input id="numero_telephone" class="block w-full mt-1" type="text" name="numero_telephone" :value="old('numero_telephone')" required />
                            <x-input-error :messages="$errors->get('numero_telephone')" class="mt-2" />
                        </div>

                        <!-- Sexe -->
                        <div class="mb-4">
                            <x-input-label for="sexe" :value="__('Sexe')" />
                            <select id="sexe" name="sexe" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                <option value="">{{ __('Sélectionner') }}</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>{{ __('Masculin') }}</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>{{ __('Féminin') }}</option>
                                <option value="Autre" {{ old('sexe') == 'Autre' ? 'selected' : '' }}>{{ __('Autre') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
                        </div>

                        <!-- Équipe -->
                        <div class="mb-4">
                            <x-input-label for="equipe_id" :value="__('Équipe')" />
                            <select id="equipe_id" name="equipe_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                <option value="">{{ __('Sélectionner une équipe') }}</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" {{ old('equipe_id') == $equipe->id ? 'selected' : '' }}>
                                        {{ $equipe->ville }} ({{ $equipe->categorie }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('equipe_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Créer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
