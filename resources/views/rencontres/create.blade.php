<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Créer une rencontre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('rencontres.store') }}">
                        @csrf

                        <!-- Equipe Domicile -->
                        <div class="mb-4">
                            <x-input-label for="equipe_domicile_id" :value="__('Équipe Domicile')" />
                            <select id="equipe_domicile_id" name="equipe_domicile_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                <option value="">{{ __('Sélectionner une équipe') }}</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" {{ old('equipe_domicile_id') == $equipe->id ? 'selected' : '' }}>
                                        {{ $equipe->ville }} ({{ $equipe->categorie }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('equipe_domicile_id')" class="mt-2" />
                        </div>

                        <!-- Equipe Extérieur -->
                        <div class="mb-4">
                            <x-input-label for="equipe_exterieur_id" :value="__('Équipe Extérieur')" />
                            <select id="equipe_exterieur_id" name="equipe_exterieur_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                <option value="">{{ __('Sélectionner une équipe') }}</option>
                                @foreach($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" {{ old('equipe_exterieur_id') == $equipe->id ? 'selected' : '' }}>
                                        {{ $equipe->ville }} ({{ $equipe->categorie }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('equipe_exterieur_id')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block w-full mt-1" type="date" name="date" :value="old('date')" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Heure -->
                        <div class="mb-4">
                            <x-input-label for="heure" :value="__('Heure')" />
                            <x-text-input id="heure" class="block w-full mt-1" type="time" name="heure" :value="old('heure')" required />
                            <x-input-error :messages="$errors->get('heure')" class="mt-2" />
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
