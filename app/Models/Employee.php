<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'wd_id',
        'last_name',
        'first_name',
        'middle_name',
        'employee_status',
        'hired_date',
        'hired_month',
        'birthdate',
        'contact_number',
        'email',
        'account_associate',
        'account_type',
        'employment_status',
        'employee_added_by',
        'updated_by',
        'qr_code_path',
        'contract',
        'with_findings',
        'date_endorsed_to_compliance',
        'return_to_hs_with_findings',
        'last_received_from_hs_with_findings'
    ];

    // Relationship with the Requirement model (assuming employee_tbl_id is the foreign key)
    public function requirements()
    {
        return $this->hasMany(Requirements::class, 'employee_tbl_id');
    }
    public function lob()
    {
        return $this->hasMany(Lob::class, 'employee_tbl_id');
    }
    public function workday()
    {
        return $this->hasMany(Workday::class, 'employee_tbl_id');
    }
    // Relationship with the User model (employee_added_by belongs to User)
    public function userAddedBy()
    {
        return $this->belongsTo(User::class, 'employee_added_by'); // Assuming 'employee_added_by' is the foreign key column in the employees table
    }
    // Relationship with the User model (employee_added_by belongs to User)
    public function userUpdatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by'); // Assuming 'employee_added_by' is the foreign key column in the employees table
    }
}
