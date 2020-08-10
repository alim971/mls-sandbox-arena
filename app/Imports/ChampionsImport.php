<?php


namespace App\Imports;

use App\Champion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChampionsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $data = [];
        $index = 0;
        foreach ($rows as $csvLine)
        {

            $data[$index++] = [
                'name' => $csvLine->get('name'),
            ];
        }
        Champion::insertOnDuplicateKey($data);

    }
}
