<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class TicketFileHold implements FromCollection, WithHeadings
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
            'Paused By',
            'Local',
            'Department',
            'Concern',
            'Category',
            'Sub Category',
            'Specific Error',
            'Reason for paused',
            'Location',
            'Date Reported',
            'Date Paused',
            'Number of Days by paused',
        ];
    }
}
