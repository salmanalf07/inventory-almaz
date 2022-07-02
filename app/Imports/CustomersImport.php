<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Customer([
            'name' => $row['name_customer'],
            'code' => $row['code'],
            'address' => $row['address'],
            'send_address'  => $row['send_address'],
            'phone'  => $row['phone'],
            'name_pic' => $row['name_pic'],
            'phone_pic' => $row['phone_pic'],
            'distance' => $row['distance'],
            'top' => $row['top'],
            'type_invoice' => $row['type_invoice'],
            'invoice_schedule' => $row['invoice_schedule'],
            'information'  => $row['information'],
        ]);
    }
}
