<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Post;

/**
 * System Name: Bulletinboard
 * Module Name: Download Excel File
 */
class XlsxExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::where('status', 1)->get();
    }

    /**
     * Add headings to downloaded file
     *
     * @return heading array
     */
    public function headings(): array // https://docs.laravel-excel.com/3.1/exports/column-formatting.html
    {
        return [
            'Title',
            'Description',
            'Status',
            'Create User',
            'Updated User',
            'Deleted User',
            'Created At',
            'Updated At',
            'Deleted At',
        ];
    }

    /**
     * Map the downloaded data array
     *
     * @param $post
     * @return mapped data array
     */
    public function map($post): array
    {
        return [
            $post->title,
            $post->description,
            $post->status,
            $post->user->name,
            $post->user->name,
            $post->deleted_user,
            Date::dateTimeToExcel($post->created_at),
            Date::dateTimeToExcel($post->updated_at),
            $post->deleted_at ? Date::dateTimeToExcel($post->created_at) : $post->deleted_at,
        ];
    }
    
    /**
     * Column Formatting
     *
     * @return format array
     */
    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
