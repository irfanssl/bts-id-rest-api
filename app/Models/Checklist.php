<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChecklistItems;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklist';

    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function checklistItems(){
        return $this->hasMany(ChecklistItems::class);
    }
}
