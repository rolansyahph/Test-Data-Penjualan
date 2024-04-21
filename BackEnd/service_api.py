from flask import Flask, jsonify, request
import pymysql.cursors
from datetime import timedelta  
from datetime import datetime

app = Flask(__name__)

#Koneksi Data Base
connection = pymysql.connect(
    host='127.0.0.1',
    user='root',
    password='',
    db='master_barang',
    cursorclass=pymysql.cursors.DictCursor
)

@app.route('/get_data_barang', methods=['GET'])
def get_data_barang():
    try:
        with connection.cursor() as cursor:
            # Pemanggil Stored Prosedure
            cursor.callproc('sp_get_data_barang')
            results = cursor.fetchall()

            # Ubah format tanggal pada setiap hasil
            for result in results:
                result['tanggal_update'] = result['tanggal_update'].strftime('%d-%m-%Y')

        response = {
            'status': 200,
            'message': 'Sukses',
            'data': results
        }
        return jsonify(response)
    except Exception as ex:
        error_response = {
            'status': 500,
            'message': f'Error: {str(ex)}',
            'data': []
        }
        return jsonify(error_response), 500

@app.route('/input_data_barang', methods=['POST'])
def input_data_barang():
    try:
        data = request.get_json()
        nama_barang = data['nama_barang']
        satuan = data['satuan']
        stok = data['stok']
        jenis_barang = data['jenis_barang']

        with connection.cursor() as cursor:
            cursor.callproc('sp_input_data_barang', (
                nama_barang,
                satuan,
                stok,
                jenis_barang
            ))
            connection.commit()

        return jsonify({'status': 'Sukses Input Data Barang'})
    except Exception as ex:
        return jsonify({'status': 'Error', 'message': str(ex)}), 500
    


@app.route('/update_data_barang', methods=['POST'])
def update_data_barang():
    try:
        data = request.get_json()
        kode_barang = data['kode_barang']
        stok = data['stok']

        with connection.cursor() as cursor:
            cursor.callproc('sp_update_data_barang', (
                kode_barang,
                stok
            ))
            connection.commit()

        return jsonify({'status': 'Sukses Update Data'})
    except Exception as ex:
        return jsonify({'status': 'Error', 'message': str(ex)}), 500


@app.route('/hapus_data_barang', methods=['POST'])
def hapus_data_barang():
    try:
        data = request.get_json()
        kode_barang = data['kode_barang']

        with connection.cursor() as cursor:
            cursor.callproc('sp_hapus_data_barang', (
                kode_barang,
            ))
            connection.commit()

        return jsonify({'status': '200'})
    except Exception as ex:
        return jsonify({'status': 'Error', 'message': str(ex)}), 500
    

@app.route('/get_data_penjualan', methods=['GET'])
def get_data_penjualan():
    try:
        with connection.cursor() as cursor:
            # Pemanggil Stored Prosedure
            cursor.callproc('sp_get_data_penjualan')
            results = cursor.fetchall()

            for result in results:
                result['tanggal_transaksi'] = result['tanggal_transaksi'].strftime('%d-%m-%Y & %H:%M:%S')

        response = {
            'status': 200,
            'message': 'Sukses',
            'data': results
        }
        return jsonify(response)
    except Exception as ex:
        error_response = {
            'status': 500,
            'message': f'Error: {str(ex)}',
            'data': []
        }
        return jsonify(error_response), 500
    
@app.route('/input_data_penjualan', methods=['POST'])
def input_data_penjualan():
    try:
        data = request.get_json()
        kode_barang = data['kode_barang']
        jumlah_terjual = data['jumlah_terjual']

        with connection.cursor() as cursor:
            cursor.callproc('sp_input_data_penjualan', (
                kode_barang,
                jumlah_terjual
            ))
            connection.commit()

        response = {
            'status': 'success',
            'message': 'Data berhasil ditambahkan'
        }
        return jsonify(response), 201
    except KeyError:
        response = {
            'status': 'error',
            'message': 'Ada kesalahan dalam permintaan, pastikan Anda menyertakan semua parameter yang diperlukan.'
        }
        return jsonify(response), 400
    except Exception as ex:
        response = {
            'status': 'error',
            'message': 'Stok tidak cukup, harap cek terlebih dahulu.'
        }
        return jsonify(response), 500

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=1010)

