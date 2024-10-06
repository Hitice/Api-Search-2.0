<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'telefone',
        'endereco',
        'cidade',
        'cep',
        'data_nascimento',
        'campanha',
    ];

    // Definindo o cast para campos de data
    protected $casts = [
        'data_nascimento' => 'date', // Indica que 'data_nascimento' é uma data
        'created_at' => 'datetime',  // Indica que 'created_at' é um datetime
        'updated_at' => 'datetime',  // Indica que 'updated_at' é um datetime
    ];
}
