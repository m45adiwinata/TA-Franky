<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Gudang;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
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
        $data['penjualans'] = Penjualan::get();
        $data['barangs'] = DB::select(DB::raw(
            "SELECT b.kode,b.nama FROM stok s 
                INNER JOIN barang b ON s.kode_barang=b.kode GROUP BY b.kode,b.nama"
        ));
        $data['gudangs'] = Gudang::get();
        $data['side_index'] = 6;
        $data['notifstoks'] = $this->notifstok();
        
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
        $tanggal_barang = $barang->stok[0]->tanggal_beli;
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
        $data->total = $request->harga * $request->kuantitas;
        $data->tanggal_barang = $tanggal_barang;
        if ($request->check_gudang) {
            $data->id_gudang = $request->id_gudang;
            $data->nama_pembeli = Gudang::find($request->id_gudang)->nama;
        }
        else {
            $data->nama_pembeli = $request->nama_pembeli;
        }
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
        
        return redirect('penjualan')->with('success', 'Penjualan berhasil dimasukkan.');
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
        $stok = Stok::where('kode_barang', $data->kode_barang)
                    ->whereDate('tanggal_beli', $data->tanggal_barang)->first();
        if ($stok) {
            $stok->jml_stok += $data->kuantitas;
            $stok->save();
        }
        else {
            $temp = Stok::where('kode_barang', $data->kode_barang)->orderBy('tanggal_beli')->first();
            $stok = new Stok;
            $stok->kode_barang = $data->kode_barang;
            $stok->tanggal_beli = $data->tanggal_barang;
            $stok->tanggal_masuk = $data->tanggal_barang;
            $stok->harga_beli = $temp->harga_beli;
            $stok->harga_jual = $data->harga;
            $stok->jml_stok = $data->kuantitas;
            $stok->kode_gudang = 'PST';
            $stok->save();
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
