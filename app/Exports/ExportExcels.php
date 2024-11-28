<?php

namespace App\Exports;

use App\Models\TrademarkUserModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportExcels implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    // Constructor to inject the query object
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Prepare the data to export
     */
    public function collection()
    {
        return $this->query->get();
    }

    /**
     * Define the headings for Excel columns
     */
    public function headings(): array
    {
        return [
            'Attorney Name', 'Category Name', 'Office Name', 'Status', 'Sub Status', 'Client Remarks', 'Remarks', 'Opposition Status', 'Filing Date'
        ];
    }

    /**
     * Map each row to the desired format for Excel
     */
    public function map($row): array
    {
        return [
            $row->attorney_name,
            $row->category_name,
            $row->office_name,
            $row->status_name,
            $row->sub_status_name,
            $row->client_remark,
            $row->remark,
            $row->opposition_status_name,
            $row->filling_date,
        ];
    }
}

