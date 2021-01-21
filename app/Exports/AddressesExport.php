<?php

namespace App\Exports;

use App\Address;
use App\Country;
use App\Category;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AddressesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Address::query();
    }
	
    public function headings(): array
    {
        return [
            'address_uuid',             // A
            'address_name',             // B
            'address_owner',            // C
            'address_address',          // D
            'address_status',           // E
            'address_description',      // F
            'address_url',              // G
            'address_phone',            // H
            'address_latlng',           // I
            'category_name',            // J
            'country_name',             // K
            'place_id'                  // L
        ];
    }
    
    public function map($addresses) : array
    {
        return [
            $addresses->uuid,
            trim($addresses->name),
            trim($addresses->owner),
            trim($addresses->address),
            ($addresses->status ? 'open' : 'closed'),
            trim($addresses->description),
            trim($addresses->url),
            trim($addresses->phone),
            trim($addresses->latlng),
            Category::where('uuid', $addresses->category_uuid)->pluck('name')[0],
            Country::where('uuid', $addresses->country_uuid)->pluck('cca3')[0],
            trim($addresses->place_id),
        ];
    }

}
