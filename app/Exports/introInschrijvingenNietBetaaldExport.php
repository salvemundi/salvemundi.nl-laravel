<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\IntroData;
use App\Enums\paymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class introInschrijvingenNietBetaaldExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return IntroData::orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'firstname',
            'insertion',
            'lastname',
            'email',
        ];
    }

    // here you select the row that you want in the file
    public function map($row): array {
        $fields = [
            $row->id,
            $row->firstname,
            $row->insertion,
            $row->lastname,
            $row->email,
        ];
        return $fields;
    }
}
