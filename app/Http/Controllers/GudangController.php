<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use Illuminate\Support\Facades\DB;
use Auth;

class GudangController extends Controller
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
        $data['gudangs'] = Gudang::get();
        $data['side_index'] = 4;
        $data['notifstoks'] = $this->notifstok();
        
        return view('master-data.gudang', $data);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
        ]);
        $new = new Gudang;
        $new->kode = $request->kode;
        $new->nama = $request->nama;
        $new->ket1 = $request->ket1;
        $new->ket2 = $request->ket2;
        $new->save();
        return redirect('/master-gudang');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
        ]);
        $data = Gudang::find($id);
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->ket1 = $request->ket1;
        $data->ket2 = $request->ket2;
        $data->save();
        return redirect('/master-gudang');
    }
    public function delete($id)
    {
        Gudang::find($id)->delete();
        return redirect('/master-gudang');
    }
    public function detail($id)
    {
        $data = Gudang::find($id);
        return $data;
    }
}
