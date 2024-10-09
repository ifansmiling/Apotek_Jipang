<!-- MODAL HAPUS -->
<div class="modal fade" data-bs-backdrop="static" id="Hmodaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body text-center p-4 pb-5">
                <button type="reset" aria-label="Close" onclick="resetH()" class="btn-close position-absolute" data-bs-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <br>
                <i class="icon icon-exclamation fs-70 text-warning lh-1 my-5 d-inline-block"></i>
                <h3 class="mb-5">Yakin hapus <span id="vbm"></span> ?</h3>
                <input type="hidden" name="idbm" id="idbm">
                <button class="btn btn-danger-light pd-x-25 d-none" id="btnLoaderH" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button onclick="submitFormH()" class="btn btn-danger-light pd-x-25" id="btnSubmit">Iya</button>
                <button type="reset" data-bs-dismiss="modal" class="btn btn-default pd-x-25">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Meta tag for CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('formHapusJS')
<script>
    function hapus(data) {
        // Menampilkan informasi barang di modal
        $('#idbm').val(data.bm_id); // Memasukkan ID barang masuk ke hidden input
        $('#vbm').text(data.bm_kode); // Menampilkan bm_kode di modal untuk konfirmasi
    }

    function submitFormH() {
        setLoadingH(true);
        const id = $("input[name='idbm']").val(); // Mengambil ID dari hidden input
        
        console.log('ID yang akan dihapus:', id); // Debugging: memastikan ID sudah benar
        
        $.ajax({
            type: 'POST',
            url: "{{url('admin/barang-masuk/proses_hapus/data/')}}/" + id, // Mengirim ID dalam URL
            enctype: 'multipart/form-data',
            success: function(data) {
                if (data.success) {
                    swal({
                        title: "Berhasil dihapus!",
                        type: "success"
                    });
                    $('#Hmodaldemo8').modal('toggle'); // Tutup modal
                    table.ajax.reload(null, false); // Reload tabel setelah penghapusan berhasil
                    resetH();
                } else {
                    swal({
                        title: "Gagal menghapus!",
                        text: data.message,
                        type: "error"
                    });
                }
            },
            error: function(xhr) {
                swal({
                    title: "Terjadi kesalahan!",
                    text: xhr.responseJSON ? xhr.responseJSON.message : "Gagal menghapus data",
                    type: "error"
                });
            }
        });
    }

    function resetH() {
        $("input[name='idbm']").val(''); // Reset hidden input
        setLoadingH(false);
    }

    function setLoadingH(bool) {
        if (bool == true) {
            $('#btnLoaderH').removeClass('d-none');
            $('#btnSubmit').addClass('d-none');
        } else {
            $('#btnSubmit').removeClass('d-none');
            $('#btnLoaderH').addClass('d-none');
        }
    }
</script>

@endsection
