<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Category;
use App\Country;
use App\Exports\AddressesExport;
use App\Exports\CategoriesExport;
use App\Exports\CountriesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalAddresses = Address::count();
        $totalCategories = Category::count();
        $totalCountries = Country::count();
        return view('admin.export',
            compact(
                'totalAddresses',
                'totalCategories',
                'totalCountries'
            )
        );
    }

    /**
     * Export the list of all addresses into a Word file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function doc_addresses($type)
    {
        Auth::user()->hasPermissionTo('export');
        
        $filename = 'addresses_' . date('Y-m-d_H-i-s');
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        
        // Settings of the document
        $phpWord->getSettings()->setAutoHyphenation(true);
        $phpWord->getSettings()->setDoNotHyphenateCaps(true);
        
        // Properties of the document
        $properties = $phpWord->getDocInfo();
        $properties->setCreator(setting('app_name', config('app.name', 'Laravel Cartography')));
        $properties->setCompany(setting('app_name', config('app.name', 'Laravel Cartography')));
        $properties->setTitle(__('app.addressesList'));
        $properties->setDescription(__('app.addressesList'));
        
        // Styles for the final document
        $title1Style = __('app.continents');
        $phpWord->addFontStyle(
            $title1Style,
            array(
                'name' => 'Tahoma',
                'size' => 14,
                'bold' => true,
            ),
            array(
                'keepLines' => true,
                'keepNext' => true,
                'spaceAfter' => 1,
                'spaceBefore' => 1,
            )
        );
        $phpWord->addTitleStyle(1, $title1Style);
        $title2Style = __('app.countries');
        $phpWord->addFontStyle(
            $title2Style,
            array(
                'name' => 'Tahoma',
                'size' => 12,
                'bold' => true,
            ),
            array(
                'keepLines' => true,
                'keepNext' => true,
                'spaceAfter' => 1,
                'spaceBefore' => 1,
            )
        );
        $phpWord->addTitleStyle(2, $title2Style);
        $title3Style = __('app.addresses');
        $phpWord->addFontStyle(
            $title3Style,
            array(
                'name' => 'Tahoma',
                'size' => 10,
                'bold' => true,
            ),
            array(
                'keepLines' => true,
                'keepNext' => true,
                'spaceBefore' => 1,
            )
        );
        $phpWord->addTitleStyle(3, $title3Style);
        
        // Create the template of the document
        $section = $phpWord->addSection(array('pageNumberingStart' => 1));
        $header = $section->addHeader();
        $footer = $section->addFooter();
        $footer->addPreserveText('Page {PAGE}/{NUMPAGES}.');
        
        // Retrieve the six continents
        $continents = Country::selectRaw('count(*) AS continents, region')->orderBy('continents', 'desc')->groupBy('region')->get();
        foreach ($continents as $continent)
        {
            // Create the title for this continent, depth 1
            $section->addTitle(__('app.' . $continent->region), 1, $title1Style);
            //echo '<strong>' . __('app.' . $continent->region) . '</strong><br /><br /><br />';
            
            // Retrieve all countries in this continent
            $countries = Country::where('region', $continent->region)->orderBy('cca2', 'asc')->get();
            foreach ($countries as $country)
            {
                if(count($country->hasAddresses) < 1) continue;
                
                // Create the title for this country, depth 2
                $section->addTitle($country->name_eng_common, 2);
                //echo '<strong>' . $country->name_eng_common . '</strong><br /><br />';
                
                
                // Retrieve all the addresses for this country
                foreach ($country->hasAddresses as $address)
                {
                    $section->addTitle($address->name, 3);
                    $section->addText(
                        $address->inCategory->name . '.',
                        array('italic' => true)
                    );
                    ($address->owner ? $section->addText(ucfirst(__('app.formOwner')) . ' : ' . $address->owner . '.') : '');
                    ($address->address ? $section->addText($address->address . '.') : '');
                    ($address->phone ? $section->addText(ucfirst(__('app.formPhone')) . ' : ' . $address->phone . '.') : '');
                    ($address->url ? $section->addLink($address->url, ucfirst(__('app.formUrl')) . ' : ' . $address->url . '.') : '');
                    ($address->latlng ? $section->addText(ucfirst(__('app.formGeoloc')) . ' : ' . $address->latlng . '.') : '');
                    ($address->description ? $section->addText($address->description) : '');
                    $section->addTextBreak();
                    
                    //echo '<strong>' . $address->name . '</strong><br />';
                    //echo '<em>' . $address->inCategory->name . '.</em><br />';
                    //echo ($address->owner ? ucfirst(__('app.formOwner')) . ' : ' . $address->owner . '.<br />' : '');
                    //echo ($address->address ? nl2br($address->address) . '.<br />' : '');
                    //echo ($address->phone ? ucfirst(__('app.formPhone')) . ' : ' . $address->phone . '.<br />' : '');
                    //echo ($address->url ? ucfirst(__('app.formUrl')) . ' : ' . $address->url . '.<br />' : '');
                    //echo ($address->latlng ? ucfirst(__('app.formGeoloc')) . ' : ' . $address->latlng . '.<br />' : '');
                    //echo ($address->decription ? $address->description . '<br /><br />' : '<br /><br />');
                }
            }
            $section->addPageBreak();
        }
        
        // Geenrate the table of contents
        $section->addPageBreak();
        $section->addTOC(null, null, 1, 2);
        
        // Return and download the generated document
        if($type === 'odt')
        {    
            // Saving the document as DOT file...
            header("Content-Description: File Transfer");
            header('Content-Disposition: attachment; filename="' . $filename . '.odt"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
            $xmlWriter->save("php://output");
        }
        elseif($type === 'html')
        {    
            // Saving the document as HTML file...
            header("Content-Description: File Transfer");
            header('Content-Disposition: attachment; filename="' . $filename . '.html"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            $xmlWriter->save("php://output");
        }
        else
        {
            // Saving the document as OOXML file...
            header("Content-Description: File Transfer");
            header('Content-Disposition: attachment; filename="' . $filename . '.html"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $xmlWriter->save("php://output");
        }
    }
    
    /**
     * Export the list of all addresses into an Excel file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function xls_addresses($type)
    {
        Auth::user()->hasPermissionTo('export');
        
        if($type === 'ods')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.ods';
            return (new AddressesExport)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.csv';
            return (new AddressesExport)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.html';
            return (new AddressesExport)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'addresses_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new AddressesExport)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
    
    /**
     * Export the list of all categories into an Excel file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function xls_categories($type)
    {
        Auth::user()->hasPermissionTo('export');
        
        if($type === 'ods')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.ods';
            return (new CategoriesExport)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
            return (new CategoriesExport)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.html';
            return (new CategoriesExport)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'categories_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new CategoriesExport)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }

    /**
     * Export the list of all countries into an Excel file
     *
     * @param  string $type
     * @return \Illuminate\Http\Response
     */
    public function xls_countries($type)
    {
        Auth::user()->hasPermissionTo('export');
        
        if($type === 'ods')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.ods';
            return (new CountriesExport)->download($filename, \Maatwebsite\Excel\Excel::ODS);
        }
        elseif($type === 'csv')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.csv';
            return (new CountriesExport)->forUser($user->uuid)->download($filename, \Maatwebsite\Excel\Excel::CSV);
        }
        elseif($type === 'html')
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.html';
            return (new CountriesExport)->download($filename, \Maatwebsite\Excel\Excel::HTML);
        }
        else
        {
            $filename = 'countries_' . date('Y-m-d_H-i-s') . '.xlsx';
            return (new CountriesExport)->download($filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
