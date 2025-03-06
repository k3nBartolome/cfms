<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Requirements;
use App\Models\Lob;
use App\Models\Workday;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class EmployeeImport implements ToModel, WithHeadingRow
{
    protected $employeeAddedBy;

    public function __construct($employeeAddedBy)
    {
        $this->employeeAddedBy = $employeeAddedBy;
    }

    public function model(array $row)
    {
        // Start a database transaction to ensure atomic operations
       /*  DB::beginTransaction(); */

        try {
            // Check if the email already exists in the database
            if (!empty($row['email']) && Employee::where('email', $row['email'])->exists()) {
                Log::info('Skipping row due to existing email:', ['email' => $row['email']]);
                return null; // Skip this row
            }

            // Convert Excel serial date values to Y-m-d format
            $row['hired_date'] = $this->excelDateToDateString($row['hired_date'] ?? null);
            $row['birthdate'] = $this->excelDateToDateString($row['birthdate'] ?? null);

            // Validate the row data
            $validator = Validator::make($row, [
                'employee_id' => 'nullable|max:50',
                'workday_id' => 'nullable|string|max:50',
                'last_name' => 'nullable|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'employee_status' => 'nullable|string|max:100',
                'hired_date' => 'nullable|date_format:Y-m-d',
                'hired_month' => 'nullable|string|max:50',
                'birthdate' => 'nullable|date_format:Y-m-d',
                'contact_number' => 'nullable|max:20',
                'email' => 'nullable|email|max:255',
                'account_associate' => 'nullable|string|max:255',
                'account_type' => 'nullable|string|max:100',
                'employment_status' => 'nullable|string|max:100',
                'site' => 'nullable|integer|max:100',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed for row:', ['row' => $row, 'errors' => $validator->errors()->all()]);
                return null; // Skip the invalid row
            }

            // Create the employee record
            $employee = Employee::create([
                'employee_id' => $row['employee_id'],
                'last_name' => $row['last_name'],
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'employee_status' => $row['employee_status'],
                'hired_date' => $row['hired_date'],
                'hired_month' => $row['hired_month'],
                'birthdate' => $row['birthdate'],
                'contact_number' => $row['contact_number'],
                'email' => $row['email'],
                'account_associate' => $row['account_associate'],
                'account_type' => $row['account_type'],
                'employment_status' => $row['employment_status'],
                'employee_added_by' => $this->employeeAddedBy,
            ]);

            // Create related records in Requirements, Lob, and Workday tables
            Requirements::create([
                'employee_tbl_id' => $employee->id,
            ]);

            Lob::create([
                'employee_tbl_id' => $employee->id,
                'site' => $row['site'] ?? null,
            ]);

            Workday::create([
                'employee_tbl_id' => $employee->id,
                'workday_id' => $row['workday_id'] ?? null,
            ]);

            // Commit the transaction
          /*   DB::commit(); */

            Log::info('New employee added:', ['email' => $row['email']]);
            return $employee; // Return the employee model
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Log::error('Error occurred while saving employee:', ['error' => $e->getMessage()]);
            return null;
        }
    }


    /**
     * Convert Excel date serial number to a string date in Y-m-d format
     *
     * @param mixed $excelDate
     * @return string|null
     */
    private function excelDateToDateString($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Convert Excel serial date to DateTime object
            $excelDate = Date::excelToDateTimeObject($excelDate);
            return $excelDate->format('Y-m-d');
        }

        // If already in string format, parse it to Y-m-d
        if ($excelDate && (Carbon::hasFormat($excelDate, 'm/d/Y') || Carbon::hasFormat($excelDate, 'Y-m-d'))) {
            return Carbon::parse($excelDate)->format('Y-m-d');
        }

        return null;
    }
}
