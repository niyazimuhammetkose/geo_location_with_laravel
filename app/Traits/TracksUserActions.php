<?php

namespace App\Traits;

trait TracksUserActions
{
    protected static function bootTracksUserActions(): void
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check() && in_array('deleted_by', $model->getFillable())) {
                $model->deleted_by = auth()->id();
                $model->saveQuietly();
            }
        });
    }
}
