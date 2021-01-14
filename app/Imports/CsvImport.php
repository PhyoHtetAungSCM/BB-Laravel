<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMapping;

use Carbon\Carbon;
use App\Post;

/**
 * System Name: Bulletinboard
 * Module Name: Upload Excel File
 */
class CsvImport implements ToModel, WithHeadingRow, WithMapping, WithValidation, SkipsOnFailure
{
    /**
     * Importable
     * SkipsFailures
     */
    use Importable, SkipsFailures;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $deleted_at = $row['deleted_at'];

        return new Post([
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'create_user_id' => $row['create_user'],
            'updated_user_id' => $row['updated_user'],
            'deleted_user_id' => $row['deleted_user'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at']
        ]);
    }

    /**
     * Map excel data to set format
     *
     * @param $row
     * @return $row
     */
    public function map($row): array
    {
        if ($row['created_at']) {
            $row['created_at'] = Carbon::createFromFormat('d/m/Y', $row['created_at'])->format('Y-m-d');
        }
        if ($row['updated_at']) {
            $row['updated_at'] = Carbon::createFromFormat('d/m/Y', $row['updated_at'])->format('Y-m-d');
        }
        if ($row['deleted_at']) {
            $row['deleted_at'] = Carbon::createFromFormat('d/m/Y', $row['deleted_at'])->format('Y-m-d');
        }
        return $row;
    }

    /**
     * Rules for excel data
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.title' => ['required', 'string', 'max:255', 'unique:posts,title'],
            '*.description' => ['required', 'string'],
            '*.status' => ['required', 'integer'],
            '*.create_user' => ['required', 'integer'],
            '*.updated_user' => ['required', 'integer'],
            '*.deleted_user' => ['nullable', 'integer'],
            '*.created_at' => ['required', 'date'],
            '*.updated_at' => ['required', 'date'],
            '*.deleted_at' => ['nullable', 'date'],
        ];
    }
}
