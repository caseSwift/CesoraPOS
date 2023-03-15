<?php

namespace App\View\Components;

use Illuminate\View\Component;


class TableButton extends Component
{
    public $tableNumber;

    public function __construct($tableNumber)
    {
        $this->tableNumber = $tableNumber;
    }

    public function render()
    {
        return view('components.table-button');
    }
}
