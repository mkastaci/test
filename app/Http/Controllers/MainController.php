<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
// use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function homeAction()
    {
        // J'exécute la requête SQL sur la base de données configurées dans le fichier de configuration .env
        // $videogameList = DB::select('SELECT * FROM `videogame`');

        // Je demande à Eloquent de récupérer tous les résultats de la table associée à mon model Videogame
        $videogameList = Videogame::all();

        return view(
            'home',
            [
                'videogameList' => $videogameList
            ]
        );
    }
}
