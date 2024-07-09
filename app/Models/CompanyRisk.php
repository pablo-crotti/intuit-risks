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
        'evaluation_frequency',
        'responsible_id'
    ];

    /**
     * The function "company" defines a relationship where an object belongs to a Company class.
     * 
     * @return The `company()` function is returning a relationship where the current model belongs to
     * a `Company` model.
     */
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

    public function latestEvaluation()
    {
        return $this->hasOne(CompanyRiskEvaluation::class)->latestOfMany();
    }

    public function precursors()
    {
        return $this->hasMany(CompanyRiskPrecursor::class)->orderBy('status', 'desc');
    }
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

}
