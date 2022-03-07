<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplier;
use Illuminate\Support\Facades\DB;
use Auth;

class SuplierController extends Controller
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
        $data['supliers'] = Suplier::get();
        $data['side_index'] = 3;
        $data['notifstoks'] = $this->notifstok();

        return view('master-data.suplier', $data);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama' => 'required',
            'alamat' => 'required|string',
        ]);
        $new = new Suplier;
        $new->nama = $request->nama;
        $new->alamat = $request->alamat;
        $new->telp1 = $request->telp1;
        $new->telp2 = $request->telp2;
        $new->save();
        return redirect('/master-suplier');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'nama' => 'required',
            'alamat' => 'required|string',
        ]);
        $data = Suplier::find($id);
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->telp1 = $request->telp1;
        $data->telp2 = $request->telp2;
        $data->save();
        return redirect('/master-suplier');
    }
    public function delete($id)
    {
        Suplier::find($id)->delete();
        return redirect('/master-suplier');
    }
    public function detail($id)
    {
        $data = Suplier::find($id);
        return $data;
    }
}
