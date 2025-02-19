<?php

namespace App\Http\Controllers;

use App\Exports\AbsensiExport;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class AbsensiController extends Controller
{
    /**
     * Menampilkan halaman utama absensi.
     */
    public function index()
    {
        return view('absensi.index');
    }

    /**
     * Mengambil data absensi beserta relasi siswa untuk DataTables.
     * Jika parameter start_date dan end_date dikirim, filter data berdasarkan tanggal_absensi.
     */
    public function getData(Request $request)
    {
        $query = AbsensiModel::with('siswa')->select('absensi.*');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_absensi', [$request->start_date, $request->end_date]);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('siswa_nama', function($row) {
                return $row->siswa->nama_lengkap ?? '-';
            })
            ->make(true);
    }

    /**
     * Menerima data QR Code dan membuat record absensi.
     * Endpoint: POST /absensi/scan
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $qrData = $request->input('qr_data');

        $siswa = SiswaModel::where('qr_token', $qrData)->first();

        if (!$siswa) {
            return response()->json([
                'error' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $today = now()->format('Y-m-d');
        $alreadyAbsensi = AbsensiModel::where('siswa_id', $siswa->id)
            ->whereDate('tanggal_absensi', $today)
            ->exists();

        if ($alreadyAbsensi) {
            return response()->json([
                'error' => 'Oops, anda sudah melakukan absensi hari ini.'
            ]);
        }

        $absensi = AbsensiModel::create([
            'siswa_id'        => $siswa->id,
            'tanggal_absensi' => $today,
            'waktu_masuk'     => now(),
            'status'          => 'hadir',
        ]);

        return response()->json([
            'success' => 'Selamat datang, ' . $siswa->nama_lengkap . '! Absensi berhasil.',
            'siswa'   => $siswa,
            'absensi' => $absensi,
        ]);
    }


    /**
     * Mengekspor data absensi ke Excel.
     * Jika terdapat filter tanggal, ekspor hanya data pada rentang tersebut.
     */
    public function exportExcel(Request $request)
    {
        // Menerima parameter tanggal
        $start = $request->input('start_date');
        $end   = $request->input('end_date');

        return Excel::download(new AbsensiExport($start, $end), 'absensi.xlsx');
    }
}
