<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    use HasFactory;
    protected $table = 'requirements';
    protected $fillable = [
        'employee_tbl_id',
        'nbi_final_status',
        'nbi_validity_date',
        'nbi_submitted_date',
        'nbi_printed_date',
        'nbi_remarks',
        'nbi_file_name',
        'nbi_last_updated_at',
        'nbi_updated_by',
        // DT Section
        'dt_final_status',
        'dt_results_date',
        'dt_transaction_date',
        'dt_endorsed_date',
        'dt_remarks',
        'dt_file_name',
        'dt_last_updated_at',
        'dt_updated_by',
        // Peme Section
        'peme_file_name',
        'peme_remarks',
        'peme_endorsed_date',
        'peme_results_date',
        'peme_transaction_date',
        'peme_final_status',
        'peme_last_updated_at',
        'peme_updated_by',
        'peme_vendor',
        // SSS Section
        'sss_proof_submitted_type',
        'sss_final_status',
        'sss_submitted_date',
        'sss_remarks',
        'sss_number',
        'sss_file_name',
        'sss_last_updated_at',
        'sss_updated_by',
        // PHIC Section
        'phic_submitted_date',
        'phic_final_status',
        'phic_proof_submitted_type',
        'phic_remarks',
        'phic_number',
        'phic_file_name',
        'phic_last_updated_at',
        'phic_updated_by',
        // Pagibig Section
        'pagibig_submitted_date',
        'pagibig_final_status',
        'pagibig_proof_submitted_type',
        'pagibig_remarks',
        'pagibig_number',
        'pagibig_file_name',
        'pagibig_last_updated_at',
        'pagibig_updated_by',
        //Tin
        'tin_submitted_date',
        'tin_final_status',
        'tin_proof_submitted_type',
        'tin_remarks',
        'tin_number',
        'tin_file_name',
        'tin_last_updated_at',
        'tin_updated_by',
        // Health Certificate Section
        'health_certificate_validity_date',
        'health_certificate_submitted_date',
        'health_certificate_remarks',
        'health_certificate_file_name',
        'health_certificate_final_status',
        'health_certificate_last_updated_at',
        'health_certificate_updated_by',
        // Occupational Permit Section
        'occupational_permit_validity_date',
        'occupational_permit_submitted_date',
        'occupational_permit_remarks',
        'occupational_permit_file_name',
        'occupational_permit_final_status',
        'occupational_permit_last_updated_at',
        'occupational_permit_updated_by',
        // OFAC Section
        'ofac_checked_date',
        'ofac_final_status',
        'ofac_remarks',
        'ofac_file_name',
        'ofac_last_updated_at',
        'ofac_updated_by',
        // SAM Section
        'sam_checked_date',
        'sam_final_status',
        'sam_remarks',
        'sam_file_name',
        'sam_last_updated_at',
        'sam_updated_by',
        // OIG Section
        'oig_checked_date',
        'oig_final_status',
        'oig_remarks',
        'oig_file_name',
        'oig_last_updated_at',
        'oig_updated_by',
        // CIBI Section
        'cibi_checked_date',
        'cibi_search_date',
        'cibi_final_status',
        'cibi_remarks',
        'cibi_file_name',
        'cibi_last_updated_at',
        'cibi_updated_by',
        // BGC Section
        'bgc_endorsed_date',
        'bgc_results_date',
        'bgc_results',
        'bgc_final_status',
        'bgc_remarks',
        'bgc_file_name',
        'bgc_last_updated_at',
        'bgc_updated_by',
        'bgc_vendor',
        // BC Section
        'birth_certificate_file_name',
        'birth_certificate_submitted_date',
        'birth_certificate_proof_type',
        'birth_certificate_remarks',
        'birth_certificate_last_updated_at',
        'birth_certificate_updated_by',
        // DBC Section
        'dependent_birth_certificate_file_name',
        'dependent_birth_certificate_submitted_date',
        'dependent_birth_certificate_proof_type',
        'dependent_birth_certificate_remarks',
        'dependent_birth_certificate_last_updated_at',
        'dependent_birth_certificate_updated_by',
        // MC Section
        'marriage_certificate_file_name',
        'marriage_certificate_submitted_date',
        'marriage_certificate_proof_type',
        'marriage_certificate_remarks',
        'marriage_certificate_last_updated_at',
        'marriage_certificate_updated_by',
        // SR Section
        'scholastic_record_file_name',
        'scholastic_record_submitted_date',
        'scholastic_record_proof_type',
        'scholastic_record_remarks',
        'scholastic_record_last_updated_at',
        'scholastic_record_updated_by',
        // PE Section
        'previous_employment_file_name',
        'previous_employment_submitted_date',
        'previous_employment_proof_type',
        'previous_employment_remarks',
        'previous_employment_last_updated_at',
        'previous_employment_updated_by',
        // SD Section
        'supporting_documents_file_name',
        'supporting_documents_submitted_date',
        'supporting_documents_proof_type',
        'supporting_documents_remarks',
        'supporting_documents_last_updated_at',
        'supporting_documents_updated_by',
        // General fields
        'updated_by',
        'created_at',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_tbl_id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function nbiUpdatedBy()
    {
        return $this->belongsTo(User::class, 'nbi_updated_by');
    }

    public function dtUpdatedBy()
    {
        return $this->belongsTo(User::class, 'dt_updated_by');
    }

    public function pemeUpdatedBy()
    {
        return $this->belongsTo(User::class, 'peme_updated_by');
    }

    public function sssUpdatedBy()
    {
        return $this->belongsTo(User::class, 'sss_updated_by');
    }

    public function phicUpdatedBy()
    {
        return $this->belongsTo(User::class, 'phic_updated_by');
    }

    public function pagibigUpdatedBy()
    {
        return $this->belongsTo(User::class, 'pagibig_updated_by');
    }
    public function tinUpdatedBy()
    {
        return $this->belongsTo(User::class, 'tin_updated_by');
    }
    public function healthCertificateUpdatedBy()
    {
        return $this->belongsTo(User::class, 'health_certificate_updated_by');
    }

    public function occupationalPermitUpdatedBy()
    {
        return $this->belongsTo(User::class, 'occupational_permit_updated_by');
    }

    public function ofacUpdatedBy()
    {
        return $this->belongsTo(User::class, 'ofac_updated_by');
    }

    public function samUpdatedBy()
    {
        return $this->belongsTo(User::class, 'sam_updated_by');
    }

    public function oigUpdatedBy()
    {
        return $this->belongsTo(User::class, 'oig_updated_by');
    }

    public function cibiUpdatedBy()
    {
        return $this->belongsTo(User::class, 'cibi_updated_by');
    }

    public function bgcUpdatedBy()
    {
        return $this->belongsTo(User::class, 'bgc_updated_by');
    }

    public function birthCertificateUpdatedBy()
    {
        return $this->belongsTo(User::class, 'birth_certificate_updated_by');
    }

    public function dependentBirthCertificateUpdatedBy()
    {
        return $this->belongsTo(User::class, 'dependent_birth_certificate_updated_by');
    }

    public function marriageCertificateUpdatedBy()
    {
        return $this->belongsTo(User::class, 'marriage_certificate_updated_by');
    }

    public function scholasticRecordUpdatedBy()
    {
        return $this->belongsTo(User::class, 'scholastic_record_updated_by');
    }

    public function previousEmploymentUpdatedBy()
    {
        return $this->belongsTo(User::class, 'previous_employment_updated_by');
    }

    public function supportingDocumentsUpdatedBy()
    {
        return $this->belongsTo(User::class, 'supporting_documents_updated_by');
    }
}
