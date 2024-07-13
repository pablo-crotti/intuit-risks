<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRiskReductionPlanTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_risk_id',
        'agent_id',
        'status',
        'action',
        'remark',
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
