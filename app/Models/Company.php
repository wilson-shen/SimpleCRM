<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'logo', 'website'];

    /**
     * Retrieve the employees associated with the PHP function.
     *
     * @return HasMany
     */
    public function employees(): HasMany{
        return $this->hasMany(Employee::class);
    }
}
