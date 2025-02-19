<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white shadow rounded p-4 text-center">
                    <h2 class="text-xl font-semibold">Total Siswa</h2>
                    <p id="totalSiswa" class="text-2xl font-bold mt-2">0</p>
                </div>
                <div class="bg-white shadow rounded p-4 text-center">
                    <h2 class="text-xl font-semibold">Total Absensi</h2>
                    <p id="totalAbsensi" class="text-2xl font-bold mt-2">0</p>
                </div>
                <div class="bg-white shadow rounded p-4 text-center">
                    <h2 class="text-xl font-semibold">Absensi Hari Ini</h2>
                    <p id="absensiHariIni" class="text-2xl font-bold mt-2">0</p>
                </div>
            </div>

            <!-- Grafik Absensi -->
            <div class="bg-white shadow rounded p-4">
                <h2 class="text-xl font-semibold mb-4">Absensi Bulanan (6 Bulan Terakhir)</h2>
                <canvas id="chartAbsensi"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function(){
                // Inisialisasi Chart.js dengan data kosong
                const ctx = document.getElementById('chartAbsensi').getContext('2d');
                let chartAbsensi = new Chart(ctx, {
                    type: 'bar', // bisa diubah sesuai kebutuhan (line, pie, dsb.)
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Jumlah Absensi',
                            data: [],
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Ambil data dashboard via AJAX
                $.ajax({
                    url: "{{ route('admin.dashboard.data') }}",
                    method: 'GET',
                    success: function(data) {
                        // Update statistik
                        $('#totalSiswa').text(data.totalSiswa);
                        $('#totalAbsensi').text(data.totalAbsensi);
                        $('#absensiHariIni').text(data.absensiHariIni);

                        // Update grafik
                        chartAbsensi.data.labels = data.bulanLabels;
                        chartAbsensi.data.datasets[0].data = data.bulanData;
                        chartAbsensi.update();
                    },
                    error: function(err) {
                        console.error('Error fetching dashboard data:', err);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
