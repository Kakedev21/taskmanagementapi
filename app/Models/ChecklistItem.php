<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_completed',
        'checklist_id',
        'position'
    ];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
