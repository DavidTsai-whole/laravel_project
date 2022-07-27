<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
// WithTitle is 活頁簿名稱, WithHeadings is 資料庫欄位名稱
class OrderByShippedSheet implements FromCollection, WithHeadings, WithTitle
{
    public $isShipped;
    public function __construct($isShipped)
    {
        $this->isShipped = $isShipped;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::where('is_shipped', $this->isShipped)->get();
    }

    public function headings(): array
    {
        return Schema::getColumnListing('orders');
    }

    public function title() : string
    {
        return $this->isShipped ? '已運送' : '尚未運送' ;
    }
}
