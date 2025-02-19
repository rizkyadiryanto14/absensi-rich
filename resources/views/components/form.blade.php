@props([
    'fields' => [
        'nama_lengkap' => true,
        'rfid_tag' => true,
        'alamat' => true,
        'jenis_kelamin' => true,
        'no_hp' => true,
        'nama_orangtua' => true,
        'no_hp_orangtua' => true,
    ]
])

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-4">Tambah Siswa</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg">
            <strong>Oops! Ada kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('siswa.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($fields['nama_lengkap'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
            @endif

            @if ($fields['rfid_tag'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">RFID Tag</label>
                    <input type="text" name="rfid_tag" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
            @endif

            @if ($fields['alamat'])
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Alamat</label>
                    <textarea name="alamat" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required></textarea>
                </div>
            @endif

            @if ($fields['jenis_kelamin'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            @endif

            @if ($fields['no_hp'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nomor HP</label>
                    <input type="text" name="no_hp" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            @endif

            @if ($fields['nama_orangtua'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Orang Tua</label>
                    <input type="text" name="nama_orangtua" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            @endif

            @if ($fields['no_hp_orangtua'])
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nomor HP Orang Tua</label>
                    <input type="text" name="no_hp_orangtua" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            @endif
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('siswa.index') }}" class="bg-red-600 hover:bg-gray-500 text-white px-5 py-2 rounded-lg transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg transition">
                Simpan
            </button>
        </div>
    </form>
</div>
