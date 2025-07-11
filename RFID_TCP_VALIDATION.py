import socket
import threading
from flask import Flask, jsonify
from flask_socketio import SocketIO
import eventlet

# ✅ Gunakan eventlet untuk async WebSocket
eventlet.monkey_patch()

# ==========================
# KONFIGURASI
# ==========================
READER_IP = '192.168.1.5'     # IP dari RFID reader (lihat aplikasi demo)
READER_PORT = 6000            # Port TCP dari reader

# ==========================
# SETUP Flask + WebSocket
# ==========================
app = Flask(__name__)
socketio = SocketIO(app, cors_allowed_origins='*')

# ==========================
# Fungsi bantu
# ==========================
def parse_tag(data_bytes):
    """Ubah byte array menjadi hex string UID"""
    return ''.join(f'{b:02X}' for b in data_bytes)

# ==========================
# Listener RFID via TCP/IP
# ==========================
def listen_rfid_reader():
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    try:
        sock.connect((READER_IP, READER_PORT))
        print("📡 Terhubung ke RFID reader via TCP/IP")
    except Exception as e:
        print("❌ Gagal terhubung ke reader:", e)
        return

    while True:
        try:
            data = sock.recv(1024)
            print("📥 Data diterima:", list(data))

            if not data:
                continue

            # Format data: [AA, BB, EE, 00, xx, xx, xx, xx, ...]
            if len(data) >= 8 and data[2] == 0xEE and data[3] == 0x00:
                tag_data = data[4:8]  # Ambil 4 byte UID tag
                tag_uid = parse_tag(tag_data)
                print(f"🏷️ Tag terbaca: {tag_uid}")

                # Kirim ke frontend Laravel via Socket.IO
                socketio.emit('tag_scanned', {'tag_uid': tag_uid})
            else:
                print("⚠️ Format data tidak dikenali:", list(data))

        except Exception as e:
            print("❌ Error saat membaca data:", e)
            break

# ==========================
# Rute cek server
# ==========================
@app.route('/')
def index():
    return jsonify({'status': 'RFID Scanner Aktif - WebSocket Ready'})

# ==========================
# Jalankan Flask + Listener
# ==========================
if __name__ == '__main__':
    threading.Thread(target=listen_rfid_reader, daemon=True).start()
    socketio.run(app, host='0.0.0.0', port=8000)
