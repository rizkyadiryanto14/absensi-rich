<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filter & Export Section -->
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-bold">Daftar Absensi</h1>
                        <div class="flex space-x-2">
                            <input type="date" id="start_date" class="border rounded px-2 py-1" placeholder="Tanggal Awal">
                            <input type="date" id="end_date" class="border rounded px-2 py-1" placeholder="Tanggal Akhir">
                            <button id="filter_btn" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                Filter
                            </button>
                            <button id="export_btn" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                                Export Excel
                            </button>
                        </div>
                    </div>

                    <!-- Datatable -->
                    <x-datatable
                        id="absensi-table"
                        ajaxUrl="{{ route('absensi.getData') }}"
                        :columns="json_encode([
                            ['data' => 'siswa_nama', 'name' => 'siswa_nama'],
                            ['data' => 'tanggal_absensi', 'name' => 'tanggal_absensi'],
                            ['data' => 'waktu_masuk', 'name' => 'waktu_masuk'],
                            ['data' => 'waktu_keluar', 'name' => 'waktu_keluar'],
                            ['data' => 'status', 'name' => 'status'],
                        ])"
                    >
                        <x-slot name="thead">
                            <th>Nama Siswa</th>
                            <th>Tanggal Absensi</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                        </x-slot>
                    </x-datatable>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function(){
                var table = $('#absensi-table').DataTable();

                $('#filter_btn').click(function(){
                    table.ajax.reload();
                });

                $('#export_btn').click(function(){
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    var url = "{{ route('absensi.export') }}";
                    if(start_date && end_date){
                        url += '?start_date=' + start_date + '&end_date=' + end_date;
                    }
                    window.location.href = url;
                });
            });
        </script>
    @endpush
</x-app-layout>
