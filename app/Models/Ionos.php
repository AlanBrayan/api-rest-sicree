<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ionos extends Model
{
    protected $table = 'email_ionos';
    protected $fillable = [
        'id_ionos',
        'email',
        'password',
        'documento_pdf',
        'id_empleado',
        'api_token',
    ];
}