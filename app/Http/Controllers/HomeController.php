<?php

namespace App\Http\Controllers;

use App\Http\Services\ChampionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param ChampionService $championService
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ChampionService $championService)
    {
        //
//        if (!$request->secure() && App::environment() != ('local')) {
//            flash()->error('You are accessing the page via unsecure HTTP. The site will not work for you, unless
//             you use HTTPS.')->important();
//        }
        if(!$championService->loadChampions()) {
            flash()->error('Error loading newest data');
        }

        $champions = $championService->getChampionsAlphabetically();
        $runes = [
            'AC' => 'Arcane Comet',
            'AS' => 'Aftershock',
            'CQ' => 'Conqueror',
            'DH' => 'Dark Harvest',
            'EC' => 'Electrocute',
            'FF' => 'Fleet Footwork',
            'GA' => 'Glacial Augment',
            'GR' => 'Grasp of the Undying',
            'GD' => 'Guardian',
            'HOB' => 'Hail of Blades',
            'KL' => 'Kleptomancy',
            'LT' => 'Lethal tempo',
            'OS' => 'Omnistone',
            'PR' => 'Phase Rush',
            'PRE' => 'Predator',
            'PTA' => 'Press the Attack',
            'SA' => 'Summon Aery'
        ];
        $defaultChamp = 'Amumu';
        $defaultRune = 'AS';//'Aftershock';
        return view('welcome', [
            'champions' => $champions,
            'runes' => $runes,
            'defaultChampion' => $defaultChamp,
            'defaultRune' => $defaultRune
        ]);
    }
}
