<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Joueur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JoueurController extends Controller
{
    /**
     * Affiche la liste des joueurs.
     */
    public function index(): View
    {
        $joueurs = Joueur::with('equipe')->get();
        $joueursParCategorie = $joueurs->groupBy(function (Joueur $joueur) {
            return $joueur->equipe->categorie;
        })->map(function ($joueurs) {
            return $joueurs->groupBy(function (Joueur $joueur) {
                return $joueur->equipe->ville;
            });
        });

        return view('joueurs.index', compact('joueursParCategorie'));
    }

    /**
     * Affiche le formulaire de création d'un joueur.
     */
    public function create(): View
    {
        $this->authorize('gerer-joueurs');
        $equipes = Equipe::all();

        return view('joueurs.create', compact('equipes'));
    }

    /**
     * Enregistre un nouveau joueur.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('gerer-joueurs');
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:joueurs,email',
            'numero_telephone' => 'required|string|max:20',
            'sexe' => 'required|string|in:M,F,Autre', // Exemple de validation, à adapter selon vos besoins
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        $joueur = Joueur::create($validated);

        // Incrémenter le nombre de licenciés de l'équipe
        $joueur->equipe->increment('nb_licencies');

        return redirect()->route('joueurs.index');
    }

    /**
     * Affiche un joueur spécifique.
     */
    public function show(Joueur $joueur): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (! $user->can('gerer-joueurs') && ! $user->can('saisir-resultats')) {
            abort(403);
        }

        return view('joueurs.show', compact('joueur'));
    }

    /**
     * Affiche le formulaire d'édition d'un joueur.
     */
    public function edit(Joueur $joueur): View
    {
        $this->authorize('gerer-joueurs');
        $equipes = Equipe::all();

        return view('joueurs.edit', compact('joueur', 'equipes'));
    }

    /**
     * Met à jour un joueur.
     */
    public function update(Request $request, Joueur $joueur): RedirectResponse
    {
        $this->authorize('gerer-joueurs');
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:joueurs,email,'.$joueur->id,
            'numero_telephone' => 'required|string|max:20',
            'sexe' => 'required|string|in:M,F,Autre',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        $oldEquipeId = $joueur->equipe_id;
        $joueur->update($validated);

        if ($oldEquipeId != $joueur->equipe_id) {
            Equipe::find($oldEquipeId)->decrement('nb_licencies');
            $joueur->equipe->increment('nb_licencies');
        }

        return redirect()->route('joueurs.index');
    }

    /**
     * Supprime un joueur.
     */
    public function destroy(Joueur $joueur): RedirectResponse
    {
        $this->authorize('gerer-joueurs');
        $equipe = $joueur->equipe;
        $joueur->delete();

        if ($equipe) {
            $equipe->decrement('nb_licencies');
        }

        return redirect()->route('joueurs.index');
    }
}
