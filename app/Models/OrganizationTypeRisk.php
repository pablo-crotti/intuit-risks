<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationTypeRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_type_id',
        'risk_id'
    ];



    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}
