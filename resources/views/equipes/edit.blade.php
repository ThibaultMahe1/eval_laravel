<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Modifier l\'équipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('equipes.update', $equipe) }}">
                        @csrf
                        @method('PUT')

                        <!-- Ville -->
                        <div class="mb-4">
                            <x-input-label for="ville" :value="__('Ville')" />
                            <x-text-input id="ville" class="block w-full mt-1" type="text" name="ville" :value="old('ville', $equipe->ville)" required autofocus />
                            <x-input-error :messages="$errors->get('ville')" class="mt-2" />
                        </div>

                        <!-- Catégorie -->
                        <div class="mb-4">
                            <x-input-label for="categorie" :value="__('Catégorie')" />
                            <x-text-input id="categorie" class="block w-full mt-1" type="text" name="categorie" :value="old('categorie', $equipe->categorie)" required />
                            <x-input-error :messages="$errors->get('categorie')" class="mt-2" />
                        </div>

                        <!-- Championnat -->
                        <div class="mb-4">
                            <x-input-label for="championnat" :value="__('Championnat')" />
                            <x-text-input id="championnat" class="block w-full mt-1" type="text" name="championnat" :value="old('championnat', $equipe->championnat)" required />
                            <x-input-error :messages="$errors->get('championnat')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Modifier') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
