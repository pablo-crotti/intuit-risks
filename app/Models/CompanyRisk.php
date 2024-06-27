<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'author_id',
        'risk_id',
        'category_id',
        'name',
        'description',
        'evaluation_frequency'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function evaluations()
    {
        return $this->hasMany(CompanyRiskEvaluation::class)->orderBy('created_at', 'desc');
    }

    public function precursors()
    {
        return $this->hasMany(CompanyRiskPrecursor::class)->orderBy('status', 'desc');
    }


}
