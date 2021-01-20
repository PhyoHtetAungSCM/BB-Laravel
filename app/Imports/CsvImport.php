<?php

namespace App\Imports;

use App\Post;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

/**
 * System Name: Bulletinboard
 * Module Name: Upload Excel File
 */
class CsvImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Post([
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'create_user_id' => $row['create_user_id'],
            'updated_user_id' => $row['updated_user_id'],
            'deleted_user_id' => $row['deleted_user_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'deleted_at' => $row['deleted_at']
        ]);
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
            '*.create_user_id' => ['required', 'integer'],
            '*.updated_user_id' => ['required', 'integer'],
            '*.deleted_user_id' => ['nullable', 'integer'],
            '*.created_at' => ['required'],
            '*.updated_at' => ['required'],
            '*.deleted_at' => ['nullable'],
        ];
    }
}
