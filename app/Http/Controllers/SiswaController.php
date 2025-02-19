<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index');
    }

    public function getData(Request $request)
    {
        $data = SiswaModel::select('siswa.*');

        return DataTables::of($data)
            ->addColumn('download_qrcode', function($row) {
                if ($row->qrcode_path) {
                    $url = asset('storage/' . $row->qrcode_path);
                    return '<a href="'. $url .'" target="_blank" class="text-blue-500 underline">Download</a>';
                }
                return '-';
            })
            ->rawColumns(['download_qrcode'])
            ->make(true);
    }


    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'rfid_tag'       => 'required|string',
            'jenis_kelamin'  => 'required|string|in:Laki-laki,Perempuan',
            'alamat'         => 'required|string|max:255',
            'no_hp'          => 'nullable|string|max:15',
            'nama_orangtua'  => 'nullable|string|max:255',
            'no_hp_orangtua' => 'nullable|string|max:15',
        ]);

        if (SiswaModel::where('rfid_tag', $request->rfid_tag)->exists()) {
            return redirect()->back()->with('error', 'Data siswa dengan RFID tersebut sudah ada.');
        }

        $token = Str::random(16);

        $siswa = SiswaModel::create(array_merge($request->all(), [
            'qr_token' => $token,
        ]));

        $qrImageName = 'qr_siswa_' . $siswa->id . '.png';
        QrCode::format('png')
            ->size(500)
            ->margin(4)
            ->generate($siswa->qr_token, storage_path('app/public/qrcodes/' . $qrImageName));

        $siswa->update([
            'qrcode_path' => 'qrcodes/' . $qrImageName,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }
}
