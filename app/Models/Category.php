<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false; // Para que no intente manejar created_at y updated_at

    protected $fillable = ['name']; 

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
