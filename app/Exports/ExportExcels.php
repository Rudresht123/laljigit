<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;


class ExportExcels implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $query;
    protected $columns ;
    protected $excelColumn;

    // Constructor to inject the query object
    public function __construct($query,$columns,$excelColumn)
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->excelColumn = $excelColumn;
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
        $columnsArray = [];
        if (is_iterable($this->excelColumn)) {
            foreach ($this->excelColumn as $excelColumn) {
                if (in_array($excelColumn->column_name, $this->columns)) {
                    $columnsArray[] = $excelColumn->excelcolumn_name;
                }
            }
        }
        return $columnsArray;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4CAF50']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
    /**
     * Dynamically calculate column widths
     */
    public function columnWidths(): array
    {
        $columnWidths = [];
        $columns = range('A', 'Z'); // Extend this range for more columns

        $headings = $this->headings();
        $data = $this->collection();

        foreach ($headings as $index => $heading) {
            $maxLength = strlen($heading);

            foreach ($data as $row) {
                $value = $row->{$this->columns[$index]} ?? '';
                $maxLength = max($maxLength, strlen($value));
            }

            $columnWidths[$columns[$index]] = $maxLength + 5; // Add padding
        }

        return $columnWidths;
    }
    /**
     * Map each row to the desired format for Excel
     */
    public function map($row): array
    {
        $columnsData = [];
    
        foreach ($this->columns as $column) {
            $columnsData[$column] = $row->$column ?? ''; 
        }
        if (in_array('office_id', $this->columns)) {
            $columnsData['office_id'] = $row->office->office_name ?? '';
        }
    
        if (in_array('category_id', $this->columns)) {
            $columnsData['category_id'] = $row->category->category_name ?? '';
        }
    
        if (in_array('attorney_id', $this->columns)) {
            $columnsData['attorney_id'] = $row->attorney->attorneys_name ?? '';
        }
    
        if (in_array('status', $this->columns)) {
            $columnsData['status'] = $row->statusMain->status_name ?? '';
        }
    
        if (in_array('sub_status', $this->columns)) {
            $columnsData['sub_status'] = $row->subStatus->substatus_name ?? '';
        }
    
        if (in_array('deal_with', $this->columns)) {
            $columnsData['deal_with'] = $row->dealWith->dealler_name ?? 'NA';
        }
    
        if (in_array('financial_year', $this->columns)) {
            $columnsData['financial_year'] = $row->financialYear->financial_session ?? 'NA';
        }
    
        if (in_array('consultant', $this->columns)) {
            $columnsData['consultant'] = $row->Clientonsultant->consultant_name ?? 'NA';
        }
    
        if (in_array('client_remarks', $this->columns)) {
            $columnsData['client_remarks'] = $row->clientRemark->client_remarks ?? 'NA';
        }
    
        if (in_array('remarks', $this->columns)) {
            $columnsData['remarks'] =$item->remarksMain->remarks_name ?? 'NA';
        }
    
        return $columnsData;
    }
    

}