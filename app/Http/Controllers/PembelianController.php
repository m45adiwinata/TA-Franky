<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Suplier;
use App\Models\Stok;

class PembelianController extends Controller
{
    public function index()
    {
        $data['pembelians'] = Pembelian::get();
        $data['barangs'] = Barang::get();
        $data['supliers'] = Suplier::get();
        $data['side_index'] = 5;
        
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

        return redirect('pembelian');
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'kode_barang' => 'required',
            'id_suplier' => 'required',
            'harga' => 'required',
            'kuantitas' => 'required',
        ]);
    }

    public function detail($id)
    {
        $data = Pembelian::find($id);
        return $data;
    }
}
