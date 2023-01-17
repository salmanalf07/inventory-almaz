<?php

namespace App\Imports;

use App\Models\Parts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Parts([
            'cust_id' => $row['customer'],
            'name_local' => $row['code_part'],
            'part_no' => $row['part_no'],
            'part_name' => $row['part_name'],
            'price' => $row['price'],
            'sa_dm' => $row['sa_dm'],
            'qty_pack' => $row['qty_pack'],
            'type_pack' => $row['type_pack'],
            'information' => $row['information'],
        ]);
    }
}
