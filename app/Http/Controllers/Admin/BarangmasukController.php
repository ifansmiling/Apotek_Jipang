<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\BarangmasukModel;
use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangModel;
use App\Models\Admin\CustomerModel;
use App\Models\Admin\SatuanModel;
use App\Models\Admin\JenisBarangModel;
use App\Models\Admin\MerkModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BarangmasukController extends Controller
{
    public function index()
    {
        $data["title"] = "Barang Masuk";
        $data["hakTambah"] = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Masuk', 'tbl_akses.akses_type' => 'create'))->count();
        $data["customer"] = CustomerModel::orderBy('customer_id', 'DESC')->get();
        return view('Admin.BarangMasuk.index', $data);
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')->leftJoin('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_barangmasuk.customer_id')->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')->orderBy('bm_id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tgl', function ($row) {
                    $tgl = $row->bm_tanggal == '' ? '-' : Carbon::parse($row->bm_tanggal)->translatedFormat('d F Y');

                    return $tgl;
                })
                ->addColumn('customer', function ($row) {
                    $customer = $row->customer_id == '' ? '-' : $row->customer_nama;

                    return $customer;
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
                    $tglexp = $row->bm_tglex == '' ? '-' : Carbon::parse($row->bm_tglex)->translatedFormat('d F Y');

                    return $tglexp;
                })
                ->addColumn('harga_jual', function ($row) {
                    $harga_jual = $row->bm_hargajual == '' ? '-' : 'Rp ' . number_format($row->bm_hargajual, 0);

                    return $harga_jual;
                })
                ->addColumn('harga_beli', function ($row) {
                    $harga_beli = $row->bm_hargabeli == '' ? '-' : 'Rp ' . number_format($row->bm_hargabeli, 0);

                    return $harga_beli;
                })
                ->addColumn('total_harga', function ($row) {
                    $total_harga = $row->bm_totalharga == '' ? '-' : 'Rp ' . number_format($row->bm_totalharga, 0);

                    return $total_harga;
                })
                ->addColumn('action', function ($row) {
                    $array = array(
                        "bm_id" => $row->bm_id,
                        "bm_kode" => $row->bm_kode,
                        "barang_kode" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->barang_kode)),
                        "customer_id" => $row->customer_id,
                        "bm_tanggal" => $row->bm_tanggal,
                        "bm_jumlah" => $row->bm_jumlah,
                        "bm_tglex" => $row->bm_tglex,
                        "bm_hargajual" => $row->bm_hargajual,
                        "bm_hargabeli" => $row->bm_hargabeli,
                        "bm_totalharga" => $row->bm_totalharga,
                        "bm_stok" => $row->bm_stok,
                        "bm_etalase" => $row->bm_etalase,
                        "bm_ltkgudang" => $row->bm_ltkgudang,
                        "bm_ltketalase" => $row->bm_ltketalase,


                    );
                    $button = '';
                    $hakEdit = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Masuk', 'tbl_akses.akses_type' => 'update'))->count();
                    $hakDelete = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_submenu.submenu_judul' => 'Barang Masuk', 'tbl_akses.akses_type' => 'delete'))->count();
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
                ->rawColumns(['action', 'tgl', 'customer', 'barang', 'satuan', 'jenisbarang', 'merk', 'tglexp', 'harga_jual', 'harga_beli', 'total_harga'])->make(true);
        }
    }

    public function proses_tambah(Request $request)
    {
        // Ambil data dari $request
        $bmkode = $request->bmkode;
        $tglmasuk = $request->tglmasuk;
        $customer = $request->customer;
        
        // Loop melalui barangList
        foreach ($request->barangList as $barang) {
            BarangmasukModel::create([
                'bm_tanggal' => $tglmasuk,
                'bm_kode' => $bmkode,
                'barang_kode' => $barang['kdbarang'], // Ambil kode barang dari array barangList
                'customer_id' => $customer,
                'bm_jumlah' => $barang['jml'],
                'bm_tglex' => $barang['tglkadaluarsa'],
                'bm_hargajual' => $barang['hargajual'],
                'bm_hargabeli' => $barang['hargabeli'],
                'bm_totalharga' => $barang['totalharga'],
                'bm_stok' => $barang['jml'],
                'bm_etalase' => 0, // Default value
                'bm_ltkgudang'=> '', // Default value
                'bm_ltketalase'=> '', // Default value
            ]);
        }
    
        return response()->json(['success' => 'Berhasil']);
    }  

    public function getBarangByNota($bm_kode)
    {
        // Mencari semua barang masuk berdasarkan bm_kode
        $barangMasuk = BarangmasukModel::with('barang') // Mengambil relasi barang
            ->where('bm_kode', $bm_kode)
            ->get();

        if ($barangMasuk->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($barangMasuk->toArray(), 200); // Ubah ke array untuk JSON
    }


    public function proses_ubah(Request $request, BarangmasukModel $barangmasuk)
    {
        $data = $request->validate([
            'nmbarangEdit' => 'required|array',
            'jmlEdit' => 'required|array',
            'hargajualEdit' => 'required|array',
            'hargabeliEdit' => 'required|array',
            'tglkadaluarsaEdit' => 'required|array',
            'customer' => 'required',
            'tglmasuk' => 'required|date',
            'bmkode' => 'required',
        ]);

        // Proses setiap barang yang diedit
        for ($i = 0; $i < count($data['nmbarangEdit']); $i++) {
            $inputData = [
                'bm_tanggal' => $data['tglmasuk'],
                'customer_id' => $data['customer'],
                'barang_kode' => $data['nmbarangEdit'][$i], // Ganti sesuai kunci yang tepat
                'bm_jumlah' => $data['jmlEdit'][$i],
                'bm_tglex' => $data['tglkadaluarsaEdit'][$i],
                'bm_hargajual' => $data['hargajualEdit'][$i],
                'bm_hargabeli' => $data['hargabeliEdit'][$i],
                // Tambahkan kolom lain jika perlu
            ];

            // Update atau buat entri baru sesuai kebutuhan
            BarangmasukModel::updateOrCreate(
                ['bm_kode' => $data['bmkode'], 'barang_kode' => $inputData['barang_kode']], // kriteria pencarian
                $inputData // data yang akan diupdate atau dibuat
            );
        }

        return response()->json(['success' => 'Data berhasil diubah']);
    }

    
    public function proses_hapus($bm_kode)
    {
        // Menggunakan model untuk mencari dan menghapus semua data yang memiliki bm_kode tersebut
        $barang = BarangmasukModel::where('bm_kode', $bm_kode)->get();
        
        if ($barang->isNotEmpty()) {
            foreach ($barang as $item) {
                $item->delete();
            }
            return response()->json(['message' => 'Semua data berhasil dihapus'], 200);
        }

        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }


}
