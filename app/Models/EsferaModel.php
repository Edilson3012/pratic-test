<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsferaModel extends Model
{
    use HasFactory;

    // informando que a chave primária será uma string e não mais um inteiro
    public $keyType = 'string';
    public $timestamps = true;
}
