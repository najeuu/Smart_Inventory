import socket
import threading
from flask import Flask, jsonify
from flask_socketio import SocketIO
import eventlet

# ✅ Gunakan eventlet agar WebSocket non-blocking
eventlet.monkey_patch()

# ==========================
# KONFIGURASI
# ==========================
READER_IP = '192.168.1.5'     # Ganti dengan IP Reader kamu
READER_PORT = 6000            # Port TCP reader

# ==========================
# SETUP Flask + WebSocket
# ==========================
app = Flask(__name__)
socketio = SocketIO(app, cors_allowed_origins='*')

# ==========================
# Fungsi bantu: parse UID
# ==========================
def parse_tag(data_bytes):
    """Ubah array byte menjadi string hex UID."""
    return ''.join(f'{b:02X}' for b in data_bytes)

# ==========================
# Listener dari RFID Reader
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

            if not data:
                continue

            # 🐛 DEBUG: tampilkan semua data mentah
            print("📥 RAW DATA:", list(data))
            print("📏 Panjang data:", len(data))
            print("🔢 HEX:", parse_tag(data))

            # 💡 Coba kenali format lama (EPC/EE format)
            if len(data) >= 8 and data[2] == 0xEE and data[3] == 0x00:
                tag_data = data[4:-1] if len(data) > 8 else data[4:8]
                tag_uid = parse_tag(tag_data)
                print(f"🏷️ [FORMAT EE] Tag terbaca: {tag_uid}")
                socketio.emit('tag_scanned', {'tag_uid': tag_uid})

            # 💡 Deteksi format alternatif untuk single-tag active mode
            elif len(data) >= 6:
                # Tebakan awal: ambil byte ke-2 s/d 5 sebagai UID
                tag_data = data[2:6]
                tag_uid = parse_tag(tag_data)
                print(f"🏷️ [FORMAT ALT] Tag terbaca: {tag_uid}")
                socketio.emit('tag_scanned', {'tag_uid': tag_uid})

            else:
                print("⚠️ Format tidak dikenali:", list(data))

        except Exception as e:
            print("❌ Error saat membaca data:", e)
            break

# ==========================
# Endpoint Cek Server Aktif
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
