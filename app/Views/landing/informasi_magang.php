<?php echo $this->include('master_partial/landing/header');?>
<?php echo $this->include('master_partial/landing/navbar');?> 
    <style>
        :root {
        --warna: <?php echo $cms->warna_bg ?>;
        }
    </style>  
<div class="hero-wrap hero-wrap-2" style="background-image: url('../landing_assets/images/bg_2.jpg'); background-attachment:fixed;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url('landing')?>">Home</a></span> <span>Informasi Magang</span></p>
            <h1 class="mb-3 bread">Informasi Magang</h1>
          </div>
        </div>
      </div>
</div> 
<section class="ftco-section">
    	<div class="container">
    		<div class="row">
              <?php foreach ($informasi_magang as $im): ?>
                <div class="col-md-4 d-flex ftco-animate">
                  <div class="course align-self-stretch">
                    <div class=" col-md-12 text p-4">
                      <p class="category"><span><?=$im->nama_perusahaan ?></span></p>
                      <h3 class="mb-3"><a href="#"><?=$im->posisi_magang ?></a></h3>
                      <p>Lowongan ditutup pada tanggal : <?=$im->batas_akhir ?></p>
                      <p><a href="<?= base_url("informasi_magang_detail/$im->id_informasi_magang"); ?>" class="btn btn-primary btn-block">Selengkapnya</a></p>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
    		</div>
    		<div class="row mt-5">
          <div class="col text-center">
            <div class="block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
    	</div>
</section>
<?php echo $this->include('master_partial/landing/footer');?>  