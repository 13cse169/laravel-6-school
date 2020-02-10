<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class TeacherExport implements FromCollection, WithHeadings, WithCustomStartCell
{
    use Exportable;

    private $like, $column, $order;

	public function __construct($like, $column, $order)
	{
		$this->like = $like; $this->column = $column; $this->order = $order;
    }
    
    public function headings(): array
    {
        return ['School Name', 'Teacher Name', 'Phone Number', 'Email', 'Address', 'Added On'];
    }
    
    public function collection()
    {
        return Teacher::excelData($this->like, $this->column, $this->order);
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
