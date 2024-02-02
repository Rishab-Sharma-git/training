<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Configuration;
use Maatwebsite\Excel\Concerns\ToModel;
use Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Fetch all configurations for fields to be imported
        $configurations = Configuration::where('include_in_excel', true)->get();

        // Initialize an array to store mapped data
        $userData = [];

        foreach ($configurations as $config) {
            $columnIndex = $this->getColumnIndex($config->excel_column_name);
            $userData[$config->field_name] = $row[$columnIndex] ?? null;
        }

        // Create a new User model with the mapped data
        return new User([
            'name'     => $userData['name'] ?? null,
            'email'    => $userData['email'] ?? null,
            'password' => Hash::make($userData['password'] ?? null),
        ]);
    }

    /**
     * Helper function to get the column index from the Excel column letter
     *
     * @param string $columnLetter
     * @return int
     */
    private function getColumnIndex($columnLetter)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnLetter) - 1;
    }
}
