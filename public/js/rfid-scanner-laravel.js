class SerialTransport {
    constructor() {
        this.port = null;
        this.reader = null;
    }

    async open(baudRate = 57600, bufferSize = 1024) {
        try {
            this.port = await navigator.serial.requestPort();
            await this.port.open({ baudRate, bufferSize });
            this.reader = this.port.readable?.getReader({ mode: "byob" });
            return true;
        } catch (error) {
            console.error("Failed to open port:", error);
            return false;
        }
    }

    async close() {
        if (this.reader) {
            await this.reader.releaseLock();
        }
        if (this.port) {
            await this.port.close();
        }
        this.port = null;
        this.reader = null;
    }

    async read(size) {
        if (!this.reader) return null;
        try {
            const { value: bytes } = await this.reader.read(new Uint8Array(size));
            return bytes;
        } catch (error) {
            console.error("Error reading from port:", error);
            return null;
        }
    }

    async write(data) {
        if (!this.port?.writable) return;
        const writer = this.port.writable.getWriter();
        await writer.write(data);
        writer.releaseLock();
    }
}

class RFIDReader {
    constructor(transport) {
        this.transport = transport;
    }

    async inventoryAnswerMode() {
        try {
            const command = new Uint8Array([0x04, 0xFF, 0x01, 0x1B, 0xB4]);
            await this.transport.write(command);

            const firstByte = await this.transport.read(1);
            if (!firstByte?.[0]) return null;

            const dataBytes = await this.transport.read(firstByte[0]);
            if (!dataBytes) return null;

            const frame = new Uint8Array(firstByte.length + dataBytes.length);
            frame.set(firstByte);
            frame.set(dataBytes, firstByte.length);

            // Parse tags from frame
            const tagCount = dataBytes[0];
            const tags = [];
            let pointer = 1;

            for (let i = 0; i < tagCount; i++) {
                const tagLen = dataBytes[pointer];
                const tag = dataBytes.slice(pointer + 1, pointer + 1 + tagLen);
                tags.push(tag);
                pointer += tagLen + 1;
            }

            return tags;
        } catch (error) {
            console.error("Error in inventory:", error);
            return null;
        }
    }
}

class RFIDScanner {
    constructor(inputElement) {
        this.transport = new SerialTransport();
        this.reader = null;
        this.inputElement = inputElement;
        this.isScanning = false;
        this.deviceStatus = 'Closed';
        this.lastScannedTag = null;
        this.scannedTags = new Set();
    }

    async openPort() {
        try {
            const success = await this.transport.open();
            if (success) {
                this.reader = new RFIDReader(this.transport);
                this.deviceStatus = 'Open';
                return true;
            }
            return false;
        } catch (error) {
            console.error("Failed to open port:", error);
            return false;
        }
    }

    async closePort() {
        try {
            await this.transport.close();
            this.deviceStatus = 'Closed';
            this.isScanning = false;
            this.reader = null;
            return true;
        } catch (error) {
            console.error("Failed to close port:", error);
            return false;
        }
    }

    async checkRFIDExists(tagHex) {
        try {
            const response = await fetch(`/api/check-rfid/${tagHex}`);
            const data = await response.json();
            return data.exists;
        } catch (error) {
            console.error('Error checking RFID:', error);
            return false;
        }
    }

    async startScanning() {
        if (this.deviceStatus !== 'Open' || !this.reader) return false;

        this.isScanning = true;
        try {
            const tags = await this.reader.inventoryAnswerMode();
            if (tags?.[0]) {
                let tagHex = Array.from(tags[0])
                    .map(byte => byte.toString(16).padStart(2, '0').toUpperCase())
                    .join(' ');

                // Split the tag if it's duplicated
                const tagLength = 29; // Length of one tag (10 bytes * 3 - 1 space)
                if (tagHex.length > tagLength) {
                    tagHex = tagHex.substring(0, tagLength);
                }

                // Check if tag exists in database
                const exists = await this.checkRFIDExists(tagHex);

                if (exists) {
                    alert('Tag RFID ini sudah terdaftar di database!');
                    this.isScanning = false;
                    return false;
                }

                // If tag hasn't been scanned in this session
                if (!this.scannedTags.has(tagHex)) {
                    this.lastScannedTag = tagHex;
                    this.scannedTags.add(tagHex);
                    this.inputElement.value = tagHex;
                    this.isScanning = false;
                    return tagHex;
                }
            }
            this.isScanning = false;
            return false;
        } catch (error) {
            console.error("Error during scanning:", error);
            this.isScanning = false;
            return false;
        }
    }

    clearLastScanned() {
        this.lastScannedTag = null;
        this.inputElement.value = '';
    }

    resetScannedTags() {
        this.scannedTags.clear();
        this.lastScannedTag = null;
        this.inputElement.value = '';
    }
}

window.RFIDScanner = RFIDScanner;
