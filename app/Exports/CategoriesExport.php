<?php

namespace App\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoriesExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    use Exportable;
    
    public function forUser(string $uuid)
    {
        $this->uuid = $uuid;
        
        return $this;
    }
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Category::query();
    }
	
    public function headings(): array
    {
        return [
            'category_uuid',         // A
            'category_name',         // B
            'category_description',  // C
            'category_icon',         // D
            'category_color',        // E
        ];
    }

}
