<?php

namespace App\Exports;

use App\Models\School;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostExport implements FromCollection {

	private $like;
	private $column;
	private $order;

	public function __construct($like, $column, $order)
	{
		$this->like = $like; $this->column = $column; $this->order = $order;
	}

  	public function collection() {

		return School::getlist($this->like, $this->column, $this->order, '', '');

  	}
}
