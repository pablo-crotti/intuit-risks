<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRiskEmergencyPlanAction extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_risk_id',
        'agent_id',
        'is_information',
        'action',
        'status',
        'response'
    ];

    public function companyRisk()
    {
        return $this->belongsTo(CompanyRisk::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }



}
