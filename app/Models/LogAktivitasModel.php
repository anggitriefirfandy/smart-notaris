<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitasModel extends Model
{
    use HasFactory;
    protected $table    = 'log_aktivitas';
    protected $fillable = [
        'uid',
        'notaris_id',
        'bank_id',
        'nama_proses',
        'created_by',
        'tanggal_aktivitas',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
