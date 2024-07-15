<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizationTypes()
    {
        return $this->belongsToMany(OrganizationType::class, 'organization_type_risk');
    }
}
