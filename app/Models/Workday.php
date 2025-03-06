<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workday extends Model
{
    use HasFactory;
    protected $table = 'workday_table';
    protected $fillable = [
        'employee_tbl_id',
        'workday_id',
        'ro_feedback',
        'per_findings',
        'completion',
        'contract_findings',
        'contract_remarks',
        'contract_status',
        'contract',
        'with_findings',
        'date_endorsed_to_compliance',
        'return_to_hs_with_findings',
        'last_received_from_hs_with_findings',
        'compliance_remarks'

    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_tbl_id', 'id');
    }
}
