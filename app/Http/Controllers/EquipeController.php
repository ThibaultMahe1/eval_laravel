<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Rencontre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipeController extends Controller
{
    /**
     * Affiche la liste des équipes.
     */
    public function index(): View
    {
        $equipesParCategorie = Equipe::with(['rencontresDomicile', 'rencontresExterieur'])->get()->groupBy('categorie');

        return view('equipes.index', compact('equipesParCategorie'));
    }

    /**
     * Affiche le formulaire de création d'une équipe.
     */
    public function create(): View
    {
        $this->authorize('gerer-equipes');

        return view('equipes.create');
    }

    /**
     * Enregistre une nouvelle équipe.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('gerer-equipes');
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'championnat' => 'required|string|max:255',
        ]);

        $validated['nb_licencies'] = 0;
        Equipe::create($validated);

        return redirect()->route('equipes.index');
    }

    /**
     * Affiche une équipe spécifique.
     */
    public function show(Equipe $equipe): View
    {
        return view('equipes.show', compact('equipe'));
    }

    /**
     * Affiche le formulaire d'édition d'une équipe.
     */
    public function edit(Equipe $equipe): View
    {
        $this->authorize('gerer-equipes');

        return view('equipes.edit', compact('equipe'));
    }

    /**
     * Met à jour une équipe.
     */
    public function update(Request $request, Equipe $equipe): RedirectResponse
    {
        $this->authorize('gerer-equipes');
        $validated = $request->validate([
            'ville' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'championnat' => 'required|string|max:255',
        ]);

        $equipe->update($validated);

        // Recalculer le nombre de licenciés
        $equipe->nb_licencies = $equipe->joueurs()->count();
        $equipe->save();

        if ($equipe->wasChanged('categorie')) {
            $rencontres = Rencontre::where('equipe_domicile_id', $equipe->id)
                ->orWhere('equipe_exterieur_id', $equipe->id)
                ->get();

            foreach ($rencontres as $rencontre) {
                $adversaire = $rencontre->equipe_domicile_id == $equipe->id
                    ? $rencontre->equipeExterieur
                    : $rencontre->equipeDomicile;

                if ($adversaire && $adversaire->categorie !== $equipe->categorie) {
                    $rencontre->delete();
                }
            }
        }

        return redirect()->route('equipes.index');
    }

    /**
     * Supprime une équipe.
     */
    public function destroy(Equipe $equipe): RedirectResponse
    {
        $this->authorize('gerer-equipes');
        $equipe->delete();

        return redirect()->route('equipes.index');
    }
}
