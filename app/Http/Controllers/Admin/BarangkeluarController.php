<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BarangkeluarController extends Controller
{
    public function index()
    {
        $data["title"] = "Barang Keluar";
        $data["hakTambah"] = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Keluar', 'tbl_akses.akses_type' => 'create'))->count();
        return view('Admin.BarangKeluar.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangkeluarModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangkeluar.barang_kode')
            ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
            ->leftJoin('tbl_barangmasuk', 'tbl_barangmasuk.bm_kode', '=', 'tbl_barangkeluar.bm_kode') // Tambahkan leftJoin untuk bm_id
            ->orderBy('bk_id', 'DESC')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tglkeluar', function ($row) {
                    $tglkeluar = $row->bk_tanggal == '' ? '-' : Carbon::parse($row->bk_tanggal)->translatedFormat('d F Y');

                    return $tglkeluar;
                })
                ->addColumn('tujuan', function ($row) {
                    $tujuan = $row->bk_tujuan == '' ? '-' : $row->bk_tujuan;

                    return $tujuan;
                })
                ->addColumn('kdbarang', function ($row) {
                    $kdbarang = $row->bm_kode == '' ? '-' : $row->barang_kode;

                    return $kdbarang;
                })
                ->addColumn('barang', function ($row) {
                    $barang = $row->barang_id == '' ? '-' : $row->barang_nama;

                    return $barang;
                })
                ->addColumn('satuan', function ($row) {
                    $satuan = $row->barang_id == '' ? '-' : $row->satuan_nama;

                    return $satuan;
                })
                ->addColumn('jenisbarang', function ($row) {
                    $jenisbarang = $row->barang_id == '' ? '-' : $row->jenisbarang_nama;

                    return $jenisbarang;
                })
                ->addColumn('merk', function ($row) {
                    $merk = $row->barang_id == '' ? '-' : $row->merk_nama;

                    return $merk;
                })
                ->addColumn('tglexp', function ($row) {
                    $tglexp = $row->bm_kode == '' ? '-' : Carbon::parse($row->bm_tglex)->translatedFormat('d F Y');

                    return $tglexp;
                })
                ->addColumn('harga_jual', function ($row) {
                    $harga_jual = $row->bm_kode == '' ? '-' : 'Rp ' . number_format($row->bm_hargajual, 0);

                    return $harga_jual;
                })
                ->addColumn('etalase', function ($row) {
                    $etalase = $row->bm_kode == '' ? '-' : $row->bm_etalase;

                    return $etalase;
                })
                ->addColumn('hargatotal', function ($row) {
                    $hargatotal = $row->bk_totalharga == '' ? '-' : 'Rp ' . number_format($row->bk_totalharga, 0);

                    return $hargatotal;
                })
                ->addColumn('action', function ($row) {
                    $array = array(
                        "bk_id" => $row->bk_id,
                        "bk_kode" => $row->bk_kode,
                        "bm_kode" => $row->bm_kode,
                        "barang_kode" => $row->barang_kode,
                        "bk_tanggal" => $row->bk_tanggal,
                        "bk_tujuan" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->bk_tujuan)),
                        "bk_jumlah" => $row->bk_jumlah,
                        "bk_totalharga" => $row->bk_totalharga,
                    );
                    $button = '';
                    $hakEdit = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Keluar', 'tbl_akses.akses_type' => 'update'))->count();
                    $hakDelete = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Keluar', 'tbl_akses.akses_type' => 'delete'))->count();
                    if ($hakEdit > 0 && $hakDelete > 0) {
                        $button .= '
                        <div class="g-2">
                        <a class="btn modal-effect text-primary btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" data-bs-toggle="tooltip" data-bs-original-title="Edit" onclick=update(' . json_encode($array) . ')><span class="fe fe-edit text-success fs-14"></span></a>
                        <a class="btn modal-effect text-danger btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Hmodaldemo8" onclick=hapus(' . json_encode($array) . ')><span class="fe fe-trash-2 fs-14"></span></a>
                        </div>
                        ';
                    } else if ($hakEdit > 0 && $hakDelete == 0) {
                        $button .= '
                        <div class="g-2">
                            <a class="btn modal-effect text-primary btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Umodaldemo8" data-bs-toggle="tooltip" data-bs-original-title="Edit" onclick=update(' . json_encode($array) . ')><span class="fe fe-edit text-success fs-14"></span></a>
                        </div>
                        ';
                    } else if ($hakEdit == 0 && $hakDelete > 0) {
                        $button .= '
                        <div class="g-2">
                        <a class="btn modal-effect text-danger btn-sm" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#Hmodaldemo8" onclick=hapus(' . json_encode($array) . ')><span class="fe fe-trash-2 fs-14"></span></a>
                        </div>
                        ';
                    } else {
                        $button .= '-';
                    }
                    return $button;
                })
                ->rawColumns(['action', 'tglkeluar', 'tujuan', 'kdbarang', 'barang', 'satuan', 'jenisbarang', 'merk', 'tglexp', 'etalase','harga_jual', 'hargatotal'])->make(true);
        }
    }

    public function proses_tambah(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tglkeluar' => 'required',
                'bkkode' => 'required',
                'kdbarang' => 'required',
                'tujuan' => 'required',
                'jml' => 'required|numeric',
                'bmkode' => 'required',
            ]);

            // Ambil harga jual dari database berdasarkan BM Kode yang baru dipilih
            $barangMasuk = BarangmasukModel::where('bm_kode', $request->bmkode)->first();
            $hargaJual = $barangMasuk->bm_hargajual;

            $barangMasuk->bm_etalase -= $request->jml;
            $barangMasuk->save();
            // Hitung harga total berdasarkan jumlah keluar dan harga jual
            $hargatotal = $request->jml * $hargaJual;

            // Buat slug dari string tujuan
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->tujuan)));

            // Cek apakah data dengan kriteria yang sama sudah ada
            $existingData = BarangkeluarModel::where('bk_tanggal', $request->tglkeluar)
                ->where('bk_tujuan', $request->tujuan)
                ->where('bm_kode', $request->bmkode)
                ->where('barang_kode', $request->kdbarang)
                ->first();

            if ($existingData) {
                // Jika data sudah ada, tambahkan jumlah barang keluar dan total harga
                $existingData->increment('bk_jumlah', $request->jml);
                $existingData->increment('bk_totalharga', $hargatotal);
            } else {
                // Jika data belum ada, tambahkan data baru
                BarangkeluarModel::create([
                    'bk_tanggal' => $request->tglkeluar,
                    'bk_kode' => $request->bkkode,
                    'barang_kode' => $request->kdbarang,
                    'bk_tujuan' => $request->tujuan,
                    'bk_jumlah' => $request->jml,
                    'bm_kode' => $request->bmkode,
                    'bk_totalharga' => $hargatotal,
                    'bk_slug' => $slug, // Gunakan slug yang telah dibuat
                ]);
            }

            return response()->json(['success' => 'Berhasil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memproses permintaan: ' . $e->getMessage()]);
        }
    }

    public function proses_ubah(Request $request, BarangkeluarModel $barangkeluar)
    {
        try {
            // Validasi input
            $request->validate([
                'tglkeluar' => 'required',
                'bkkode' => 'required',
                'kdbarang' => 'required',
                'tujuan' => 'required',
                'jml' => 'required|numeric',
                'bmkode' => 'required',
                'harga_jual' => 'required', // tambahkan validasi untuk harga jual
            ]);

            // Ambil harga jual dari database berdasarkan BM Kode yang baru dipilih
            $barangMasuk = BarangmasukModel::where('bm_kode', $request->bmkode)->first();
            $hargaJual = $barangMasuk->bm_hargajual;

            $barangMasuk->bm_etalase += $barangkeluar->bk_jumlah;
            // Kurangi jumlah barang di etalase
            $barangMasuk->bm_etalase -= $request->jml;
            $barangMasuk->save();

            // Hitung harga total berdasarkan perubahan jumlah keluar dan harga jual
            $hargatotal = $request->jml * $request->harga_jual;

            // Buat slug dari string tujuan
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->tujuan)));

            // Cek apakah data dengan kriteria yang sama sudah ada
            $existingData = BarangkeluarModel::where('bk_tanggal', $request->tglkeluar)
                ->where('bk_tujuan', $request->tujuan)
                ->where('bm_kode', $request->bmkode)
                ->where('barang_kode', $request->kdbarang)
                ->where('bk_kode', '!=', $request->bkkode)
                ->first();

            if ($existingData) {
                // Jika data sudah ada, update jumlah barang keluar dan total harga
                $existingData->update([
                    'bk_jumlah' => $existingData->bk_jumlah + $request->jml,
                    'bk_totalharga' => $existingData->bk_totalharga + $hargatotal,
                    'bk_slug' => $slug,
                ]);

                // Hapus data yang sedang diubah
                $barangkeluar->delete();
            } else {
                // Jika data belum ada, update data yang sedang diubah
                $barangkeluar->update([
                    'bk_tanggal' => $request->tglkeluar,
                    'bk_kode' => $request->bkkode,
                    'barang_kode' => $request->kdbarang,
                    'bk_tujuan'   => $request->tujuan,
                    'bk_jumlah'   => $request->jml,
                    'bm_kode' => $request->bmkode,
                    'bk_totalharga' => $hargatotal, // Perbarui total harga
                    'bk_slug' => $slug,
                ]);
            }

            return response()->json(['success' => 'Berhasil']);
        } catch (\Exception $e) {
            // Tangani kesalahan dan kirim respons error
            return response()->json(['error' => 'Gagal memproses permintaan. Silakan coba lagi.']);
        }
    }

    public function proses_hapus(Request $request, BarangkeluarModel $barangkeluar)
    {
        //delete
        $barangkeluar->delete();

        return response()->json(['success' => 'Berhasil']);
    }

}
