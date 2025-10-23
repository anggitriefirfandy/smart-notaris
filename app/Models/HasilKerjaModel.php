<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKerjaModel extends Model
{
    use HasFactory;
    protected $table = 'hasil_kerja';
    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerjaModel::class, 'lembar_id', 'id');
    }

    public function cabang()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function notaris()
    {
        return $this->belongsTo(NotarisModel::class, 'notaris_id', 'id');
    }
    protected $fillable = [
        'uid',
        'lembar_id',
        'notaris_id',
        'dokumen',
        'status',
        'status_doc',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
