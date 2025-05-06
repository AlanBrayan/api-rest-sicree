<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ionos extends Model
{
    
    protected $table = 'email_ionos';

    
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'id',
        'email',
        'password',
        'documento_pdf',
        'id_empleado',
        'api_token',
    ];

    
    public $timestamps = false;
}
