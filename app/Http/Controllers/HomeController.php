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
        $servers = [
            'EUNE' => 'Europe Nordic & East',
            'KR' => 'Korea',
            'JP' => 'Japan',
            'NA' => 'North America',
            'EUW' => 'Europe West',
            'OCE' => 'Oceania',
            'BR' => 'Brazil',
            'LAS' => 'LAS',
            'LAN' => 'LAN',
            'RU' => 'Russia',
            'TR' => 'Turkey',
            'SG' => 'Singapore',
            'ID' => 'Indonesia',
            'PH' => 'Philippines',
            'TW' => 'Taiwan',
            'VN' => 'Vietnam',
            'TH' => 'Thailand'
        ];

        $defaultServer = 'EUNE';//'Aftershock';
        return view('welcome', [
            'servers' => $servers,
            'defaultServer' => $defaultServer,
        ]);
    }
}
