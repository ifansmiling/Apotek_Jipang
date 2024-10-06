<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barang";
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'merk_id',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'customer_id',
        'barang_gambar',
    ]; 
    
    // Relasi ke BarangmasukModel
    public function barangMasuk()
    {
        return $this->hasMany(BarangmasukModel::class, 'barang_kode', 'barang_kode');
    }
}
