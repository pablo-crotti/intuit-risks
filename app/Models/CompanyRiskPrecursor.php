<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRiskPrecursor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_risk_id',
        'status',
    ];

    public function companyRisk()
    {
        return $this->belongsTo(CompanyRisk::class);
    }
}
