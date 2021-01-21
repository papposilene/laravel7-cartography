<?php

namespace App\Exports;

use App\Country;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CountriesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;
	
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Country::query()->orderBy('cca2', 'asc');
    }
	
    public function headings(): array
    {
        return [
            '#',
            'Aire culturelle',
            'Code CCA2',
            'Drapeau',
            'Nom commun',
            'Nom officiel',
            'Reconnaissance internationale',
            'Pays souverain',
            'Représentation internationale'
        ];
    }
    
    public function map($countries) : array
    {
        $name_fra = json_decode($countries->translations['name_translations']['fr'], true);
        
        return [
            '1',
            $countries->subregion,
            $countries->flag,
            $countries->cca2,
            $name_fra['fra']['common'],
            $name_fra['fra']['official'],
            ($countries->status ? 'Reconnu' : 'Contesté'),
            ($countries->independent ? 'Oui' : 'Non'),
            ($countries->un_member ? 'Membre de l’ONU' : '-'),
            
        ];
    }

}
