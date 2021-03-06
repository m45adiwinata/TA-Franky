<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\HistoryOpname;
use Illuminate\Support\Facades\DB;
use DateTime;
use Auth;

class StokController extends Controller
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
        $data['stoks'] = Stok::with('barang')->get();
        $data['barangs'] = Barang::get();
        $data['gudangs'] = Gudang::get();
        $data['side_index'] = 2;
        $data['notifstoks'] = $this->notifstok();

        return view('master-data.stok', $data);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required',
            'tanggal_beli' => 'required|string',
            'tanggal_masuk' => 'required|string',
            'jml_stok' => 'required',
        ]);
        $data = new Stok;
        $data->kode_barang = $request->kode;
        $data->tanggal_beli = $request->tanggal_beli;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->harga_beli = $request->harga_beli;
        $data->harga_jual = $request->harga_jual;
        $data->jml_stok = $request->jml_stok;
        $data->kode_gudang = $request->kode_gudang;
        $data->save();
        if ($request->check_opname) {
            $h_opname = new HistoryOpname;
            $h_opname->kode_barang = $data->kode_barang;
            $h_opname->jml_stok = $data->jml_stok;
            $h_opname->tanggal = $data->tanggal_masuk;
            $h_opname->save();
        }
        return redirect('master-stok-barang');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'kode' => 'required',
            'tanggal_beli' => 'required|string',
            'tanggal_masuk' => 'required|string',
            'jml_stok' => 'required|string',
        ]);
        $data = Stok::find($id);
        $data->kode_barang = $request->kode;
        $data->tanggal_beli = $request->tanggal_beli;
        $data->tanggal_masuk = $request->tanggal_masuk;
        $data->harga_beli = $request->harga_beli;
        $data->harga_jual = $request->harga_jual;
        $data->jml_stok = $request->jml_stok;
        $data->kode_gudang = $request->kode_gudang;
        $data->save();
        return redirect('master-stok-barang');
    }
    public function delete(Request $request,$id)
    {
        Stok::find($id)->delete();
        return redirect('master-stok-barang');
    }

    public function detail($id)
    {
        $data = Stok::find($id);
        return $data;
    }

    public function stokKritis()
    {
        $data['side_index'] = 8;
        $data['notifstoks'] = $this->notifstok();
        $data['stoks'] = DB::select(DB::raw("SELECT b.kode, b.nama, b.min_stok, IF(s.stok IS NULL, 0, s.stok) AS stok FROM barang b LEFT JOIN (
            SELECT kode_barang, SUM(jml_stok) AS stok FROM stok GROUP BY kode_barang
        ) s ON s.kode_barang = b.kode WHERE s.stok <= b.min_stok OR s.stok IS NULL"));

        return view('master-data.stok-kritis', $data);
    }
}
