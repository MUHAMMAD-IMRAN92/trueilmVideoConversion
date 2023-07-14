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

class EmailExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return ['Email', 'Registered_at'];
    }
    public function collection()
    {
        $emails = SubcriptionEmail::select('email', 'created_at')->get();
        $emails->makeHidden('_id');
        return $emails;
    }
    public function map($row): array
    {
        $currentDate = Carbon::now();
        return [
            $row->email,
            $row->created_at->format('Y-m-d'),
        ];
    }
}
