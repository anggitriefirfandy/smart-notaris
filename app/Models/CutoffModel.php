<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutoffModel extends Model
{
    protected $table = 'cutoff';

    protected $fillable = [
        'uid',
        'notaris_id',
        'bank_id',
        'nama',
        'detail_pekerjaan',
        'status',
        'file',
        'waktu_proses',
        'keterangan',
        'created_at',
        'updated_at',
    ];
}
