<?php echo $this->include('simta/simta_partial/dashboard/header'); ?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu'); ?>
<?php if (has_permission('admin')): ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else: ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif;?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="mt-2 page-title">Halaman Detail Pengajuan Bimbingan Tugas Akhir</h2>
                    </div>
                <?php if(has_permission('admin') || has_permission('dosen')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Detail Pengajuan Bimbingan Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php elseif(has_permission('mahasiswa')): ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right mb-0">
                            <li class="breadcrumb-item"><a href="<?= base_url('simta') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">SIMTA</a></li>
                            <li class="breadcrumb-item active">Detail Pengajuan Bimbingan Tugas Akhir</li>
                        </ol>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                        <tbody>
                        <table class="table">
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td><?php foreach($mahasiswa as $mhs) {
                                    echo ($pengajuanbimbingan->id_mhs == $mhs->id_mhs) ? $mhs->nama : ''; } ?>
                                </td>
                            </tr>
                            <tr>
                                <th>NIM Mahasiswa</th>
                                <td><?php foreach($mahasiswa as $mhs) {
                                    echo ($pengajuanbimbingan->id_mhs == $mhs->id_mhs) ? $mhs->nim : ''; } ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <td><?php foreach($mahasiswa as $mhs) {
                                    echo ($pengajuanbimbingan->id_mhs == $mhs->id_mhs) ? $mhs->kelas : ''; } ?>
                                </td>
                            </tr>
                            <tr>    
                                <th>Jadwal Bimbingan</th>
                                <td><?=date('d M Y', round($pengajuanbimbingan->jadwal_bimbingan/1000))?></td>
                            </tr>
                            <tr>
                                <th>Ruangan Bimbingan</th>
                                <td><?=$pengajuanbimbingan->ruang_bimbingan?></td>
                            </tr>
                            <tr>
                                <th>Status Ajuan</th>
                                <td><?=$pengajuanbimbingan->status_ajuan?></td>
                            </tr>
                            </tr>
                                <th>Hasil</th>
                                <td><?=$pengajuanbimbingan->hasil_bimbingan?></td>
                            </tr>
                        </table>
                        <?php if(has_permission('dosen')) : ?>
                                    <a href="<?=base_url('simta/pengajuanbimbingan/verifikasi/'. $pengajuanbimbingan->id_bimbingan);?>" class="btn btn-primary">Verifikasi</a>
                                <?php endif; ?>
                                <a href="<?=base_url('simta/pengajuanbimbingan');?>" class="btn btn-warning">Kembali</a>
                        <tbody>
                        </div>
                        </div>
                    </div>
                    <!-- Small table -->
                    </table>
                    </div>
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div>
    </div>
</div> 
</div> <!-- end section -->
</div> <!-- .col-12 -->
</div> <!-- .row -->
</div> <!-- .container-fluid -->
</main>

<?php echo $this->include('simta/simta_partial/dashboard/footer'); ?>