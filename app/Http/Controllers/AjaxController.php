<?php

namespace App\Http\Controllers;

use App\Champion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AjaxController extends Controller
{
    public function select() {
        $server = \request()->get('server');
        $username = \request()->get('username');//'Aftershock';
        if($username == null) {
            $result = [
//                'result' => "Error while trying to simulate",
                'result' => 'Username not provided!'
            ];
            return Response::json($result)->setStatusCode(404);
        }
        $data = [
                'server' => $server,
                'username' => $username
            ];
        $json = json_encode($data);
        $path = public_path() . '/sandbox.py';
//        $process = new Process("python3 {pa()} . '/sandbox.py {$json}");
        $process = new Process(['python3',$path, $json]);
        $process->run();

        $result = [];
        if (!$process->isSuccessful()) {
            $result += [
//                'result' => "Error while trying to simulate",
                'result' => $process->getErrorOutput()
            ];
            return Response::json($result)->setStatusCode(404);
//            throw new ProcessFailedException($process);
//            flash("Error occurred while simulating the match")->error()->important();
        }

        $winner = $process->getOutput();
        $parsed = explode("\n", $winner);
        $result += [
            'games' => $parsed[0],
            'placement' => $parsed[1],
            'score' => $parsed[2],
            'kda' => $parsed[3],
            'dmg' => $parsed[4],
            'dmgPer' => $parsed[5],
            'aces' => $parsed[6],
            'worst' => $parsed[7],
            'team_score' => $parsed[8],
            'team_kda' => $parsed[9],
            'team_dmg' => $parsed[10],
            'worst_score' => $parsed[11],
            'worst_kda' => $parsed[12],
            'worst_dmg' => $parsed[13],
            'worst_dmgPer' => $parsed[14]
        ];
//        flash($winner)->success()->important();
        return Response::json($result);
    }
}
