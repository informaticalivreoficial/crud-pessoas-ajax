<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoa';

    protected $fillable = ['nome', 'pais_id', 'nascimento', 'genero'];

    /**
     * Relacionamentos
    */
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    /**
     * Accerssors and Mutators
    */
    public function setNascimentoAttribute($value)
    {
        $this->attributes['nascimento'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    }

    public function setGeneroAttribute($value)
    {
        $this->attributes['genero'] = ($value == "Não informado" ? null : $value);
    }

    public function getGeneroAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return (!empty($value) ? 'Não informado' : $value);
    }

    public function getNascimentoAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function getPaisIdAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        $pais = Pais::where('id', $value)->first();
        return ($value == $pais['id'] ? $pais['nome'] : $value);
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
