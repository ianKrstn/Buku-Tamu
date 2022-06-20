<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamuKategori extends Model
{
    use HasFactory;

    protected $fillable = ['tamus_number', 'kategoris_number'];

    public function kategori(){
        return $this->hasOne(Kategori::class, 'number', 'kategoris_number');
    }
}
