<?php

namespace App\Exports;


use App\Exports\Sheets\OrderByShippedSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class OrdersMultipleExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        foreach ([true, false] as $isShipped) {
            $sheets[] = new OrderByShippedSheet($isShipped);
        }
        return $sheets;
    }

}
