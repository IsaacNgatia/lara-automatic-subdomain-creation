<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'note',
    ];/**
     * Get the admin that owns the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Admin $admin The admin that owns the note.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);  // Assuming Admin model is named 'Admin'
    }
}