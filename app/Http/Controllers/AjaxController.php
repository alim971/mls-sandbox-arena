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
        $defaultChamp = \request()->get('defChamp');
        $defaultRune = \request()->get('defRune');//'Aftershock';
        $defaultItem = \request()->get('defItem');//'Aftershock';
        $defaultKey = 'oJ1mHBDCY8atKtonudHrnncplYQgX0Bq4H0MISG4psj6xzYFtM4DvU5mhb7o7r9W';
        $data = [];
            $data += [
                'key' => \request()->get('key') ?? $defaultKey,
            ];
        for ($i = 1; $i <= 2; $i++) {
            for ($j = 1; $j <= 5; $j++) {
                $name = ($i - 1) . '-' . $j;
                $value = $i . '_' . $j;
                $champ = \request()->get($value);
                $rune = \request()->get($value . '_rune');
                $item = \request()->get($value . '_item');
                $data += [
                    $name => $champ == -1 ? $defaultChamp : $champ,
                    $name . '_rune' => $rune == -1 ? $defaultRune : $rune,
                    $name . '_item' => $rune == -1 ? $defaultItem : $item,
                ];
            }
        }
        $json = json_encode($data);
        $path = public_path() . '/sandbox.py';
//        $process = new Process("python3 {pa()} . '/sandbox.py {$json}");
        $process = new Process(['python',$path, $json]);
        $process->run();

        $result = [];
        if (!$process->isSuccessful()) {
            $result += [
                'result' => $process->getErrorOutput()//"Error while trying to simulate",
//                'result' => $process->getErrorOutput()
            ];
            return Response::json($result)->setStatusCode(404);
//            throw new ProcessFailedException($process);
//            flash("Error occurred while simulating the match")->error()->important();
        }

        $winner = $process->getOutput();
        $result += [
            'result' => $winner
        ];
//        flash($winner)->success()->important();
        return Response::json($result);
    }
}
