<?php echo $this->include('mbkm/mbkm_partial/dashboard/header'); ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/side_menu') ?>
<?php endif;?>
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Form Edit Status MBKM Hibah</h2>
                <div class="row my-4">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="<?=base_url('mbkm/mbkmFix/update-status-mhs/' . $mbkmFix->id_mbkm_fix)?>">
                                    <div class="form-group mb-3">
                                        <label for="simple-select2">Status Mahasiswa</label>
                                        <select class="form-control select2" name="status_mahasiswa"
                                            id="simple-select2">
                                            <option value="">Pilih Status</option>
                                            <option value="pending"
                                                <?= $mbkmFix->status_mahasiswa == 'pending' ? 'selected' : ''?>>
                                                Pending
                                            </option>
                                            <option value="proses seleksi"
                                                <?= $mbkmFix->status_mahasiswa == 'proses seleksi' ? 'selected' : ''?>>
                                                Proses seleksi</option>
                                            <option value="lolos"
                                                <?= $mbkmFix->status_mahasiswa == 'lolos' ? 'selected' : ''?>>
                                                lolos</option>
                                            <option value="tidak lolos"
                                                <?= $mbkmFix->status_mahasiswa == 'tidak lolos' ? 'selected' : ''?>>
                                                tidak lolos</option>
                                            <option value="diambil"
                                                <?= $mbkmFix->status_mahasiswa == 'diambil' ? 'selected' : ''?>>
                                                diambil</option>
                                            <option value="tidak diambil"
                                                <?= $mbkmFix->status_mahasiswa == 'tidak diambil' ? 'selected' : ''?>>
                                                tidak diambil</option>
                                        </select>
                                        <!-- Error Validation -->

                                    </div>





                                    <button class="btn btn-primary" type="submit">
                                        Edit
                                    </button>
                                    <a href="<?=base_url('mbkm/mbkmFix');?>" class="btn btn-warning">Kembali</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- end section -->
            </div>
            <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container-fluid -->
</main>
<?php echo $this->include('mbkm/mbkm_partial/dashboard/footer'); ?>