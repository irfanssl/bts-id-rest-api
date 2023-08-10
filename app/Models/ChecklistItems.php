<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checklist;

class ChecklistItems extends Model
{
    use HasFactory;

    protected $table = 'checklist_item';

    protected $fillable = [
        'item_name',
        'created_by',
        'checklist_id'
    ];

    public function checklist(){
        return $this->hasOne(Checklist::class, 'id', 'checklist_id');
    }
}
