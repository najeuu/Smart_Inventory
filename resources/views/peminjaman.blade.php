@extends('layout.peminjaman')

@section('title', 'Peminjaman')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal min-h-screen overflow-y-auto">
    {{-- Pastikan div popup ini ada di DOM --}}
    <div id="success-popup"
        class="fixed top-0 left-0 w-full h-full bg-gray-700 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-blue-300 h-16 max-w-xs w-auto p-4 rounded-lg shadow-lg text-center">
            <p class="font-bold text-white mt-2"></p>
        </div>
    </div>

    <div id="error-popup"
        class="fixed top-0 left-0 w-full h-full bg-red-700 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-red-500 h-16 max-w-xs w-auto p-4 rounded-lg shadow-lg text-center">
            <p class="font-bold text-white mt-2"></p>
        </div>
    </div>

    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"> PEMINJAMAN BARANG
        </h1>

        <a href="javascript:void(0)" onclick="openForm()"
            class="bg-blue-300 hover:bg-blue-600 text-white flex items-center justify-center h-[40px] w-[200px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
            <span class="material-symbols-outlined text-[20px] mr-1">add</span>
            <p class="text-[15px]">Ajukan Peminjaman</p>
        </a>

        <div class="rounded-lg border border-gray-300 shadow-sm mb-8 overflow-visible">

    <table class="min-w-full bg-white">
        <thead>
            <tr class="bg-blue-300 text-black uppercase text-sm leading-normal">
                <th class="py-3 px-4 text-center">No</th>
                <th class="py-3 px-4 text-center">Nama Barang</th>
                <th class="py-3 px-4 text-center">Total Barang Dipinjam</th>
                <th class="py-3 px-4 text-center">Kode RFID</th>
                <th class="py-3 px-4 text-center">Tanggal Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $peminjaman)
                <tr class="bg-white border-b hover:bg-blue-50 transition duration-200">
                    <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 text-center">{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</td>
                    <td class="py-3 px-4 text-center">{{ $peminjaman->total_barang }}</td>
                    <td class="py-3 px-4 text-center">{{ $peminjaman->kode_rfid ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">{{ $peminjaman->tanggal_peminjaman }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">Belum ada peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 flex justify-center">
    {{ $data->links() }}
</div>


        <div id="ajukan-peminjaman"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
            <div class="bg-white w-2/3 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500 max-h-screen overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">Form Peminjaman</h2>
                <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjaman-form">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Mahasiswa</label>
                        <input type="text" value="{{ $user->nama_mahasiswa }}" readonly
                            class="w-full px-3 py-2 border rounded-lg bg-gray-100" name="nama_mahasiswa" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">NIM</label>
                        <input type="text" value="{{ $user->nim }}" readonly
                            class="w-full px-3 py-2 border rounded-lg bg-gray-100" name="nim" />
                    </div>

                    <div id="barang-container">
                        </div>

                    <div class="flex justify-between mb-4">
                        <button type="button" onclick="addNewRfidScanItem()"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700">
                            + Tambah Barang (Scan RFID)
                        </button>

                        <div class="flex-1 ml-4">
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Peminjaman</label>
                            <input type="date" name="tanggal_peminjaman"
                                class="w-full px-3 py-2 border rounded-lg" required />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2"
                            onclick="closeForm()">Batal</button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
        <script>
            let activeRfidInput = null;
            let scannedItems = []; // Array untuk menyimpan item yang sudah di-scan

            // Fungsi helper untuk mendapatkan elemen popup
            function getPopupElement(type) {
                const popup = document.getElementById(`${type}-popup`);
                if (!popup) {
                    console.error(`Popup element with ID '${type}-popup' not found in DOM.`);
                    // Fallback to alert if popup is truly missing
                    alert(`Error: Popup element missing. Message: ${message}`);
                    return null;
                }
                return popup;
            }

            function showPopup(type, message) {
                const popup = getPopupElement(type);
                if (!popup) return; // Exit if popup element not found

                const pTag = popup.querySelector('p');
                pTag.textContent = message;

                popup.classList.remove('pointer-events-none', 'opacity-0');
                popup.classList.add('opacity-100');
                setTimeout(() => {
                    popup.classList.remove('opacity-100');
                    popup.classList.add('opacity-0');
                    setTimeout(() => popup.classList.add('pointer-events-none'), 500);
                }, 3000);
            }

            function openForm() {
                const ajukanPeminjaman = document.getElementById('ajukan-peminjaman');
                const formContent = ajukanPeminjaman.querySelector('div');
                ajukanPeminjaman.classList.remove('pointer-events-none', 'opacity-0');
                ajukanPeminjaman.classList.add('opacity-100');
                formContent.classList.remove('-translate-y-full');
                formContent.classList.add('translate-y-0');

                // Clear existing items dan reset
                const barangContainer = document.getElementById('barang-container');
                barangContainer.innerHTML = '';
                scannedItems = []; // Reset scanned items ketika form dibuka
                activeRfidInput = null;

                // Tambahkan item RFID scan pertama
                addNewRfidScanItem();
            }

            function closeForm() {
                const ajukanPeminjaman = document.getElementById('ajukan-peminjaman');
                const formContent = ajukanPeminjaman.querySelector('div');
                formContent.classList.remove('translate-y-0');
                formContent.classList.add('-translate-y-full');
                ajukanPeminjaman.classList.remove('opacity-100');
                ajukanPeminjaman.classList.add('opacity-0');
                setTimeout(() => {
                    ajukanPeminjaman.classList.add('pointer-events-none');
                }, 500);
            }

            function addNewRfidScanItem() {
                // Deaktivasi input sebelumnya
                if (activeRfidInput) {
                    activeRfidInput.classList.remove('border-blue-500', 'bg-blue-50');
                    if (activeRfidInput.value !== '') {
                        activeRfidInput.classList.add('bg-gray-100', 'text-gray-600');
                        activeRfidInput.setAttribute('readonly', 'readonly');
                    } else {
                        // Jika input sebelumnya kosong, tetap aktifkan agar bisa diisi ulang
                        activeRfidInput.classList.add('bg-yellow-100');
                        activeRfidInput.removeAttribute('readonly');
                    }
                }

                const container = document.getElementById('barang-container');
                const newItemDiv = document.createElement('div');
                newItemDiv.classList.add('barang-item', 'flex', 'flex-col', 'gap-2', 'mb-4', 'p-3', 'border', 'rounded-lg', 'bg-gray-50');

                const itemIndex = container.children.length;

                newItemDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-gray-700 font-medium">Scan RFID Tag untuk Barang ${itemIndex + 1}:</label>
                        <button type="button" onclick="removeBarang(this)"
                            class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700">X Hapus</button>
                    </div>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg bg-yellow-100 rfid-scan-input-dynamic"
                        placeholder="Silahkan scan tag RFID" readonly data-index="${itemIndex}">
                    <input type="hidden" name="kode_rfid[]" class="kode-rfid-hidden">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 font-medium mb-1">Nama Barang</label>
                            <input type="text" name="jenis_barang_display[]" class="w-full px-3 py-2 border rounded-lg bg-gray-100" placeholder="Nama barang akan terisi otomatis" readonly>
                            <input type="hidden" name="jenis_barang[]" class="jenis-barang-hidden">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 font-medium mb-1">Total Barang</label>
                            <input type="number" name="total_barang[]" min="1" class="w-full px-3 py-2 border rounded-lg total-barang-input" placeholder="Jumlah" required />
                        </div>
                    </div>
                `;

                container.appendChild(newItemDiv);

                const newRfidInput = newItemDiv.querySelector('.rfid-scan-input-dynamic');
                setActiveRfidInput(newRfidInput);
            }

            function removeBarang(button) {
                const itemDiv = button.closest('.barang-item');
                const hiddenInput = itemDiv.querySelector('.kode-rfid-hidden');
                const rfidCodeToRemove = hiddenInput.value;

                // Hapus dari scannedItems jika ada
                if (rfidCodeToRemove) {
                    scannedItems = scannedItems.filter(item => item !== rfidCodeToRemove);
                }

                const wasActive = activeRfidInput && itemDiv.contains(activeRfidInput);
                itemDiv.remove();

                // Re-index the remaining items' labels and data-index
                const allBarangItems = document.querySelectorAll('.barang-item');
                allBarangItems.forEach((item, index) => {
                    item.querySelector('label').textContent = `Scan RFID Tag untuk Barang ${index + 1}:`;
                    item.querySelector('.rfid-scan-input-dynamic').setAttribute('data-index', index);
                });

                // Tentukan input yang harus aktif setelah penghapusan
                if (wasActive) {
                    const remainingRfidInputs = document.querySelectorAll('.rfid-scan-input-dynamic');
                    if (remainingRfidInputs.length > 0) {
                        let newActiveCandidate = null;
                        for (let i = remainingRfidInputs.length - 1; i >= 0; i--) {
                            if (!remainingRfidInputs[i].hasAttribute('readonly')) {
                                newActiveCandidate = remainingRfidInputs[i];
                                break;
                            }
                        }
                        if (!newActiveCandidate) { // If all are readonly, activate the last one
                            newActiveCandidate = remainingRfidInputs[remainingRfidInputs.length - 1];
                        }
                        setActiveRfidInput(newActiveCandidate);
                    } else {
                        activeRfidInput = null; // No items left
                    }
                } else if (!activeRfidInput && allBarangItems.length > 0) {
                    let lastUnfilledInput = null;
                    for (let i = allBarangItems.length - 1; i >= 0; i--) {
                        const rfidInput = allBarangItems[i].querySelector('.rfid-scan-input-dynamic');
                        if (!rfidInput.hasAttribute('readonly')) {
                            lastUnfilledInput = rfidInput;
                            break;
                        }
                    }
                    if (lastUnfilledInput) {
                        setActiveRfidInput(lastUnfilledInput);
                    }
                }
            }


            function setActiveRfidInput(inputElement) {
                // Deaktivasi input sebelumnya
                if (activeRfidInput && activeRfidInput !== inputElement) {
                    activeRfidInput.classList.remove('border-blue-500', 'bg-blue-50');
                    if (activeRfidInput.value !== '') {
                        activeRfidInput.classList.add('bg-gray-100', 'text-gray-600');
                        activeRfidInput.setAttribute('readonly', 'readonly');
                    } else {
                        activeRfidInput.classList.add('bg-yellow-100');
                        activeRfidInput.removeAttribute('readonly');
                    }
                }

                // Aktifkan input baru
                activeRfidInput = inputElement;
                if (activeRfidInput) {
                    activeRfidInput.classList.add('border-blue-500', 'bg-blue-50');
                    activeRfidInput.classList.remove('bg-yellow-100', 'bg-gray-100', 'text-gray-600');
                    activeRfidInput.removeAttribute('readonly');
                    activeRfidInput.focus();
                }
            }

            // Validasi sebelum submit
            document.getElementById('peminjaman-form').addEventListener('submit', function(e) {
                const totalBarangInputs = document.querySelectorAll('.total-barang-input');
                let isValid = true;

                // Cek apakah ada barang yang belum discan RFID-nya
                const rfidInputs = document.querySelectorAll('.rfid-scan-input-dynamic');
                for (let i = 0; i < rfidInputs.length; i++) {
                    if (rfidInputs[i].value === '') {
                        showPopup('error', `RFID Tag untuk Barang ${i + 1} belum discan!`);
                        isValid = false;
                        rfidInputs[i].focus();
                        break;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                totalBarangInputs.forEach(input => {
                    const value = parseInt(input.value);
                    const max = parseInt(input.getAttribute('max'));

                    if (isNaN(value) || value <= 0) {
                         isValid = false;
                         showPopup('error', 'Jumlah barang harus lebih dari 0.');
                         input.focus();
                    } else if (max && value > max) {
                        isValid = false;
                        showPopup('error', `Jumlah barang tidak boleh melebihi stok yang tersedia (${max})`);
                        input.focus();
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });

            document.addEventListener('DOMContentLoaded', function () {
                // Initial popup handling for session messages
                // This will only run if there are session 'success' or 'error' messages
                @if (session('success') || session('error'))
                    const sessionType = "{{ session('success') ? 'success' : 'error' }}";
                    const sessionMessage = "{{ session('success') ?? session('error') }}";
                    showPopup(sessionType, sessionMessage);
                @endif

                // Socket.IO connection
                const socket = io('http://localhost:8000');

                socket.on('connect', () => {
                    console.log('Connected to Socket.IO server');
                });

                socket.on('disconnect', () => {
                    console.log('Disconnected from Socket.IO server');
                });

                socket.on('tag_scanned', (data) => {
                    const rfidCode = data.tag_uid;
                    console.log('RFID Tag Scanned:', rfidCode);

                    if (!activeRfidInput) {
                        showPopup('error', 'Silakan klik "+ Tambah Barang (Scan RFID)" terlebih dahulu untuk scan tag.');
                        return;
                    }

                    // Cek duplikasi
                    if (scannedItems.includes(rfidCode)) {
                        showPopup('error', 'Tag RFID ini sudah di-scan untuk barang lain di daftar.');
                        return;
                    }

                    // Set value dan fetch data barang
                    activeRfidInput.value = rfidCode;

                    fetch('{{ route('peminjaman.searchByRfid') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ rfid_code: rfidCode })
                    })
                    .then(response => {
                        if (!response.ok) {
                            // If response is not OK, try to read error message from JSON
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(itemData => {
                        showPopup('success', 'Barang terdeteksi: ' + itemData.nama_barang);

                        const currentItemDiv = activeRfidInput.closest('.barang-item');
                        const namaBarangDisplayInput = currentItemDiv.querySelector('input[name="jenis_barang_display[]"]');
                        const jenisBarangHiddenInput = currentItemDiv.querySelector('input[name="jenis_barang[]"]');
                        const totalBarangInput = currentItemDiv.querySelector('input[name="total_barang[]"]');
                        const kodeRfidHiddenInput = currentItemDiv.querySelector('.kode-rfid-hidden');

                        // Set semua nilai
                        namaBarangDisplayInput.value = itemData.nama_barang;
                        jenisBarangHiddenInput.value = itemData.nama_barang;
                        kodeRfidHiddenInput.value = itemData.kode_rfid;

                        // Set default value dan max untuk total barang
                        totalBarangInput.value = 1;
                        totalBarangInput.max = itemData.jumlah_tersedia;

                        // Tambahkan ke scannedItems
                        scannedItems.push(rfidCode);

                        // Kunci input ini (jadikan readonly dan ubah warna)
                        activeRfidInput.classList.add('bg-gray-100', 'text-gray-600');
                        activeRfidInput.setAttribute('readonly', 'readonly');
                        activeRfidInput.classList.remove('border-blue-500', 'bg-blue-50', 'bg-yellow-100');

                        // Setelah scan berhasil dan input dikunci, reset activeRfidInput
                        activeRfidInput = null;
                    })
                    .catch(error => {
                        console.error('Error fetching item details:', error);
                        // Tampilkan pesan error yang lebih informatif
                        let errorMessage = 'Gagal memuat detail barang.';
                        if (error && error.error) {
                            errorMessage = error.error;
                        } else if (error instanceof TypeError && error.message === 'Failed to fetch') {
                            errorMessage = 'Koneksi ke server tidak berhasil. Pastikan server berjalan.';
                        } else if (error instanceof SyntaxError && error.message.includes('JSON')) {
                            errorMessage = 'Respons server tidak valid. Mungkin ada kesalahan di server.';
                        }
                        showPopup('error', errorMessage);

                        // Reset input jika ada kesalahan agar bisa diisi ulang
                        if (activeRfidInput) {
                            activeRfidInput.value = '';
                            activeRfidInput.closest('.barang-item').querySelector('.kode-rfid-hidden').value = '';
                            activeRfidInput.classList.remove('bg-gray-100', 'text-gray-600', 'border-blue-500', 'bg-blue-50');
                            activeRfidInput.classList.add('bg-yellow-100');
                            activeRfidInput.removeAttribute('readonly'); // Pastikan tidak readonly
                            activeRfidInput.focus(); // Fokus kembali ke input ini
                        }
                    });
                });
            });
        </script>
    </div>
</div>
@endsection
