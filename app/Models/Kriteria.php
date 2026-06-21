<?php
// app/Models/Kriteria.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriterias';
    protected $primaryKey = 'kriteria_id';
    
    protected $fillable = ['kode_kriteria', 'nama_kriteria', 'jenis', 'bobot'];
}