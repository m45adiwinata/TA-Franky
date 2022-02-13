<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplier;
use Auth;

class SuplierController extends Controller
{
    public function index()
    {
        $data['supliers'] = Suplier::get();
        $data['side_index'] = 3;
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
