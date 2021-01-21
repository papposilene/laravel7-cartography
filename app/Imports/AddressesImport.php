<?php

namespace App\Imports;

use App\Address;
use App\Category;
use App\Country;
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

class AddressesImport implements ToCollection, WithHeadingRow, WithChunkReading
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
            $name           = (!empty($row['address_name']) ? $row['address_name'] : null);
            $owner          = (!empty($row['address_owner']) ? $row['address_owner'] : null);
            $address        = (!empty($row['address_address']) ? $row['address_address'] : null);
            $status         = (!empty($row['address_status']) ? $row['address_status'] : 'open');
            $description    = (!empty($row['address_description']) ? $row['address_description'] : null);
            $phone          = (!empty($row['address_phone']) ? $row['address_phone'] : null);
            $url            = (!empty($row['address_url']) ? $row['address_url'] : null);
            $latlng         = (!empty($row['address_latlng']) ? $row['address_latlng'] : null);
            $category       = (!empty($row['category_name']) ? $row['category_name'] : 'Untitled Category');
            $country        = (!empty($row['country_name']) ? $row['country_name'] : null);
            $place_id       = (!empty($row['place_id']) ? $row['place_id'] : null);
            
            // Search if a category exists with that name
            $inCategory = Category::firstOrCreate([
                'name' => $category,
                'slug' => Str::slug('Untitled Category', '-'),
            ]);
            
            // Search if a country exists with that cca3, english common name
            // or english official name
            $inCountry = Country::where('cca3', 'LIKE', "%$country%")
                ->orWhere('name_eng_common', 'LIKE', "%$country%")
                ->orWhere('name_eng_official', 'LIKE', "%$country%")
                ->firstOrFail();
            Address::updateOrCreate(
                [
                    'address'       => $address,
                    
                ],
                [
                    'name'          => $name,
                    'latlng'        => $latlng,
                    'owner'         => $owner,
                    'address'       => $address,
                    'status'        => ($status === 'open' ? 1 : 0),
                    'description'   => $description,
                    'phone'         => $phone,
                    'url'           => $url,
                    'category_uuid' => $inCategory->uuid,
                    'country_uuid'  => $inCountry->uuid,
                    'place_id'      => $place_id,
            ]);
        }
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
    
}
