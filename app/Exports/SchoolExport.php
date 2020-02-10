<?php

namespace App\Exports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class SchoolExport implements FromCollection, WithHeadings, WithCustomStartCell
{

    use Exportable;

    private $like, $column, $order;

	public function __construct($like, $column, $order)
	{
		$this->like = $like; $this->column = $column; $this->order = $order;
    }
    
    public function headings(): array
    {
        return ['School Name', 'Phone Number', 'Email', 'Address', 'Added On'];
    }
    
    public function collection()
    {
        return School::excelData($this->like, $this->column, $this->order);
    }

    public function startCell(): string
    {
        return 'B2';
    }
}