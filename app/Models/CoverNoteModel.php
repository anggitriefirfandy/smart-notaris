<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverNoteModel extends Model
{
    use HasFactory;
    protected $table    = 'covernote';
    protected $fillable = [
        'uid',
        'lembar_id',
        'user_id',
        'status',
        'keterangan',
        'covernote',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
