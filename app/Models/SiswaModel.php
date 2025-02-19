<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $all)
 */
class SiswaModel extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'rfid_tag',
        'nama_lengkap',
        'alamat',
        'jenis_kelamin',
        'no_hp',
        'nama_orangtua',
        'no_hp_orangtua',
        'qr_token',
        'qrcode_path',
    ];

    /**
     * @return HasMany
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(AbsensiModel::class, 'siswa_id', 'id');
    }
}
