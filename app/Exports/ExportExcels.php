<?php
namespace App\Exports;

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
            'Attorney Name',
            'Category Name',
            'Office Name',
            'Status',
            'Sub Status',
            'Client Remarks',
            'Remarks',
            'Filing Date'
        ];
    }

    /**
     * Map each row to the desired format for Excel
     */
    public function map($row): array
    {
        return [
            $row->attorney->attorneys_name ?? '',  // Use relationship
            $row->category->category_name ?? '',  // Use relationship
            $row->office->office_name ?? '',      // Use relationship
            $row->status->status_name ?? '',      // Use relationship
            $row->subStatus->substatus_name ?? '', // Use relationship
            $row->clientRemark->client_remarks ?? '', // Use relationship
            $row->remarks->remarks ?? '',         // Use relationship
            $row->filling_date ?? '',             // Direct column from the model
        ];
    }
}

