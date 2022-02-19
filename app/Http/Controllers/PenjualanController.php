<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Gudang;

class PenjualanController extends Controller
{
    public function index()
    {
        $data['penjualans'] = Penjualan::get();
        $data['barangs'] = Stok::with('barang')->get();
        $data['gudangs'] = Gudang::get();
        $data['side_index'] = 6;
        
        return view('transaksi.penjualan', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'kode_barang' => 'required',
            'harga' => 'required',
            'kuantitas' => 'required',
        ]);
        $barang = Barang::where('kode', $request->kode_barang)->with(['stok' => function ($query) {
            $query->orderBy('tanggal_beli');
        }])->first();
        $tersedia = Stok::where('kode_barang', $request->kode_barang)->sum('jml_stok');
        $permintaan = (int)$request->kuantitas;
        $profit = 0;
        if ($tersedia < $request->kuantitas) {
            return redirect('penjualan')->with('fail', 'Jumlah permintaan melebihi persediaan ('.$tersedia.').');
        }
        $data = new Penjualan;
        $data->tanggal = $request->tanggal;
        $data->kode_barang = $request->kode_barang;
        $data->nama_barang = $barang->nama;
        $data->harga = $request->harga;
        $data->kuantitas = $request->kuantitas;
        if ($request->check_gudang) {
            $data->id_gudang = $request->id_gudang;
        }
        $data->nama_pembeli = $request->nama_pembeli;
        $data->save();
        foreach ($barang->stok as $key => $stok) {
            if ($stok->jml_stok >= $permintaan) {
                $profit += ($data->harga - $stok->harga_beli) * $permintaan;
                $stok->jml_stok -= $permintaan;
                $stok->save();
                $permintaan = 0;
                break;
            }
            else {
                $profit += ($data->harga - $stok->harga_beli) * $stok->jml_stok;
                $permintaan -= $stok->jml_stok;
                $stok->delete();
            }
        }
        $data->profit = $profit;
        $data->save();
        
        return redirect('penjualan');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'tanggal' => 'required',
        ]);
        $data = Penjualan::find($id);
        $data->tanggal = $request->tanggal;
        if ($request->check_gudang) {
            $data->id_gudang = $request->id_gudang;
        }
        $data->nama_pembeli = $request->nama_pembeli;
        $data->save();

        return redirect('penjualan');
    }

    public function delete(Request $request, $id)
    {
        $data = Penjualan::find($id);
        if($data->stok->jml_stok != $data->kuantitas) {
            return redirect('/penjualan')->with('fail', 'Data penjualan gagal dihapus karena data stok yang dibeli sudah berubah.');
        }
        $data->delete();
        return redirect('/penjualan');
    }

    public function detail($id)
    {
        $data = Penjualan::find($id);
        return $data;
    }
}
