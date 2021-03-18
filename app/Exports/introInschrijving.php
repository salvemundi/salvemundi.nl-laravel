<?php

namespace App\Exports;
use App\Models\Intro;
use App\Enums\paymentStatus;
use Illuminate\Database\Eloquent\Builder;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class introInschrijving implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Intro::orderBy('firstName')->with('payment')->whereHas('payment', function (Builder $query) {
            return $query->where('paymentStatus', PaymentStatus::paid);
        })->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'firstName',
            'insertion',
            'lastName',
            'birthday',
            'email',
            'phoneNumber',
            'deleted_at',
            'created_at',
            'updated_at',
            'paymentId',
            'firstNameParent',
            'lastNameParent',
            'addressParent',
            'medicalIssues',
            'specials',
            'phoneNumberParent'
        ];
    }
}
