<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotarisModel extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    protected $table    = 'notaris';
    protected $fillable = [
        'uid',
        'nama',
        'jenis_kelamin',
        // 'nama_pemilik_rekening',
        'picture',
        'nomor_notaris',
        'alamat',
        'email',
        'no_hp',
        'telepon',
        'fax',
        'merchant_id',
        'kontak',
        'lock',
        'created_by',
        'created_by_merchant',
        'last_edited_by',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function notaris()
    {
        return $this->belongsTo(NotarisModel::class, 'notaris_id');
    }

}
