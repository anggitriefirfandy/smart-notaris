<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarKerjaModel extends Model
{
    use HasFactory;

    protected $table = 'lembar_kerja';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function notaris()
    {
        return $this->belongsTo(NotarisModel::class, 'notaris_id', 'uid');
    }

    public function bank()
    {
        return $this->belongsTo(BankModel::class, 'bank_id', 'uid');
    }
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
        'deleted_at',
    ];

}
