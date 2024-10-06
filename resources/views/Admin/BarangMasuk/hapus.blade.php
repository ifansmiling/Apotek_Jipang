<!-- MODAL HAPUS -->
<div class="modal fade" data-bs-backdrop="static" id="Hmodaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-body text-center p-4 pb-5">
                <button type="reset" aria-label="Close" onclick="resetH()" class="btn-close position-absolute" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                <br>
                <i class="icon icon-exclamation fs-70 text-warning lh-1 my-5 d-inline-block"></i>
                <h3 class="mb-5">Yakin hapus semua barang dengan kode <span id="vbm"></span> ?</h3>
                <input type="hidden" name="bmkode" id="bmkode"> <!-- Simpan bm_kode dari nota -->
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


<script>
    function submitFormH() {
    setLoadingH(true);
    const bm_kode = $("input[name='bmkode']").val(); // Ambil bm_kode untuk dikirim ke server
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/barang-masuk/proses_hapus') }}/" + bm_kode,  // URL untuk proses hapus
        data: {},  // Tidak perlu mengirimkan bm_kode dalam body
        success: function(data) {
            swal({
                title: "Berhasil dihapus!",
                type: "success"
            });
            $('#Hmodaldemo8').modal('toggle'); // Tutup modal
            table.ajax.reload(null, false);  // Reload tabel
            resetH();
        },
        error: function(xhr) {
            // Menangani error
            swal({
                title: "Gagal!",
                text: xhr.responseJSON.error || "Terjadi kesalahan.",
                type: "error"
            });
            setLoadingH(false);
        }
    });
}


    function resetH() {
        $("input[name='bmkode']").val(''); // Reset input bm_kode
        setLoadingH(false);
    }

    function setLoadingH(bool) {
        if (bool) {
            $('#btnLoaderH').removeClass('d-none');
            $('#btnSubmit').addClass('d-none');
        } else {
            $('#btnSubmit').removeClass('d-none');
            $('#btnLoaderH').addClass('d-none');
        }
    }
</script>
