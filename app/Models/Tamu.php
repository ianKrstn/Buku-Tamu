<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'timestamp', 'comment'];

    public function tamuKategoris(){
        return $this->hasMany(TamuKategori::class, 'tamus_number', 'number');
    }

    public function hasKategoriByNumber($number){
        if($this->tamuKategoris->whereIn('kategoris_number', $number)->first()){
            return true;
        }
        
        return false;
    }
}
