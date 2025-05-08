<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'year',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'faculty_advisor' => 'boolean',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
