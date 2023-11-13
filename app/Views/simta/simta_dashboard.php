<?php echo $this->include('simta/simta_partial/dashboard/header');?>
<?php echo $this->include('simta/simta_partial/dashboard/top_menu');?>
<?php if(has_permission('admin')) : ?>
<?php echo $this->include('master_partial/dashboard/side_menu') ?>
<?php else : ?>
<?php echo $this->include('simta/simta_partial/dashboard/side_menu') ?>
<?php endif; ?><main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col mb-4 mt-2">
                        <h2 class="h5 page-title">Selamat Datang di SIM TA,
                            <?= user()->username; ?> &#128522 </h2>
                        <div class="file-container border-top">
                            <div class="mt-3">
                                <h5 class="mb-2">Form Pendaftaran</h5>
                                <p>Unduh berkas-berkas yang diperlukan untuk mendaftar kegiatan TA dibawah ini</p>
                                <div class="row my-4">
                                    <?php foreach ($berkas as $c) : ?>

                                    <div class="col-md-3">
                                        <!-- BERKAS -->

                                        <div class="card shadow text-center mb-4">
                                            <div class="card-body file">
                                                <div class="circle circle-lg bg-secondary my-2">
                                                    <span class="fe fe-folder fe-24 text-white"></span>
                                                </div>
                                                <div class="card-text my-2">
                                                    <strong class="card-title my-0"><?= $c->nama_berkas ?></strong>
                                                </div>
                                                <a class="button mb-0 my-1"
                                                    href="<?=base_url("download_berkas/$c->id_berkas");?>">
                                                    <span class="btn mb-2 btn-outline-primary">Download</span>
                                                </a>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->

                                    </div> <!-- .col -->
                                    <?php endforeach ?>
                                </div> <!-- .col -->
                            </div> <!-- .col -->
                        </div> <!-- .col -->
                    </div>
                </div>
                <!-- .card-body -->
            </div>
            <!-- .card -->
        </div>
        <!-- .card -->
    </div>
    <!-- .col -->
    </div>
    <div class="">
        <h2 class=""> Manual Book</h2>
    </div>



    <i class=" fe fe-book-open fa-2x">
    </i>




    </div>
    <!-- / .card-body -->
    </div>
    </div>
    <!-- / .card -->

    <!-- Striped rows -->
    </div>
    <!-- .row-->
    </div>
    <!-- .col-12 -->
    </div>
    <!-- .row -->
    </div>
    <!-- .container-fluid -->


</main>
<?php echo $this->include('simta/simta_partial/dashboard/footer');?>