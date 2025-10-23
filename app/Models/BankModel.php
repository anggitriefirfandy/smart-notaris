<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    use HasFactory;

    protected $table    = 'bank';
    protected $fillable = [
        'uid',
        'nama_bank',
        'alamat',
        'email',
        'no_hp',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function bank()
    {
        return $this->belongsTo(BankModel::class, 'bank_id', 'uid');
    }
    public function bankById()
    {
        return $this->belongsTo(BankModel::class, 'bank_id', 'id');
    }

}
