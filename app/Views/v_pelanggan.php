<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="stylesheet" href="assets/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Daftar Pelanggan</h1>

        <div class="d-flex justify-content-end mb-3">
            <button type="button" id="addButton" class="btn btn-success w-20 float-right">
                <i class="fas fa-cart-plus me-2"></i> Tambah Data
            </button>
        </div>

        <table class="table table-bordered table-hover table-rounded">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $pelanggan): ?>
                        <tr>
                            <td><?= $pelanggan['id_pelanggan'] ?></td>
                            <td><?= $pelanggan['nama_pelanggan'] ?></td>
                            <td><?= $pelanggan['alamat_pelanggan'] ?></td>
                            <td><?= $pelanggan['no_telp'] ?></td>
                            <td>
                                <button type="button" id="editButton" data-id="<?= $pelanggan['id_pelanggan'] ?>"
                                    class="btn btn-warning btn-sm me-3 editButton">
                                    <i class="fas fa-pencil me-2"></i>Edit
                                </button>
                                <button type="button" id="deleteButton" data-id="<?= $pelanggan['id_pelanggan'] ?>"
                                    class="btn btn-danger btn-sm deleteButton">
                                    <i class="fas fa-trash me-2"></i>Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pelanggan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?= $pager->links('pelanggan', 'bootstrap_pagination') ?>
    </div>

    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="assets/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    
    <script>
        document.getElementById('addButton').addEventListener('click', function () {
            Swal.fire({
                width: "50%",
                title: 'Masukkan Data Pelanggan',
                html: `
                <div class="text-start pt-3">
                    <label for="name" class="mb-2">Nama Pelanggan</label>
                    <input name="name" id="customerName" class="form-control mb-4 p-2" placeholder="Nama" required>
                    
                    <label for="phone" class="mb-2">No.Telp</label>
                    <input name="phone" id="customerPhone" class="form-control mb-4 p-2" placeholder="No. Telp" required>

                    <label for="address" class="mb-2">Alamat</label>
                    <textarea name="address" id="customerAddress" class="form-control mb-4 p-2" style="height: 100px;" placeholder="Alamat" required></textarea>
                </div>
                <button id="submitButton" class="btn btn-primary btn-md float-end">Simpan</button>
                `,
                focusConfirm: false,
                showCloseButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    document.getElementById('submitButton').addEventListener('click', function (e) {
                        e.preventDefault();

                        const name = document.getElementById('customerName').value;
                        const address = document.getElementById('customerAddress').value;
                        const phone = document.getElementById('customerPhone').value;

                        fetch('/pelanggan/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                            },
                            body: JSON.stringify({ name, address, phone }),
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal menyimpan data');
                            }
                            return response.json;
                        }).then(data => {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data pelanggan berhasil disimpan',
                                icon: 'success',
                            }).then(() => {
                                location.reload();
                            });
                        }).catch(error => {
                            Swal.fire({
                                title: 'Error',
                                text: error.message,
                                icon: 'error'
                            });
                        })
                    })
                }
            })
        });
    </script>
    <script>
        document.querySelectorAll('.editButton').forEach(button => {
            button.addEventListener('click', function () {
                const idPelanggan = this.getAttribute('data-id');

                fetch(`/pelanggan/${idPelanggan}`).then(response => response.json()).then(pelanggan => {
                    if (pelanggan) {
                        Swal.fire({
                            width: '50%',
                            title: 'Edit Data Pelanggan',
                            html: `
                                <div class="text-start pt-3">
                                    <label for="name" class="mb-2">Nama Pelanggan</label>
                                    <input name="name" id="customerName" class="form-control mb-4 p-2" placeholder="Nama" value="${pelanggan.nama_pelanggan}" required>
                                    
                                    <label for="phone" class="mb-2">No.Telp</label>
                                    <input name="phone" id="customerPhone" class="form-control mb-4 p-2" placeholder="No. Telp" value="${pelanggan.no_telp}" required>

                                    <label for="address" class="mb-2">Alamat</label>
                                    <textarea name="address" id="customerAddress" class="form-control mb-4 p-2" style="height: 100px;" placeholder="Alamat" required>${pelanggan.alamat_pelanggan}</textarea>
                                </div>
                                <button id="submitButton" class="btn btn-primary btn-md float-end">Simpan</button>
                                `,
                            focusConfirm: false,
                            showCloseButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                document.getElementById('submitButton').addEventListener('click', function (e) {
                                    e.preventDefault();

                                    const name = document.getElementById('customerName').value;
                                    const address = document.getElementById('customerAddress').value;
                                    const phone = document.getElementById('customerPhone').value;

                                    fetch(`/pelanggan/update/${idPelanggan}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                                        },
                                        body: JSON.stringify({ name, address, phone }),
                                    }).then(response => response.json()).then(data => {
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Data pelanggan berhasil diperbarui',
                                            icon: 'success',
                                        }).then(() => {
                                            location.reload();
                                        });
                                    }).catch(error => {
                                        Swal.fire({
                                            title: 'Error',
                                            text: error.message,
                                            icon: 'error'
                                        });
                                    });
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Data pelanggan tidak ditemukan',
                            icon: 'error'
                        });
                    }
                }).catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal mengambil data pelanggan',
                        icon: 'error'
                    });
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function () {
                const idPelanggan = this.getAttribute('data-id');

                fetch(`/pelanggan/${idPelanggan}`).then(response => response.json()).then(pelanggan => {
                    if (pelanggan) {
                        Swal.fire({
                            width: '33rem',
                            title: 'Hapus Data Pelanggan',
                            icon: 'warning',
                            html: `
                                <p class="swal2-text mt-5 mb-5">Apakah anda yakin ingin menghapus data pelanggan ini?</p>
                                <button id="submitButton" class="btn btn-primary btn-md me-2">Ya, hapus!</button>
                                <button id="cancelButton" class="btn btn-danger btn-md">Batalkan!</button>
                                `,
                            focusConfirm: false,
                            showCloseButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                document.getElementById('submitButton').addEventListener('click', function (e) {
                                    e.preventDefault();

                                    fetch(`/pelanggan/delete/${idPelanggan}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                                        },
                                    }).then(response => response.json()).then(data => {
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Data pelanggan berhasil dihapus',
                                            icon: 'success',
                                        }).then(() => {
                                            location.reload();
                                        });
                                    }).catch(error => {
                                        Swal.fire({
                                            title: 'Error',
                                            text: error.message,
                                            icon: 'error'
                                        });
                                    });
                                });
                            },
                            didOpen: () => {
                                document.getElementById('cancelButton').addEventListener('click', function() {
                                    Swal.close();
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Data pelanggan tidak ditemukan',
                            icon: 'error'
                        });
                    }
                }).catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal mengambil data pelanggan',
                        icon: 'error'
                    });
                });
            });
        });
    </script>
</body>

</html>