<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketFileProgress implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'Name',
            'Assign To',
            'Local',
            'Department',
            'Concern',
            'Category',
            'Sub Category',
            'Specific Error',
            'Location',
            'Date Reported',
            'Number of Days',
        ];
    }
}
