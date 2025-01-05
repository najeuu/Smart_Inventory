class RegisteredRFIDScanner {
    constructor(rfidInput, namaBarangSelect) {
        this.port = null;
        this.reader = null;
        this.rfidInput = rfidInput;
        this.namaBarangSelect = namaBarangSelect;
        this.isScanning = false;
        this.deviceStatus = 'Closed';
    }

    async openPort(baudRate = 57600, bufferSize = 1024) {
        try {
            this.port = await navigator.serial.requestPort();
            await this.port.open({ baudRate, bufferSize });
            this.reader = this.port.readable?.getReader();
            this.deviceStatus = 'Open';
            return true;
        } catch (error) {
            console.error("Failed to open port:", error);
            return false;
        }
    }

    async closePort() {
        try {
            if (this.reader) {
                await this.reader.releaseLock();
            }
            if (this.port) {
                await this.port.close();
            }
            this.port = null;
            this.reader = null;
            this.deviceStatus = 'Closed';
            return true;
        } catch (error) {
            console.error("Failed to close port:", error);
            return false;
        }
    }

    async readTag() {
        if (!this.reader) return null;

        try {
            const { value, done } = await this.reader.read();
            if (done) return null;

            // Convert the tag data to hex string
            const tagHex = Array.from(value)
                .map(byte => byte.toString(16).padStart(2, '0').toUpperCase())
                .join(' ');

            return tagHex;
        } catch (error) {
            console.error("Error reading tag:", error);
            return null;
        }
    }

    async startScanning() {
        if (this.isScanning || this.deviceStatus !== 'Open') return false;

        this.isScanning = true;
        try {
            const tagHex = await this.readTag();
            if (tagHex) {
                const nim = document.querySelector('input[name="nim"]').value;
                // Check if tag exists in database and get barang details
                const response = await fetch(`/api/check-registered-rfid/${tagHex}?nim=${nim}`);
                const data = await response.json();

                if (data.exists) {
                    this.rfidInput.value = tagHex;

                    // Get the borrowed items list from the table
                    const borrowedItemsTable = document.querySelectorAll('#barang-dipinjam-table tbody tr');
                    const borrowedItems = Array.from(borrowedItemsTable).map(row => ({
                        nama_barang: row.cells[1].textContent,
                        jumlah: parseInt(row.cells[2].textContent)
                    }));

                    // Filter data.barang to only include items that match borrowed items
                    const matchedItems = data.barang.filter(scannedItem =>
                        borrowedItems.some(borrowedItem =>
                            borrowedItem.nama_barang === scannedItem.nama_barang
                        )
                    );

                    if (matchedItems.length > 0) {
                        this.updateNamaBarangOptions(matchedItems);
                        return true;
                    } else {
                        alert('Barang ini tidak tercatat sebagai barang yang dipinjam!');
                        this.rfidInput.value = '';
                        this.namaBarangSelect.innerHTML = '<option value="">Pilih Barang</option>';
                    }
                } else {
                    alert('Kode RFID tidak terdaftar dalam sistem!');
                    this.rfidInput.value = '';
                    this.namaBarangSelect.innerHTML = '<option value="">Pilih Barang</option>';
                }
            }
        } catch (error) {
            console.error("Error during scanning:", error);
        } finally {
            this.isScanning = false;
        }
        return false;
    }

    updateNamaBarangOptions(matchedItems) {
        // Clear existing options
        this.namaBarangSelect.innerHTML = '<option value="">Pilih Barang</option>';

        // Add options only for matched borrowed items
        matchedItems.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.nama_barang} (${item.jumlah} unit)`;
            this.namaBarangSelect.appendChild(option);
        });

        // Enable/disable select based on available options
        this.namaBarangSelect.disabled = matchedItems.length === 0;
    }
}

window.RegisteredRFIDScanner = RegisteredRFIDScanner;
