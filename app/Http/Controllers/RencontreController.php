<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Rencontre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RencontreController extends Controller
{
    /**
     * Affiche la liste des rencontres.
     */
    public function index(): View
    {
        $rencontresParCategorie = Rencontre::with(['equipeDomicile', 'equipeExterieur'])
            ->get()
            ->groupBy('categorie');

        return view('dashboard', compact('rencontresParCategorie'));
    }

    /**
     * Affiche le formulaire de création d'une rencontre.
     */
    public function create(): View
    {
        $this->authorize('gerer-rencontres');
        $equipes = Equipe::all();

        return view('rencontres.create', compact('equipes'));
    }

    /**
     * Enregistre une nouvelle rencontre.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('gerer-rencontres');
        $validated = $request->validate([
            'equipe_domicile_id' => 'required|exists:equipes,id|different:equipe_exterieur_id',
            'equipe_exterieur_id' => 'required|exists:equipes,id',
            'date' => 'required|date',
            'heure' => 'required',
        ]);

        /** @var \App\Models\Equipe $equipeDomicile */
        $equipeDomicile = Equipe::findOrFail($validated['equipe_domicile_id']);
        /** @var \App\Models\Equipe $equipeExterieur */
        $equipeExterieur = Equipe::findOrFail($validated['equipe_exterieur_id']);

        if ($equipeDomicile->categorie !== $equipeExterieur->categorie) {
            return back()->withErrors(['equipe_exterieur_id' => 'Les deux équipes doivent être de la même catégorie.'])->withInput();
        }

        $validated['categorie'] = $equipeDomicile->categorie;

        // Les scores sont initialement nuls
        Rencontre::create($validated);

        return redirect()->route('rencontres.index');
    }

    /**
     * Affiche une rencontre spécifique.
     */
    public function show(Rencontre $rencontre): View
    {
        return view('rencontres.show', compact('rencontre'));
    }

    /**
     * Affiche le formulaire d'édition d'une rencontre.
     */
    public function edit(Rencontre $rencontre): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (! $user->can('gerer-rencontres') && ! $user->can('saisir-resultats')) {
            abort(403);
        }
        $equipes = Equipe::all();

        return view('rencontres.edit', compact('rencontre', 'equipes'));
    }

    /**
     * Met à jour une rencontre.
     */
    public function update(Request $request, Rencontre $rencontre): RedirectResponse
    {
        $user = $request->user();

        if ($user->can('gerer-rencontres')) {
            // L'admin peut modifier les détails du match mais PAS les scores
            $validated = $request->validate([
                'equipe_domicile_id' => 'required|exists:equipes,id|different:equipe_exterieur_id',
                'equipe_exterieur_id' => 'required|exists:equipes,id',
                'date' => 'required|date',
                'heure' => 'required',
            ]);

            /** @var \App\Models\Equipe $equipeDomicile */
            $equipeDomicile = Equipe::findOrFail($validated['equipe_domicile_id']);
            /** @var \App\Models\Equipe $equipeExterieur */
            $equipeExterieur = Equipe::findOrFail($validated['equipe_exterieur_id']);

            if ($equipeDomicile->categorie !== $equipeExterieur->categorie) {
                return back()->withErrors(['equipe_exterieur_id' => 'Les deux équipes doivent être de la même catégorie.'])->withInput();
            }

            $validated['categorie'] = $equipeDomicile->categorie;

            $rencontre->update($validated);
        } elseif ($user->can('saisir-resultats')) {
            // L'arbitre peut modifier UNIQUEMENT les scores
            $validated = $request->validate([
                'score_domicile' => 'required|integer|min:0',
                'score_exterieur' => 'required|integer|min:0',
            ]);
            $rencontre->update($validated);
        } else {
            abort(403);
        }

        return redirect()->route('rencontres.index');
    }

    /**
     * Supprime une rencontre.
     */
    public function destroy(Rencontre $rencontre): RedirectResponse
    {
        $this->authorize('gerer-rencontres');
        $rencontre->delete();

        return redirect()->route('rencontres.index');
    }
}
