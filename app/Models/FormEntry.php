<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'template_id', 'data'];
    protected $casts = [
        'data' => 'array',
    ];

    public function template(){
        return $this->belongsTo(Templates::class);
    }
}
