<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'company_id', 'email', 'phone'];

    /**
     * Retrieve the company associated with the PHP function.
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo{
        return $this->belongsTo(Company::class);
    }
}
