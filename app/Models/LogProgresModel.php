<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogProgresModel extends Model
{
    use HasFactory;

    protected $table    = 'log_progres';
    protected $fillable = [
        'uid',
        'lembar_id',
        'notaris_id',
        'bank_id',
        'progres',
        'keterangan',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
