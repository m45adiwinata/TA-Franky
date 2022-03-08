<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;

class DistribusiController extends Controller
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

    public function index(Request $request)
    {
        if (isset($_GET['kode_barang']) && isset($_GET['tanggal'])) {
            $kode_barang = $_GET['kode_barang'];
            $tanggal = $_GET['tanggal'];
            $temp = date_create($tanggal."-01 first day of last month");
            $tanggal_prev = $temp->format('Y-m');
            $data['distribusis'] = DB::select(DB::raw(
        "SELECT h.tanggal AS tanggal, 'stok opname' AS nama, '' AS masuk, '' AS keluar, h.jml_stok AS stok, '' AS harga, '' AS total_harga, '' AS keuntungan, 'opname' AS ket FROM `hist_opname` h
            INNER JOIN barang b ON h.kode_barang = b.kode
            WHERE b.kode = '$kode_barang' AND DATE_FORMAT(h.tanggal, '%Y-%m') = '$tanggal_prev'
        UNION
        SELECT pb.tanggal AS tanggal, pb.nama_suplier AS nama, pb.kuantitas AS masuk, '' AS keluar, '' AS stok, '' AS harga, '' AS total_harga, '' AS keuntungan, 'pembelian' AS ket FROM `pembelian` pb
            WHERE pb.kode_barang = '$kode_barang' AND DATE_FORMAT(pb.tanggal, '%Y-%m') = '$tanggal'
        UNION
        SELECT pj.tanggal AS tanggal, pj.nama_pembeli AS nama, '' AS masuk, pj.kuantitas AS keluar, '' AS stok, pj.harga AS harga, pj.total AS total_harga, pj.profit AS keuntungan, 'penjualan' AS ket FROM `penjualan` pj
            WHERE pj.kode_barang = '$kode_barang' AND DATE_FORMAT(pj.tanggal, '%Y-%m') = '$tanggal'
            ORDER BY tanggal"
            ));
        }
        else {
            $data['distribusis'] = [];
        }
        $data['barangs'] = Barang::get();
        $data['side_index'] = 7;
        $data['notifstoks'] = $this->notifstok();

        return view('distribusi.distribusi', $data);
    }
}
