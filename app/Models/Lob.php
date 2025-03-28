<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lob extends Model
{
    use HasFactory;
    protected $table = 'lob';
    protected $fillable = [
        'employee_tbl_id',
        'region',
        'site',
        'lob',
        'team_name',
        'project_code',
        'compliance_poc',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_tbl_id','id');
    }
    public function siteName()
{
    return $this->belongsTo(Site::class, 'site'); // Replace 'site_id' with the correct foreign key
}

    
}
