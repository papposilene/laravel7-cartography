<?php

namespace App\Imports;

use App\Category;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class CategoriesImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Category::updateOrCreate(
                [
                    'name'          => (!empty($row['category_name']) ? $row['category_name'] : 'Untitled Category'),
                ],
                [
                    'description'   => (!empty($row['category_description']) ? $row['category_description'] : null),
                    'icon'          => (!empty($row['category_icon']) ? $row['category_icon'] : 'fas fa-folder'),
                    'color'         => (!empty($row['category_color']) ? $row['category_color'] : '#b11312'),
                    'slug'          => (!empty($row['category_name']) ? Str::slug($row['category_name'], '-') : Str::slug('Untitled Category', '-')),
            ]);
        }
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
    
}
