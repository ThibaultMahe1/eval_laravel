<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Détails du joueur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                        <div class="pb-10 border-b border-gray-200 dark:border-gray-700 md:border-b-0 md:border-r md:pr-12">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Informations personnelles') }}</h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Nom') }}</p>
                                <p class="text-lg font-semibold">{{ $joueur->nom }}</p>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Prénom') }}</p>
                                <p class="text-lg font-semibold">{{ $joueur->prenom }}</p>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Sexe') }}</p>
                                <p class="text-lg font-semibold">
                                    @if($joueur->sexe == 'M') {{ __('Masculin') }}
                                    @elseif($joueur->sexe == 'F') {{ __('Féminin') }}
                                    @else {{ __('Autre') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Coordonnées') }}</h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Email') }}</p>
                                <p class="text-lg font-semibold">{{ $joueur->email }}</p>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Numéro de téléphone') }}</p>
                                <p class="text-lg font-semibold">{{ $joueur->numero_telephone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 mt-8 border-t dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Équipe') }}</h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Nom de l\'équipe') }}</p>
                            <p class="text-lg font-semibold">{{ $joueur->equipe->ville }} ({{ $joueur->equipe->categorie }})</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('joueurs.index') }}" class="text-gray-600 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            {{ __('Retour à la liste') }}
                        </a>
                        @can('gerer-joueurs')
                            <a href="{{ route('joueurs.edit', $joueur) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ms-4 dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                {{ __('Modifier') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
