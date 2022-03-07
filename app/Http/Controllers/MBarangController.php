<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Auth;

class MBarangController extends Controller
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
        $data['barangs'] = Barang::get();
        $data['side_index'] = 1;
        $data['notifstoks'] = $this->notifstok();
        
        return view('master-data.barang', $data);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'min_stok' => 'required',
        ]);
        $new = new Barang;
        $new->kode = $request->kode;
        $new->nama = $request->nama;
        $new->jenis = $request->jenis;
        $new->min_stok = $request->min_stok;
        $new->save();
        return redirect('/master-barang');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'min_stok' => 'required',
        ]);
        $data = Barang::find($id);
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->jenis = $request->jenis;
        $data->min_stok = $request->min_stok;
        $data->save();
        return redirect('/master-barang');
    }
    public function delete($id)
    {
        Barang::find($id)->delete();
        return redirect('/master-barang');
    }
    public function detail($id)
    {
        $data = Barang::find($id);
        return $data;
    }
}
