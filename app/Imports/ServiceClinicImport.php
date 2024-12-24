<?php

namespace App\Imports;

use App\Models\ServiceClinic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class ServiceClinicImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        dd(123);
        $skippedRows = [];
        $insertedCount = 0;

        foreach ($collection as $index => $row) {
            if ($index === 0) {
                continue;
            }


            $exists = ServiceClinic::where('name', $row[0])->exists();

            if ($exists) {
                $skippedRows[] = $index + 1;
            } else {
                ServiceClinic::create([
                    'name' => $row[0],
                    'user_id' => Auth::id(),
                    'status' => 'ACTIVE',
                    'service_price' => $row[5],
                ]);

                $insertedCount++;
            }
        }
    }
}
