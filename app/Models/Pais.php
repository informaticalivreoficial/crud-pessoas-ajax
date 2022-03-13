<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'pais';

    protected $fillable = ['nome'];

    /**
     * Relacionamentos
    */
    public function pessoas()
    {
        return $this->hasMany(Pessoa::class, 'pais_id', 'id');
    }
}
