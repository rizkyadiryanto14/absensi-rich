<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiModel extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswa_id',
        'tanggal_absensi',
        'waktu_masuk',
        'waktu_keluar',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaModel::class, 'siswa_id', 'id');
    }
}
