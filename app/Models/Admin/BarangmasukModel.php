<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangmasukModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barangmasuk";
    protected $primaryKey = 'bm_id';
    protected $fillable = [
        'bm_kode',
        'barang_kode',
        'customer_id',
        'bm_tanggal',
        'bm_jumlah',
        'bm_tglex',
        'bm_hargajual',
        'bm_hargabeli',
        'bm_totalharga',
        'bm_etalase',
        'bm_stok',
        'bm_ltkgudang',
        'bm_ltketalase',
        'bm_slug',
        
    ]; 

    // Relasi ke BarangModel
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_kode', 'barang_kode');
    }
    
}
