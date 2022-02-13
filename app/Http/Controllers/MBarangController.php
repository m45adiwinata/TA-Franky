<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Auth;

class MBarangController extends Controller
{
    public function index()
    {
        $data['barangs'] = Barang::get();
        $data['side_index'] = 1;
        return view('master-data.barang', $data);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
            'jenis' => 'required|string',
        ]);
        $new = new Barang;
        $new->kode = $request->kode;
        $new->nama = $request->nama;
        $new->jenis = $request->jenis;
        $new->save();
        return redirect('/master-barang');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'kode' => 'required',
            'nama' => 'required|string',
            'jenis' => 'required|string',
        ]);
        $data = Barang::find($id);
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->jenis = $request->jenis;
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
