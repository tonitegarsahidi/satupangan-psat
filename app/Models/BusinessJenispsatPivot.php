<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BusinessJenispsatPivot extends Pivot
{
    use HasUuids;

    protected $table = 'business_jenispsat';
    public $incrementing = false;
    protected $keyType = 'string';
}
