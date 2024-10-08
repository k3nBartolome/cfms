<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Classes extends Model
{
    use Notifiable;
    use HasFactory;
    protected $casts = [
        'requested_by' => 'array',
        'cancelled_by' => 'array',
        'condition' => 'array',
        'changes' => 'array',
    ];

    protected $fillable = [
        'pushedback_id',
        'within_sla',
        'original_start_date',
        'pushback_start_date_ta',
        'pushback_start_date_wf',
        'requested_start_date_by_wf',
        'start_date_committed_by_ta',
        'supposed_start_date',
        'approved_date',
        'cancelled_date',
        'wfm_date_requested',
        'notice_weeks',
        'external_target',
        'internal_target',
        'notice_days',
        'pipeline_utilized',
        'total_target',
        'pipeline_offered',
        'reason_for_counter_proposal',
        'remarks',
        'status',
        'type_of_hiring',
        'backfill',
        'growth',
        'category',
        'date_range_id',
        'update_status',
        'approved_status',
        'with_erf',
        'approved_by',
        'cancelled_by',
        'created_by',
        'program_id',
        'site_id',
        'erf_number',
        'condition',
        'agreed_start_date',
        'requested_by',
        'changes',
        'wave_no',
        'ta',
        'wf',
        'tr',
        'cl',
        'op',
        'team',
        'start_date',
        'end_date',
        'hire_date',
        'immediate_supervisor_hrid',
        'immediate_supervisor_name',
        'work_setup',
        'offer_target',
        'offer_category_doc',
        'required_program_specific',
        'program_specific_id',
        'basic_pay_training',
        'basic_pay_production',
        'night_differential_training',
        'night_differential_production',
        'bonus_training',
        'bonus_production',
     ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function dateRange()
    {
        return $this->belongsTo(DateRange::class, 'date_range_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function CancelledByUser()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    // @ts-ignore
    public function classes()
    {
        return $this->hasMany(ClassStaffing::class, 'classes_id');
    }
}
