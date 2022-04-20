<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Gudang;

class DashboardController extends Controller
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
        $data['side_index'] = 0;
        $data['notifstoks'] = $this->notifstok();
        $data['penjualans'] = Penjualan::select(DB::raw('DATE(tanggal) as tanggal, SUM(total) as total'))
                                ->whereYear('tanggal', 2021)
                                ->whereMonth('tanggal', 11)
                                ->groupBy(DB::raw('DATE(tanggal)'))
                                ->get();
        $data['pembelians'] = Pembelian::get();
        $data['gudangs'] = Gudang::get();
        $data['revenue'] = Penjualan::sum('total');
        $data['profit'] = Penjualan::sum('profit');
        $data['cost'] = Pembelian::sum('total');
        
        return view('dashboard',$data);
    }

    public function getDataGrafikPenjualan()
    {
        return json_encode(Penjualan::get());
    }
}
