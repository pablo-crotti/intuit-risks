<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    use HasFactory;

    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'organization_type_risk');
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    
    
}
