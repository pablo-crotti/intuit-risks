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

    /**
     * The function organizationType() defines a relationship where an instance belongs to an
     * OrganizationType class.
     * 
     * @return The `organizationType()` function is returning a relationship method that defines a
     * belongsTo relationship between the current model and the `OrganizationType` model. This means
     * that the current model belongs to an `OrganizationType` model based on a foreign key
     * relationship.
     */
    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    /**
     * The function "country" defines a relationship where an object belongs to a Country model in PHP.
     * 
     * @return The `country()` function is returning a relationship method that defines a belongsTo
     * relationship between the current model and the `Country` model.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The `administrator` function defines a relationship where a user belongs to an administrator.
     * 
     * @return The `administrator()` function is returning a relationship between the current model and
     * the `User` model using the `belongsTo` method. It specifies that the current model belongs to a
     * user with the foreign key `administrator_id`.
     */
    public function administrator()
    {
        return $this->belongsTo(User::class, 'administrator_id');
    }

    /**
     * The risks function returns a collection of CompanyRisk objects associated with the current
     * object.
     * 
     * @return The `risks()` function is returning a collection of CompanyRisk models associated with
     * the current model using a one-to-many relationship.
     */
    public function risks()
    {
        return $this->hasMany(CompanyRisk::class);
    }

    /**
     * The function `users()` defines a relationship where an instance has many User objects.
     * 
     * @return The code snippet is defining a method named `users` in a class. This method is using
     * Laravel's Eloquent ORM to establish a one-to-many relationship between the current class and the
     * `User` model. It is returning all the users associated with the current class.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}
