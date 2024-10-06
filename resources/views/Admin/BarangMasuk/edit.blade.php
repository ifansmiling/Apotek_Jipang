<!-- MODAL EDIT -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemoEdit">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Obat Masuk</h6>
                <button onclick="resetEdit()" aria-label="Close" class="btn-close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bmkodeEdit" class="form-label">No Nota <span class="text-danger">*</span></label>
                            <input type="text" name="bmkodeEdit" id="bmkodeEdit" class="form-control" placeholder="Masukkan Nomor Nota">
                        </div>
                        <div class="form-group">
                            <label for="tglmasukEdit" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="tglmasukEdit" id="tglmasukEdit" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customerEdit" class="form-label">Pilih Supplier <span class="text-danger">*</span></label>
                            <select name="customerEdit" id="customerEdit" class="form-control">
                                <option value="">-- Pilih Supplier --</option>
                                <!-- Supplier data dari server -->
                                @foreach ($customer as $c)
                                <option value="{{ $c->customer_id }}">{{ $c->customer_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="hidden" id="statusEdit" value="true">
                                <div class="spinner-border spinner-border-sm d-none" id="loaderkdEdit" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </label>
                            <div class="form-input d-flex justify-content-end mt-3">
                                <input type="hidden" class="form-control" id="kdbarangEdit" autocomplete="off" name="kdbarangEdit" placeholder="">
                                <button class="btn btn-success" onclick="modalBarangEdit()" type="button">Tambah Obat <i class="fe fe-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-3-edit" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Tanggal Kadaluarsa</th>
                            <th class="border-bottom-0">Jumlah Masuk (/Satuan)</th>
                            <th class="border-bottom-0">Harga Jual (/Satuan)</th>
                            <th class="border-bottom-0">Harga Beli (/Satuan)</th>
                            <th class="border-bottom-0">Total Harga</th>
                            <th class="border-bottom-0">Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>  
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoaderEdit" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkFormEdit()" id="btnSimpanEdit" class="btn btn-primary">Simpan <i class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="resetEdit()" data-bs-dismiss="modal">Batal <i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function openModalEdit(id) {
    $.ajax({
        type: 'GET',
        url: "/admin/barang/getbarangmasuk/" + id,
        success: function(data) {
            $("input[name='bmkodeEdit']").val(data.bmkode);
            $("input[name='tglmasukEdit']").val(data.tglmasuk);
            $("select[name='customerEdit']").val(data.customer_id);

            // Populate tabel dengan data obat yang akan diedit
            fillEditTable(data.barangList);
            
            // Tampilkan modal edit
            $('#modaldemoEdit').modal('show');
        }
    });
}


function fillEditTable(barangList) {
    const tableBody = $("#table-3-edit tbody");
    tableBody.empty();
    barangList.forEach((barang, index) => {
        const newRow = $("<tr>");
        newRow.append("<td>" + (index + 1) + "</td>");
        newRow.append("<td>" + barang.kdbarang + "</td>");
        newRow.append("<td><input type='text' class='form-control' name='nmbarangEdit[]' value='" + barang.nmbarang + "' readonly></td>");
        newRow.append("<td><input type='text' class='form-control' name='satuanEdit[]' value='" + barang.satuan + "' readonly></td>");
        newRow.append("<td><input type='text' class='form-control' name='jenisEdit[]' value='" + barang.jenis + "' readonly></td>");
        newRow.append("<td><input type='date' name='tglkadaluarsaEdit[]' class='form-control' value='" + barang.tglkadaluarsa + "'></td>");
        newRow.append("<td><input type='text' name='jmlEdit[]' class='form-control' value='" + barang.jml + "'></td>");
        newRow.append("<td><input type='text' name='hargajualEdit[]' class='form-control' value='" + barang.hargajual + "'></td>");
        newRow.append("<td><input type='text' name='hargabeliEdit[]' class='form-control' value='" + barang.hargabeli + "'></td>");
        newRow.append("<td><input type='text' name='totalhargaEdit[]' class='form-control totalhargaEdit' value='" + barang.totalharga + "' readonly></td>");
        newRow.append("<td><button type='button' class='btn btn-danger' onclick='hapusBaris(this)'>Hapus</button></td>");
        tableBody.append(newRow);
    });
}


function hapusBaris(btn) {
    const row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function checkFormEdit() {
    // Lakukan validasi form sebelum menyimpan
    const isValid = validateFormEdit();
    if (isValid) {
        // Kumpulkan semua data dari tabel
        const editData = {
            bmkode: $("input[name='bmkodeEdit']").val(),
            tglmasuk: $("input[name='tglmasukEdit']").val(),
            customer: $("select[name='customerEdit']").val(),
            barang: [] // Array untuk menyimpan barang yang diedit
        };

        $("#table-3-edit tbody tr").each(function() {
            const row = $(this);
            editData.barang.push({
                kode: row.find("td:eq(1)").text(), // Kode barang
                tglKadaluarsa: row.find("input[name='tglkadaluarsaEdit[]']").val(),
                jml: row.find("input[name='jmlEdit[]']").val(),
                hargajual: row.find("input[name='hargajualEdit[]']").val(),
                hargabeli: row.find("input[name='hargabeliEdit[]']").val(),
                totalharga: row.find("input[name='totalhargaEdit[]']").val(),
            });
        });

        // Kirim editData ke server
        $.ajax({
            type: 'PUT',
            url: "/admin/barang/update", // Ganti URL sesuai dengan route
            data: editData,
            success: function(response) {
                // Handle sukses
                alert(response.success);
                resetEdit(); // Reset modal
                table.ajax.reload(); // Reload data tabel
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message);
            }
        });
    }
}


function validateFormEdit() {
    let isValid = true;

    // Contoh validasi sederhana
    const nota = $("input[name='bmkodeEdit']").val();
    if (nota === '') {
        alert("Nomor Nota tidak boleh kosong");
        isValid = false;
    }

    return isValid;
}

function resetEdit() {
    // Reset semua field pada modal edit
    $("input[name='bmkodeEdit']").val('');
    $("input[name='tglmasukEdit']").val('');
    $("select[name='customerEdit']").val('');
    $("#table-3-edit tbody").empty();
    $("#btnLoaderEdit").addClass("d-none");
    $("#btnSimpanEdit").removeClass("d-none");
}
</script>
