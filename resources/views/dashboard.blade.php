<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Liste des rencontres') }}
            </h2>
            @can('gerer-rencontres')
                <a href="{{ route('rencontres.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                    {{ __('Créer un match') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            @if($rencontresParCategorie->isEmpty())
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __("Aucune rencontre n'a été trouvée.") }}
                    </div>
                </div>
            @else
                <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
                @foreach($rencontresParCategorie as $categorie => $rencontres)
                    <div class="mb-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg" style="flex: 1 1 calc(50% - 2rem); min-width: 300px;">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="pb-2 mb-4 text-lg font-bold border-b">{{ __('Catégorie : ') }} {{ $categorie }}</h3>

                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                                {{ __('Date & Heure') }}
                                            </th>
                                            <th scope="col" class="w-1/3 px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                                {{ __('Domicile') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                                {{ __('Score') }}
                                            </th>
                                            <th scope="col" class="w-1/3 px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase dark:text-gray-300">
                                                {{ __('Extérieur') }}
                                            </th>
                                            @if(auth()->user()->can('gerer-rencontres') || auth()->user()->can('saisir-resultats'))
                                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">
                                                    {{ __('Actions') }}
                                                </th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @foreach($rencontres as $rencontre)
                                            <tr>
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($rencontre->date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($rencontre->heure)->format('H:i') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-900 whitespace-nowrap dark:text-gray-100">
                                                    {{ $rencontre->equipeDomicile->ville }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-bold text-center text-gray-900 whitespace-nowrap dark:text-gray-100">
                                                    @if(is_null($rencontre->score_domicile) || is_null($rencontre->score_exterieur))
                                                        -
                                                    @else
                                                        {{ $rencontre->score_domicile }} - {{ $rencontre->score_exterieur }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-900 whitespace-nowrap dark:text-gray-100">
                                                    {{ $rencontre->equipeExterieur->ville }}
                                                </td>
                                                @if(auth()->user()->can('gerer-rencontres') || auth()->user()->can('saisir-resultats'))
                                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                        @can('gerer-rencontres')
                                                            <a href="{{ route('rencontres.edit', $rencontre) }}" class="mr-3 text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">{{ __('Modifier') }}</a>
                                                            <form action="{{ route('rencontres.destroy', $rencontre) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce match ?') }}')">
                                                                    {{ __('Supprimer') }}
                                                                </button>
                                                            </form>
                                                        @endcan

                                                        @can('saisir-resultats')
                                                            <a href="{{ route('rencontres.edit', $rencontre) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">{{ __('Saisir Score') }}</a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
