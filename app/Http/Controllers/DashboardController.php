<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaModel;
use App\Models\AbsensiModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function data()
    {
        $totalSiswa = SiswaModel::count();

        $totalAbsensi = AbsensiModel::count();

        $today = Carbon::now()->format('Y-m-d');
        $absensiHariIni = AbsensiModel::whereDate('tanggal_absensi', $today)->count();

        $absensiBulanan = AbsensiModel::selectRaw('DATE_FORMAT(tanggal_absensi, "%Y-%m") as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->take(6)
            ->get();

        $bulanLabels = $absensiBulanan->pluck('bulan')->toArray();
        $bulanData   = $absensiBulanan->pluck('total')->toArray();

        return response()->json([
            'totalSiswa'    => $totalSiswa,
            'totalAbsensi'  => $totalAbsensi,
            'absensiHariIni'=> $absensiHariIni,
            'bulanLabels'   => $bulanLabels,
            'bulanData'     => $bulanData,
        ]);
    }
}
