<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDocModel extends Model
{
    use HasFactory;
    protected $table = 'riwayat_dokumen';
    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerjaModel::class, 'lembar_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    protected $fillable = [
        'uid',
        'lembar_id',
        'user_id',
        'status',
        'keterangan',
        'dokumen',

        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function lembar_kerja()
    {
        return $this->belongsTo(LembarKerjaModel::class, 'lembar_id');
    }
}
