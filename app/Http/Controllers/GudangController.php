<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use Auth;

class GudangController extends Controller
{
    public function index()
    {
        $data['gudangs'] = Gudang::get();
        $data['side_index'] = 4;
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
