<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait SoftDeleteAttributes
{
    protected function isDeleted(): Attribute
    {
        return new Attribute(
            get: fn () => !is_null($this->deleted_at),
        );
    }
}
