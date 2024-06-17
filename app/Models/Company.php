<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organization_type_id',
        'sector',
        'country_id',
        'employees',
        'city',
        'administrator_id'
    ];

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'administrator_id');
    }

    public function risks()
    {
        return $this->hasMany(CompanyRisk::class);
    }
    
}
