<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            @can('gerer-rencontres')
                {{ __('Modifier la rencontre') }}
            @else
                {{ __('Saisir le résultat') }}
            @endcan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('rencontres.update', $rencontre) }}">
                        @csrf
                        @method('PUT')

                        @if(auth()->user()->can('gerer-rencontres'))
                            <!-- Partie Admin : Modification des détails du match -->

                            <!-- Equipe Domicile -->
                            <div class="mb-4">
                                <x-input-label for="equipe_domicile_id" :value="__('Équipe Domicile')" />
                                <select id="equipe_domicile_id" name="equipe_domicile_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                    @foreach($equipes as $equipe)
                                        <option value="{{ $equipe->id }}" {{ old('equipe_domicile_id', $rencontre->equipe_domicile_id) == $equipe->id ? 'selected' : '' }}>
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
                                    @foreach($equipes as $equipe)
                                        <option value="{{ $equipe->id }}" {{ old('equipe_exterieur_id', $rencontre->equipe_exterieur_id) == $equipe->id ? 'selected' : '' }}>
                                            {{ $equipe->ville }} ({{ $equipe->categorie }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('equipe_exterieur_id')" class="mt-2" />
                            </div>

                            <!-- Date -->
                            <div class="mb-4">
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="block w-full mt-1" type="date" name="date" :value="old('date', $rencontre->date)" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <!-- Heure -->
                            <div class="mb-4">
                                <x-input-label for="heure" :value="__('Heure')" />
                                <x-text-input id="heure" class="block w-full mt-1" type="time" name="heure" :value="old('heure', \Carbon\Carbon::parse($rencontre->heure)->format('H:i'))" required />
                                <x-input-error :messages="$errors->get('heure')" class="mt-2" />
                            </div>

                        @elseif(auth()->user()->can('saisir-resultats'))
                            <!-- Partie Arbitre : Saisie des scores uniquement -->

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Info Match (Lecture seule) -->
                                <div class="col-span-2 mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $rencontre->equipeDomicile->ville }} vs {{ $rencontre->equipeExterieur->ville }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($rencontre->date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($rencontre->heure)->format('H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Catégorie : {{ $rencontre->categorie }}
                                    </p>
                                </div>

                                <!-- Score Domicile -->
                                <div>
                                    <x-input-label for="score_domicile" :value="__('Score :team', ['team' => $rencontre->equipeDomicile->ville])" />
                                    <x-text-input id="score_domicile" class="block w-full mt-1" type="number" name="score_domicile" :value="old('score_domicile', $rencontre->score_domicile)" min="0" required />
                                    <x-input-error :messages="$errors->get('score_domicile')" class="mt-2" />
                                </div>

                                <!-- Score Extérieur -->
                                <div>
                                    <x-input-label for="score_exterieur" :value="__('Score :team', ['team' => $rencontre->equipeExterieur->ville])" />
                                    <x-text-input id="score_exterieur" class="block w-full mt-1" type="number" name="score_exterieur" :value="old('score_exterieur', $rencontre->score_exterieur)" min="0" required />
                                    <x-input-error :messages="$errors->get('score_exterieur')" class="mt-2" />
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Enregistrer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
