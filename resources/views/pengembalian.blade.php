@extends('layout.pengembalian')

@section('title', 'Pengembalian')

@section('content')
    {{-- Notifikasi --}}
    @if (session('error'))
        <div id="notification" class="bg-red-500 text-white px-4 py-3 rounded-lg mb-4 shadow-md">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div id="notification" class="bg-green-500 text-white px-4 py-3 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col h-full">
        <div class="flex-grow overflow-y-scroll scrollbar-hide">
            {{-- TABEL BARANG DIPINJAM --}}
            <div class="mb-10 bg-white rounded-xl shadow-md p-6 border border-blue-200">
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">📦 Barang yang Dipinjam</h2>

                @if(empty($barangDipinjam))
                    <p class="text-gray-600">Semua barang sudah dikembalikan.</p>
                @else
                    <table class="min-w-full table-auto border-collapse text-sm">
                        <thead>
                            <tr class="bg-blue-300 text-gray-800">
                                <th class="py-3 px-4 text-center font-bold border-b">No</th>
                                <th class="py-3 px-4 text-left font-bold border-b">Nama Barang</th>
                                <th class="py-3 px-4 text-center font-bold border-b">Sisa Belum Kembali</th>
                                <th class="py-3 px-4 text-center font-bold border-b">Tanggal Pinjam</th>
                            </tr>
                        </thead>
                        <tbody class="bg-blue-50">
                            @php $no = 1; @endphp
                            @foreach($barangDipinjam as $index => $group)
                                @foreach($group['items'] as $item)
                                    <tr class="hover:bg-blue-100 transition">
                                        <td class="py-2 px-4 text-center border-b">{{ $no++ }}</td>
                                        <td class="py-2 px-4 text-left border-b">{{ $item['nama_barang'] }}</td>
                                        <td class="py-2 px-4 text-center border-b">{{ $item['total_barang'] }} unit</td>
                                        <td class="py-2 px-4 text-center border-b">{{ $group['tanggal_pinjam'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- FORM PENGEMBALIAN --}}
            @if(!empty($barangDipinjam))
                <form action="{{ route('pengembalian.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @foreach ($barangDipinjam as $groupIndex => $group)
                        <div class="{{ $loop->even ? 'bg-blue-50' : 'bg-white' }} rounded-xl shadow-md p-6 border border-blue-200 mb-6">
                            <h2 class="text-xl font-semibold text-blue-700 mb-4">
                                🗓️ Peminjaman Tanggal: {{ \Carbon\Carbon::parse($group['tanggal_pinjam'])->translatedFormat('d F Y') }}
                            </h2>

                            {{-- Centang Semua Per Tanggal --}}
                            <label class="inline-flex items-center mb-4">
                                <input type="checkbox" class="form-checkbox text-blue-600 mr-2 checkAllGroup" data-group="group-{{ $groupIndex }}">
                                <span class="text-gray-700">Centang semua untuk tanggal ini</span>
                            </label>

                            {{-- Input Barang --}}
                            <div class="space-y-4">
                                @foreach ($group['items'] as $index => $barang)
                                    <div class="bg-white p-4 rounded-lg border">
                                        <label class="block font-medium text-blue-800 mb-1">
                                            {{ $barang['nama_barang'] }}
                                            <span class="text-sm text-gray-600">(Sisa: {{ $barang['total_barang'] }} unit)</span>
                                        </label>
                                        <input type="hidden" name="barang_ids[]" value="{{ $barang['id'] }}">
                                        <input
                                            type="number"
                                            name="jumlah_dikembalikan[]"
                                            min="0"
                                            max="{{ $barang['total_barang'] }}"
                                            data-max="{{ $barang['total_barang'] }}"
                                            data-group="group-{{ $groupIndex }}"
                                            placeholder="Masukkan jumlah yang dikembalikan"
                                            class="jumlah-input mt-1 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        >
                                        <span class="text-red-500 text-sm mt-1 hidden warning-msg">⚠️ Jumlah melebihi sisa yang tersedia.</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Tanggal Pengembalian --}}
                    <div class="bg-white rounded-xl shadow-md p-6 border border-blue-200">
                        <label class="block text-gray-700 font-medium mb-2">Tanggal Pengembalian</label>
                        <input
                            type="date"
                            name="tanggal_pengembalian"
                            required
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        >
                        <button type="submit" id="submitBtn" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                            Kembalikan
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    {{-- SCRIPT VALIDASI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notif = document.getElementById('notification');
            if (notif) {
                setTimeout(() => {
                    notif.style.display = 'none';
                }, 3000);
            }

            const inputTanggal = document.querySelector('input[name="tanggal_pengembalian"]');
            if (inputTanggal) {
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                inputTanggal.value = `${yyyy}-${mm}-${dd}`;
            }

            // Centang Semua per tanggal group
            document.querySelectorAll('.checkAllGroup').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const groupClass = this.dataset.group;
                    document.querySelectorAll(`input[data-group='${groupClass}']`).forEach(input => {
                        input.value = this.checked ? input.max : 0;
                        input.dispatchEvent(new Event('input'));
                    });
                });
            });

            // Validasi langsung jumlah
            const jumlahInputs = document.querySelectorAll('.jumlah-input');
            const submitBtn = document.getElementById('submitBtn');

            jumlahInputs.forEach((input) => {
                input.addEventListener('input', function () {
                    const max = parseInt(this.dataset.max);
                    const warning = this.nextElementSibling;
                    const val = parseInt(this.value) || 0;

                    if (val > max) {
                        warning.classList.remove('hidden');
                        this.classList.add('border-red-500');
                    } else {
                        warning.classList.add('hidden');
                        this.classList.remove('border-red-500');
                    }

                    const adaSalah = Array.from(jumlahInputs).some(i => parseInt(i.value) > parseInt(i.dataset.max));
                    submitBtn.disabled = adaSalah;
                    submitBtn.classList.toggle('opacity-50', adaSalah);
                    submitBtn.classList.toggle('cursor-not-allowed', adaSalah);
                });
            });
        });
    </script>
@endsection
