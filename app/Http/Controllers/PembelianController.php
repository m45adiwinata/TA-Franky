<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Suplier;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    private function notifstok()
    {
        $data = DB::select(DB::raw(
            "SELECT b.kode,b.nama, s.jml_stok FROM barang b
                LEFT JOIN (SELECT kode_barang, SUM(jml_stok) AS jml_stok FROM stok GROUP BY kode_barang) AS s ON s.kode_barang = b.kode
                WHERE s.jml_stok <= b.min_stok
                OR s.jml_stok IS NULL"
        ));

        return $data;
    }

    public function index()
    {
        $data['pembelians'] = Pembelian::get();
        $data['barangs'] = Barang::get();
        $data['supliers'] = Suplier::get();
        $data['side_index'] = 5;
        $data['notifstoks'] = $this->notifstok();
        
        return view('transaksi.pembelian', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'kode_barang' => 'required',
            'id_suplier' => 'required',
            'harga' => 'required',
            'kuantitas' => 'required',
        ]);
        $data = new Pembelian;
        $data->tanggal = $request->tanggal;
        $data->kode_barang = $request->kode_barang;
        $data->nama_barang = Barang::where('kode', $request->kode_barang)->first()->nama;
        $data->id_suplier = $request->id_suplier;
        $data->nama_suplier = Suplier::find($request->id_suplier)->nama;
        $data->harga = $request->harga;
        $data->kuantitas = $request->kuantitas;
        $data->save();
        $stok = new Stok;
        $stok->kode_barang = $data->kode_barang;
        $stok->tanggal_beli = $data->tanggal;
        $stok->tanggal_masuk = $data->tanggal;
        $stok->harga_beli = $data->harga;
        $stok->jml_stok = $data->kuantitas;
        $stok->kode_gudang = 'PST';
        $stok->save();
        $data->id_stok = $stok->id;
        $data->save();

        return redirect('pembelian')->with('success', 'Pembelian berhasil dimasukkan.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'kode_barang' => 'required',
            'id_suplier' => 'required',
            'harga' => 'required',
            'kuantitas' => 'required',
        ]);
        $data = Pembelian::find($id);
        if(!$data->stok) {
            return redirect('/pembelian')->with('fail', 'Gagal edit pembelian karena data stok yang dibeli sudah berubah.');
        }
        else if($data->stok->jml_stok != $data->kuantitas) {
            return redirect('/pembelian')->with('fail', 'Gagal edit pembelian karena data stok yang dibeli sudah berubah.');
        }
        $data->tanggal = $request->tanggal;
        $data->kode_barang = $request->kode_barang;
        $data->nama_barang = Barang::where('kode', $request->kode_barang)->first()->nama;
        $data->id_suplier = $request->id_suplier;
        $data->nama_suplier = Suplier::find($request->id_suplier)->nama;
        $data->harga = $request->harga;
        $data->kuantitas = $request->kuantitas;
        $data->save();
        Stok::find($data->id_stok)->delete();
        $stok = new Stok;
        $stok->kode_barang = $data->kode_barang;
        $stok->tanggal_beli = $data->tanggal;
        $stok->tanggal_masuk = $data->tanggal;
        $stok->harga_beli = $data->harga;
        $stok->jml_stok = $data->kuantitas;
        $stok->kode_gudang = 'PST';
        $stok->save();
        $data->id_stok = $stok->id;
        $data->save();

        return redirect('pembelian');
    }

    public function delete(Request $request, $id)
    {
        $data = Pembelian::with('stok')->find($id);
        if($data->stok->jml_stok != $data->kuantitas) {
            return redirect('/pembelian')->with('fail', 'Data pembelian gagal dihapus karena data stok yang dibeli sudah berubah.');
        }
        $data->delete();
        return redirect('/pembelian');
    }

    public function detail($id)
    {
        $data = Pembelian::find($id);
        return $data;
    }
}
