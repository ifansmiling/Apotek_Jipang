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

class PersediaanController extends Controller
{
    public function index()
    {
        $data["title"] = "Persediaan Obat";
        $data["hakTambah"] = AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_menu.menu_judul' => 'Persediaan Obat', 'tbl_akses.akses_type' => 'create'))->count();
        $data["customer"] = CustomerModel::orderBy('customer_id', 'DESC')->get();
        return view('Admin.Persediaan.index', $data);
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
                ->addColumn('jml', function ($row) {
                    $jml = $row->bm_kode == '' ? '-': $row->bm_jumlah;
                })
                ->addColumn('totalstok', function ($row) use ($request) {
                    $totalstok = $row->bm_kode == '' ? '-': $row->bm_stok;
                
                    if ($totalstok == 0) {
                        $result = '<span class="">'.$totalstok.'</span>';
                    } else if ($totalstok > 0) {
                        $result = '<span class="text-success">'.$totalstok.'</span>';
                    } else {
                        $result = '<span class="text-danger">'.$totalstok.'</span>';
                    }
                
                    return $result;
                })                
                ->addColumn('etalase', function ($row) {
                    $etalase = $row->bm_kode == '' ? '0': $row->bm_etalase;

                    if($etalase == 0){
                        $hasil = '<span class="">'.$etalase.'</span>';
                    } else if($etalase > 0){
                        $hasil = '<span class="text-success">'.$etalase.'</span>';
                    } else {
                        $hasil = '<span class="text-danger">'.$etalase.'</span>';
                    }
                
                    return $hasil;
                })
                ->addColumn('letakG', function ($row) {
                    $letakG = $row->bm_kode == '' ? '-' : $row->bm_ltkgudang;

                    return $letakG;
                })
                ->addColumn('letakE', function ($row) {
                    $letakE = $row->bm_kode == '' ? '-' : $row->bm_ltketalase;

                    return $letakE;
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
                    $hakEdit = AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_menu.menu_judul' => 'Persediaan Obat', 'tbl_akses.akses_type' => 'update'))->count();
                    $hakDelete = AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')->where(array('tbl_akses.role_id' => Session::get('user')->role_id, 'tbl_menu.menu_judul' => 'Persediaan Obat', 'tbl_akses.akses_type' => 'delete'))->count();
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
                ->rawColumns(['action', 'tgl', 'customer', 'barang', 'satuan', 'jenisbarang', 'merk', 'jml', 'totalstok', 'etalase', 'letakG', 'letakE', 'tglexp', 'harga_jual', 'harga_beli', 'total_harga'])->make(true);
        }
    }

    public function listpersediaan(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
                ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
                ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
                ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
                ->orderBy('bm_id', 'DESC')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('img', function ($row) {
                    if ($row->barang_gambar == "image.png") {
                        $img = '<span class="avatar avatar-lg cover-image" style="background: url(&quot;' . url('/assets/default/barang') . '/' . $row->barang_gambar . '&quot;) center center;"></span>';
                    } else {
                        $img = '<span class="avatar avatar-lg cover-image" style="background: url(&quot;' . asset('storage/barang/' . $row->barang_gambar) . '&quot;) center center;"></span>';
                    }
                    return $img;
                })
                ->addColumn('satuan', function ($row) {
                    $satuan = $row->satuan_nama ?? '-';
                    return $satuan;
                })
                ->addColumn('jenisbarang', function ($row) {
                    $jenisbarang = $row->jenisbarang_nama ?? '-';
                    return $jenisbarang;
                })
                ->addColumn('merk', function ($row) {
                    $merk = $row->merk_nama ?? '-';
                    return $merk;
                })
                ->addColumn('totalstok', function ($row) {
                    $totalstok = $row->bm_stok ?? '-';
                    $result = $totalstok == 0 ? '<span class="">'.$totalstok.'</span>' : ($totalstok > 0 ? '<span class="text-success">'.$totalstok.'</span>' : '<span class="text-danger">'.$totalstok.'</span>');
                    return $result;
                })
                ->addColumn('etalase', function ($row) {
                    $etalase = $row->bm_etalase ?? '0';
                    $hasil = $etalase == 0 ? '<span class="">'.$etalase.'</span>' : ($etalase > 0 ? '<span class="text-success">'.$etalase.'</span>' : '<span class="text-danger">'.$etalase.'</span>');
                    return $hasil;
                })
                ->addColumn('tglexp', function ($row) {
                    $tglexp = $row->bm_tglex ? Carbon::parse($row->bm_tglex)->translatedFormat('d F Y') : '-';
                    return $tglexp;
                })
                ->addColumn('harga_jual', function ($row) {
                    $harga_jual = $row->bm_hargajual ? 'Rp ' . number_format($row->bm_hargajual, 0) : '-';
                    return $harga_jual;
                })
                ->addColumn('action', function ($row) use ($request) {
                    $array = [
                        "bm_id" => $row->bm_id,
                        "bm_kode" => $row->bm_kode,
                        "barang_kode" => $row->barang_kode,
                        "barang_nama" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->barang_nama)),
                        "satuan_nama" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->satuan_nama)),
                        "jenisbarang_nama" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->jenisbarang_nama)),
                        "merk_nama" => trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $row->merk_nama)),
                        "bm_tglex" => $row->bm_tglex,
                        "bm_hargajual" => $row->bm_hargajual,
                        "bm_stok" => $row->bm_stok,
                        "bm_etalase" => $row->bm_etalase,
                    ];
                    $button = '';
                    if ($request->get('param') == 'tambah') {
                        $button .= '<div class="g-2"><a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick=pilihBarang(' . json_encode($array) . ')>Pilih</a></div>';
                    } else {
                        $button .= '<div class="g-2"><a class="btn btn-success btn-sm" href="javascript:void(0)" onclick=pilihBarangU(' . json_encode($array) . ')>Pilih</a></div>';
                    }
                    return $button;
                })
                ->rawColumns(['action', 'img', 'satuan', 'jenisbarang', 'merk', 'totalstok', 'etalase', 'tglexp', 'harga_jual'])
                ->make(true);
        }
    }
    
    public function getpersediaan($id)
    {
        $data = BarangmasukModel::leftJoin('tbl_barang', 'tbl_barang.barang_kode', '=', 'tbl_barangmasuk.barang_kode')
            ->leftJoin('tbl_satuan', 'tbl_satuan.satuan_id', '=', 'tbl_barang.satuan_id')
            ->leftJoin('tbl_jenisbarang', 'tbl_jenisbarang.jenisbarang_id', '=', 'tbl_barang.jenisbarang_id')
            ->leftJoin('tbl_merk', 'tbl_merk.merk_id', '=', 'tbl_barang.merk_id')
            ->where('tbl_barangmasuk.bm_id', $id)
            ->orderBy('bm_id', 'DESC')
            ->get();
        return response()->json($data);
    }   

    public function proses_ubah(Request $request, BarangmasukModel $barangmasuk)
    {
        
            $validatedData = $request->validate([
                'bm_kode' => 'required',
                'tgl_masuk' => 'required|date',
                'barang_kode' => 'required',
                'customer_id' => 'required',
                'jml_masuk' => 'required|numeric',
                'tgl_kadaluarsa' => 'required|date',
                'harga_jual' => 'required|numeric',
                'harga_beli' => 'required|numeric',
                'total_stok' => 'required|numeric',
                'etalase' => 'required|numeric',
                'letak_gudang' => 'required|string',
                'letak_etalase' => 'required|string',
            ]);

            $validatedData['barang_kode'] = str_replace(' ', '_', strtolower(trim(preg_replace('/[^A-Za-z0-9\s-]+/', '-', $validatedData['barang_kode']))));

            $barangmasuk->update([
                'bm_kode' => $validatedData['bm_kode'],
                'bm_tanggal' => $validatedData['tgl_masuk'],
                'barang_kode' => $validatedData['barang_kode'],
                'customer_id' => $validatedData['customer_id'],
                'bm_jumlah' => $validatedData['jml_masuk'],
                'bm_tglex' => $validatedData['tgl_kadaluarsa'],
                'bm_hargajual' => $validatedData['harga_jual'],
                'bm_hargabeli' => $validatedData['harga_beli'],
                'bm_stok' => $validatedData['total_stok'],
                'bm_etalase' => $validatedData['etalase'],
                'bm_ltkgudang' => $validatedData['letak_gudang'],
                'bm_ltketalase' => $validatedData['letak_etalase'],
            ]);            

            return response()->json(['success' => true]);
    }

    public function hapus($id)
    {
        try {
            \Log::info('ID diterima: ' . $id);

            // Cari data barang masuk berdasarkan primary key (bm_id)
            $barangmasuk = BarangmasukModel::find($id);

            if ($barangmasuk) {
                \Log::info('Data ditemukan, akan dihapus');
                $barangmasuk->delete();
                return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
            }

            \Log::warning('Data tidak ditemukan');
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus data']);
        }
    }
}



