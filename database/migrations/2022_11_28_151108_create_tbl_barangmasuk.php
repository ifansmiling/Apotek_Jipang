<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_barangmasuk', function (Blueprint $table) {
            $table->increments('bm_id');
            $table->string('bm_kode');
            $table->string('barang_kode');
            $table->string('customer_id');
            $table->string('bm_tanggal');
            $table->string('bm_jumlah');
            $table->string('bm_tglex');
            $table->string('bm_hargajual');
            $table->string('bm_hargabeli');
            $table->string('bm_totalharga');
            $table->string('bm_etalase');
            $table->string('bm_stok');
            $table->string('bm_ltkgudang');
            $table->string('bm_ltketalase');
            $table->string('bm_slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_barangmasuk');
    }
};
