<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'program_id', 'name', 'description', 'program_group', 'user_id', 'site_id', 'created_by', 'updated_by', 'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class, 'program_id');
    }
}
