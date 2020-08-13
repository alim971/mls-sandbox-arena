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
            'GD' => 'Grasp of the Undying',
            'GR' => 'Guardian',
            'HOB' => 'Hail of Blades',
            'KL' => 'Kleptomancy',
            'LT' => 'Lethal tempo',
            'OS' => 'Omnistone',
            'PR' => 'Phase Rush',
            'PRE' => 'Predator',
            'PTA' => 'Press the Attack',
            'SA' => 'Summon Aery'
        ];

        $items = [
            '86' => '50% Crit Bruiser',
            '5' => 'AD On-Hit',
            '16' => 'AP Assassin',
            '6' => 'AP On-Hit',
            '14' => 'Bruiser (Black Cleaver)',
            '13' => 'Bruiser (Trinity)',
            '8' => 'Burst Mage',
            '1' => 'Crit + Lord Dominiks',
            '2' => 'Crit + Mortal Reminder',
            '18' => 'Enchanter (Ardent)',
            '17' => 'Enchanter (Athenes)',
            '9' => 'Freeze Mage',
            '15' => 'Lethality',
            '3' => 'Manamune Crit',
            '10' => 'Protector',
            '7' => 'Scaling Mage',
            '12' => 'Tank (Max. HP)',
            '11' => 'Tank (Resistance)',
            '4' => 'Trinity Manamune',
        ];
        $defaultChamp = 'Amumu';
        $defaultRune = 'AS';//'Aftershock';
        $defaultItem = '12';
        return view('welcome', [
            'champions' => $champions,
            'runes' => $runes,
            'items' => $items,
            'defaultChampion' => $defaultChamp,
            'defaultRune' => $defaultRune,
            'defaultItem' => $defaultItem
        ]);
    }
}
