<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_users',
        'total_tabungan',
        'pengeluaran', 
        'penghasilan',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}