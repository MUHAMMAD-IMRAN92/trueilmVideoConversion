<?php

namespace App\Exports;

use App\Models\SubcriptionEmail;
use App\subscriptions_email;
use Laravel\Cashier\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class EmailExport implements FromCollection, WithMapping, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        $emails = SubcriptionEmail::select('email', 'created_at')->get();
        $emails->makeHidden('_id');
        return $emails;
    }
    public function map($row): array
    {

        return [
            'Email' => $row->email,
            'Registered_at' => $row->created_at->format('Y-m-d'),
        ];
    }
    public function headings(): array
    {
        return [
            'Email' => 'Email',
            'Registered_at' => 'Registered_at',
        ];
    }
}
