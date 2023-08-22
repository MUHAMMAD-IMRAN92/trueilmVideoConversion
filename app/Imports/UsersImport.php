<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel ,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!User::where('email', $row['email'])->first()) {
            $user = new User();
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->phone =  $row['phone'];
            $user->password =  Hash::make($row['password']);
            $user->added_by = auth()->user()->_id;
            $user->institute_id =  auth()->user()->_id;
            $user->save();
        }
    }
}
