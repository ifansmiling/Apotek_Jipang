<!-- MODAL EDIT -->
<div class="modal fade" data-bs-backdrop="static" id="Umodaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Obat Masuk</h6>
                <button aria-label="Close" onclick="resetU()" class="btn-close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="idbmU">
                        <input type="hidden" name="totalhargaU" value="">
                        <div class="form-group">
                            <label for="bmkodeU" class="form-label">Kode Obat Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="bmkodeU" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglmasukU" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="tglmasukU" class="form-control datepicker-date" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customerU" class="form-label">Pilih Supplier <span class="text-danger">*</span></label>
                            <select name="customerU" id="customerU" class="form-control" disabled>
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($customer as $c)
                                <option value="{{ $c->customer_id }}">{{ $c->customer_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Obat <span class="text-danger me-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" autocomplete="off" name="kdbarangU" placeholder="" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Obat</label>
                            <input type="text" class="form-control" id="nmbarangU" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuanU" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <input type="text" class="form-control" id="jenisU" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" class="form-control" id="merkU" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jmlU" class="form-label">Jumlah Masuk (/Satuan) <span class="text-danger">*</span></label>
                            <input type="text" name="jmlU" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tglkadaluarsaU" class="form-label">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                            <input type="text" name="tglkadaluarsaU" class="form-control datepicker-date" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hargajualU" class="form-label">Harga Jual (/Satuan) <span class="text-danger">*</span></label>
                            <input type="text" name="hargajualU" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hargabeliU" class="form-label">Harga Beli (/Satuan) <span class="text-danger">*</span></label>
                            <input type="text" name="hargabeliU" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="totalstokU" class="form-label">Stok Gudang</label>
                            <input type="text" name="totalstokU" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="etalaseU" class="form-label">Etalase</label>
                            <input type="text" name="etalaseU" class="form-control" oninput="this.value = this.value.replace(/[^-0-9]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^-/, '-').replace(/^0[^.]/, '0');" placeholder="">
                            <small class="text-danger" style="color: red;">*Untuk mengurangi etalase dan mengembalikan barang ke gudang gunakan tanda minus (-)</small>
                        </div>
                        <div class="form-group">
                            <label for="letakGU" class="form-label">Letak Gudang</label>
                            <input type="text" name="letakGU" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="letakEU" class="form-label">Letak Etalase</label>
                            <input type="text" name="letakEU" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success d-none" id="btnLoaderU" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkFormU()" id="btnSimpanU" class="btn btn-success">Simpan Perubahan <i class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="resetU()" data-bs-dismiss="modal">Batal <i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

@section('formEditJS')
<script>
    $('input[name="kdbarangU"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            getbarangbyidU($('input[name="kdbarangU"]').val());
        }
    });

    function modalBarangU() {
        $('#modalBarang').modal('show');
        $('#Umodaldemo8').addClass('d-none');
        $('input[name="param"]').val('ubah');
        resetValidU();
        table2.ajax.reload();
    }

    function getbarangbyidU(id) {
        $("#loaderkdU").removeClass('d-none');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/barang/getbarang') }}/" + id,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    $("#loaderkdU").addClass('d-none');
                    $("#nmbarangU").val(data[0].barang_nama);
                    $("#satuanU").val(data[0].satuan_nama);
                    $("#jenisU").val(data[0].jenisbarang_nama);
                    $("#merkU").val(data[0].merk_nama);
                } else {
                    $("#loaderkdU").addClass('d-none');
                    $("#nmbarangU").val('');
                    $("#satuanU").val('');
                    $("#jenisU").val('');
                    $("#merkU").val('');
                }
            }
        });
    }

    let totalStokAwalU;

    function hitungTotalStokU() {
        const totalStokSebelumnya = totalStokAwalU || parseInt($("input[name='totalstokU']").val());
        const etalase = parseInt($("input[name='etalaseU']").val()) || 0;
        
        let totalStok;
        if (totalStokAwalU == 0 && etalase > 0){
            totalStok = 0;
        }else if (totalStokAwalU == 0 && etalase < 0){
            totalStok = -etalase;
        }else{
            totalStok = totalStokSebelumnya - etalase;
        }

        $("input[name='totalstokU']").val(totalStok);
    }

    $("input[name='etalaseU']").on('input', function() {
        if (!totalStokAwalU) {
            totalStokAwalU = parseInt($("input[name='totalstokU']").val());
        }
        hitungTotalStokU();
    });

    function resetU() {
        $('input[name="idbmU"]').val("");
        $('input[name="bmkodeU"]').val("");
        $('input[name="totalhargaU"]').val("");
        $('input[name="jmlU"]').val("");
        $('input[name="kdbarangU"]').val("");
        $('input[name="tglkadaluarsaU"]').val("");
        $('input[name="nmbarangU"]').val("");
        $('input[name="satuanU"]').val("");
        $('input[name="jenisU"]').val("");
        $('input[name="merkU"]').val("");
        $('input[name="etalaseU"]').val("");
        $('input[name="letakGU"]').val("");
        $('input[name="letakEU"]').val("");
        $('input[name="totalstokU"]').val("");
        $('input[name="hargajualU"]').val("");
        $('input[name="hargabeliU"]').val("");
        $('select[name="customerU"]').val("").trigger("change");
        $('input[name="tglmasukU"]').val("");
    }

    function checkFormU() {
        const isEmptyField = !$('input[name="bmkodeU"]').val() || 
                            !$('input[name="tglmasukU"]').val() || 
                            !$('select[name="customerU"]').val() || 
                            !$('input[name="kdbarangU"]').val() ||
                            !$('input[name="jmlU"]').val() ||
                            !$('input[name="tglkadaluarsaU"]').val() || 
                            !$('input[name="hargajualU"]').val() ||
                            !$('input[name="hargabeliU"]').val() ||
                            !$('input[name="totalstokU"]').val();

        if (isEmptyField) {
            swal("Terjadi Kesalahan!", "Mohon Lengkapi Form Inputan yang Bertanda *", "error");
            return false;
        }

        $("#btnSimpanU").addClass('d-none');
        $("#btnLoaderU").removeClass('d-none');

        submitFormU();
    }

    function submitFormU() {
        const id = $("input[name='idbmU']").val();
        const data = {
            bm_kode: $("input[name='bmkodeU']").val(),
            tgl_masuk: $("input[name='tglmasukU']").val(),
            barang_kode: $("input[name='kdbarangU']").val(),
            customer_id: $("select[name='customerU']").val(),
            jml_masuk: $("input[name='jmlU']").val(),
            tgl_kadaluarsa: $("input[name='tglkadaluarsaU']").val(),
            harga_jual: $("input[name='hargajualU']").val(),
            harga_beli: $("input[name='hargabeliU']").val(),
            total_stok: $("input[name='totalstokU']").val(),
            etalase: $("input[name='etalaseU']").val(),
            letak_gudang: $("input[name='letakGU']").val(),
            letak_etalase: $("input[name='letakEU']").val(),
        };

        $.ajax({
            type: 'POST',
            url: "{{ url('admin/persediaan/proses_ubah/data/') }}/" + id,
            data: data,
            success: function(response) {
                if (response.success) {
                    swal("Berhasil diubah!", "", "success");
                    $('#Umodaldemo8').modal('toggle');
                    table.ajax.reload(null, false);
                    resetU();
                } else {
                    swal("Gagal!", "Periksa kembali inputan Anda.", "error");
                }
            },
            error: function() {
                swal("Terjadi kesalahan!", "Coba lagi nanti.", "error");
            }
        });
    }
</script>
@endsection
