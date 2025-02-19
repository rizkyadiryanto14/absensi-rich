<?php

namespace App\Exports;

use App\Models\AbsensiModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $start;
    protected $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        $query = AbsensiModel::with('siswa');
        if ($this->start && $this->end) {
            $query->whereBetween('tanggal_absensi', [$this->start, $this->end]);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Tanggal Absensi',
            'Waktu Masuk',
            'Waktu Keluar',
            'Status',
        ];
    }

    public function map($absensi): array
    {
        return [
            $absensi->siswa->nama_lengkap ?? '-',
            $absensi->tanggal_absensi,
            $absensi->waktu_masuk,
            $absensi->waktu_keluar,
            $absensi->status,
        ];
    }
}
