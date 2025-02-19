<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold">Daftar Siswa</h1>
                        <a href="{{ route('siswa.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            + Tambah Siswa
                        </a>
                    </div>

                    <x-datatable
                        id="siswa-table"
                        ajaxUrl="{{ route('siswa.getData') }}"
                        :columns="json_encode([
                            ['data' => 'id', 'name' => 'id'],
                            ['data' => 'rfid_tag', 'name' => 'rfid_tag'],
                            ['data' => 'nama_lengkap', 'name' => 'nama_lengkap'],
                            ['data' => 'alamat', 'name' => 'alamat'],
                            ['data' => 'jenis_kelamin', 'name' => 'jenis_kelamin'],
                            ['data' => 'no_hp', 'name' => 'no_hp'],
                            ['data' => 'nama_orangtua', 'name' => 'nama_orangtua'],
                            ['data' => 'no_hp_orangtua', 'name' => 'no_hp_orangtua'],
                            ['data' => 'download_qrcode', 'name' => 'download_qrcode', 'orderable' => false, 'searchable' => false]
                        ])"
                    >
                        <x-slot name="thead">
                            <th>ID</th>
                            <th>RFID Tag</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>Nama Orang Tua</th>
                            <th>No HP Orang Tua</th>
                            <th>QR Code</th>
                        </x-slot>
                    </x-datatable>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
