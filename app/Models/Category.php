<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

   /**
    * The function "risks" defines a relationship where an instance has many "Risk" objects.
    * 
    * @return The `risks()` function is returning a collection of Risk models associated with the
    * current model using a one-to-many relationship.
    */
    public function risks()
    {
        return $this->hasMany(Risk::class);
    }
}
