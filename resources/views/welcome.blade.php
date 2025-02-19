<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Rumah Ilmu Chairian</title>
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    <!-- Library html5-qrcode via CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body class="bg-gradient-to-b from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">

<!-- Container Card -->
<div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md text-center relative">
    <!-- Ikon -->
    <div class="mx-auto w-16 h-16 mb-4 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 3a3 3 0 00-3 3v8a3 3 0 003 3h10a3 3 0 003-3V6a3 3 0 00-3-3H5zm4 12H6a1 1 0 010-2h3a1 1 0 010 2zm0-3H6a1 1 0 010-2h3a1 1 0 010 2zm4 3h-1a1 1 0 110-2h1a1 1 0 110 2z" clip-rule="evenodd" />
        </svg>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-1">Absensi</h1>
    <p class="text-sm text-gray-500 mb-6">Arahkan QR Code pada kamera device atau scan kartu RFID.</p>

    <div class="flex justify-center items-center space-x-2 mb-6">
        <button id="btn-qr" class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none">
            Gunakan QR Code
        </button>
        <button id="btn-card" class="transition-colors duration-300 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded focus:outline-none">
            Scan Kartu
        </button>
    </div>

    <p id="instruction" class="text-gray-600 mb-6">

    </p>

    <div id="qr-section" class="mx-auto mb-6" style="width: 300px;"></div>

    <div id="card-section" class="hidden mb-6">
        <p class="text-gray-600">Tolong scan kartu RFID anda pada alat yang tersedia.</p>
    </div>

    <p class="text-xs text-gray-400">
        Absensi Rumah Ilmu Chairian
    </p>

    <div class="absolute -top-5 -right-5 w-20 h-20 bg-blue-100 rounded-full z-[-1]"></div>
    <div class="absolute -bottom-5 -left-5 w-20 h-20 bg-blue-50 rounded-full z-[-1]"></div>
</div>

<div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

<script>
    let html5QrcodeScanner;

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');

        const toast = document.createElement('div');
        toast.classList.add('px-4', 'py-3', 'rounded', 'shadow-md', 'text-white', 'transition', 'transform', 'duration-300');
        toast.style.minWidth = '200px';

        if (type === 'success') {
            toast.classList.add('bg-green-500');
        } else {
            toast.classList.add('bg-red-500');
        }

        toast.innerText = message;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-x-2');
            setTimeout(() => container.removeChild(toast), 300);
        }, 3000);
    }

    function startQrScanner() {
        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-section",
                { fps: 10, qrbox: 300 },
                false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        } else {
            html5QrcodeScanner.clear().then(() => {
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }).catch(error => {
                console.error('Error clearing QR scanner: ', error);
            });
        }
    }

    function stopQrScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(() => {
                console.log('QR Scanner stopped.');
            }).catch(error => {
                console.error('Error stopping QR scanner: ', error);
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        stopQrScanner();
        console.log(`QR Code terdeteksi: ${decodedText}`, decodedResult);

        fetch('/absensi/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_data: decodedText })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Tampilkan notifikasi success
                    showToast(data.success, 'success');
                } else if (data.error) {
                    // Tampilkan notifikasi error
                    showToast(data.error, 'error');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function onScanFailure(error) {
        console.warn(`QR Code scan error: ${error}`);
    }

    document.getElementById('btn-qr').addEventListener('click', function() {
        this.classList.replace('bg-gray-300', 'bg-blue-500');
        this.classList.replace('text-gray-800', 'text-white');
        document.getElementById('btn-card').classList.replace('bg-blue-500', 'bg-gray-300');
        document.getElementById('btn-card').classList.replace('text-white', 'text-gray-800');

        document.getElementById('instruction').textContent = 'Arahkan QR Code pada kamera device.';
        document.getElementById('qr-section').classList.remove('hidden');
        document.getElementById('card-section').classList.add('hidden');
        startQrScanner();
    });

    document.getElementById('btn-card').addEventListener('click', function() {
        this.classList.replace('bg-gray-300', 'bg-blue-500');
        this.classList.replace('text-gray-800', 'text-white');
        document.getElementById('btn-qr').classList.replace('bg-blue-500', 'bg-gray-300');
        document.getElementById('btn-qr').classList.replace('text-white', 'text-gray-800');

        document.getElementById('card-section').classList.remove('hidden');
        document.getElementById('qr-section').classList.add('hidden');
        stopQrScanner();
    });

    document.addEventListener("DOMContentLoaded", function() {
        startQrScanner();
    });
</script>
</body>
</html>
