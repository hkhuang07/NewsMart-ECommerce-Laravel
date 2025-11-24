<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	 public function headings(): array
    {
        return [
            'name',
            'slug',
            'logo',
        ];
    }
    public function map($row): array
    {
        return [
            $row->name,
            $row->slug,
            $row->logo,
        ];
    }
    public function startCell(): string
    {
        return 'A1';
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function collection()
    {
        return Brand::all();
    }
	
}
