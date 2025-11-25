<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Liste des équipes') }}
            </h2>
            @can('gerer-equipes')
                <a href="{{ route('equipes.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                    {{ __('Créer une équipe') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-full sm:px-6 lg:px-8">

            @if($equipesParCategorie->isEmpty())
                <div class="p-6 overflow-hidden text-gray-900 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg dark:text-gray-100">
                    {{ __("Aucune équipe n'a été trouvée.") }}
                </div>
            @else
                <div style="display: flex; flex-wrap: wrap; gap: 2rem;">
                @foreach($equipesParCategorie as $categorie => $equipes)
                    <div class="mb-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg" style="flex: 1 1 calc(50% - 2rem); min-width: 300px;">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="pb-2 mb-4 text-lg font-bold border-b">{{ __('Catégorie : ') }} {{ $categorie }}</h3>

                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/3">
                                                {{ __('Ville') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/3">
                                                {{ __('Championnat') }}
                                            </th>
                                                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Licenciés') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('V') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('D') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('N') }}
                                            </th>
                                            @can('gerer-equipes')
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    {{ __('Actions') }}
                                                </th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($equipes as $equipe)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $equipe->ville }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $equipe->championnat }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $equipe->nb_licencies }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400 font-bold">
                                                    {{ $equipe->victoires }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400 font-bold">
                                                    {{ $equipe->defaites }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-bold">
                                                    {{ $equipe->nuls }}
                                                </td>
                                                @can('gerer-equipes')
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('equipes.edit', $equipe) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">{{ __('Modifier') }}</a>
                                                        <form action="{{ route('equipes.destroy', $equipe) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette équipe ?') }}')">
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
                    </div>
                @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
