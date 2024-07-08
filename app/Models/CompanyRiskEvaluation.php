<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRiskEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_risk_id',
        'author_id',
        'probability',
        'impact'
    ];

    public function companyRisk()
    {
        return $this->belongsTo(CompanyRisk::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    
}
