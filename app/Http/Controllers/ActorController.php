<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Actor;

class ActorController extends Controller
{
    /**
     * Acció que llegeix els actors i els mostra a la pàgina principal
     */
    public function readActors()
    {
        $name = "Lista de Actores";
        $actors = Actor::all();
        return view("actors.list", ["actors" => $actors, "name" => $name]);
    }

    public function readActorsByDecade($decade = null)
    {
        $decade = $decade ?? request('decade');

        if ($decade) {
            $name = "Lista de Actores por Década: $decade";
            $actors = Actor::whereYear('birthdate', '>=', $decade)
                ->whereYear('birthdate', '<', (int)$decade + 10)
                ->get();
        } else {
            $name = "Lista de Actores";
            $actors = Actor::all();
        }

        return view("actors.list", ["actors" => $actors, "name" => $name]);
    }
}