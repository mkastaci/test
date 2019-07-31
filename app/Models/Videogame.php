<?php

namespace App\Models;

// Equivalent au CoreModel mais version Lumen
use Illuminate\Database\Eloquent\Model;

class Videogame extends Model
{
    /**
     * The table associated with the model.
     *
     * Par défaut, Eloquent configure le nom de la table à utiliser à partir du nom de la classe de Model au pluriel. Ici, videogames. Comme notre table s'appelle videogame (sans s), on doit l'indiquer à Eloquent.
     *
     * @var string
     */
    protected $table = 'videogame';

    /**
     * Indicates if the model should be timestamped.
     *
     * Sachant que nous n'avons pas de colonne created_at et updated_at dans notre table videogame, nous désactivons la gestion de ces colonnes
     *
     * @var bool
     */
    public $timestamps = false;
}
