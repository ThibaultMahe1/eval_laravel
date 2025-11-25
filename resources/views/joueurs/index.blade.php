<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Liste des joueurs') }}
            </h2>
            @can('gerer-joueurs')
                <a href="{{ route('joueurs.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                    {{ __('Créer un joueur') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @if($joueursParCategorie->isEmpty())
                <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg dark:text-gray-100">
                    {{ __("Aucun joueur n'a été trouvé.") }}
                </div>
            @else
                @foreach($joueursParCategorie as $categorie => $equipes)
                    <div class="mb-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="pb-2 mb-4 text-lg font-bold border-b">{{ __('Catégorie : ') }} {{ $categorie }}</h3>

                            <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
                                @foreach($equipes as $nomEquipe => $joueurs)
                                    <div style="flex: 1 1 calc(50% - 2rem); min-width: 300px;">
                                        <h4 class="mb-3 text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $nomEquipe }}</h4>
                                                                                <div class="overflow-x-auto border rounded-lg dark:border-gray-700">
                                        <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300 {{ auth()->user()->can('gerer-joueurs') ? 'w-1/3' : 'w-1/2' }}">
                                                        {{ __('Nom') }}
                                                    </th>
                                                    <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300 {{ auth()->user()->can('gerer-joueurs') ? 'w-1/3' : 'w-1/2' }}">
                                                        {{ __('Prénom') }}
                                                    </th>
                                                    @can('gerer-joueurs')
                                                        <th scope="col" class="w-1/3 px-4 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">
                                                            {{ __('Actions') }}
                                                        </th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                @foreach($joueurs as $joueur)
                                                    @php
                                                        $canViewDetails = auth()->user()->can('gerer-joueurs') || auth()->user()->can('saisir-resultats');
                                                    @endphp
                                                    <tr
                                                        @if($canViewDetails) onclick="window.location='{{ route('joueurs.show', $joueur) }}'" @endif
                                                        class="border-b dark:border-gray-700 @if($canViewDetails) cursor-pointer transition-transform duration-200 hover:scale-[1.01] hover:bg-gray-50 dark:hover:bg-gray-700 @endif"
                                                    >
                                                        <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $joueur->nom }}
                                                        </td>
                                                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $joueur->prenom }}
                                                        </td>
                                                        @can('gerer-joueurs')
                                                            <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap" onclick="event.stopPropagation()">
                                                                <a href="{{ route('joueurs.edit', $joueur) }}" class="mr-3 text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">{{ __('Modifier') }}</a>
                                                                <form action="{{ route('joueurs.destroy', $joueur) }}" method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce joueur ?') }}')">
                                                                        {{ __('Supprimer') }}
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        @endcan
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
