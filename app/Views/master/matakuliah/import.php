<?php echo $this->include('master_partial/dashboard/header'); ?>
<?php echo $this->include('master_partial/dashboard/top_menu'); ?>
<?php echo $this->include('master_partial/dashboard/side_menu'); ?>
<main role="main" class="main-content">
    <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="page-title">File Uploads</h2>
              <p class="lead text-muted">Demo for form control styles, layout options, and custom components for creating a wide variety of forms.</p>
              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <strong>Dropzone</strong>
                    </div>
                    <div class="card-body">
                      <form action="/file-upload" class="dropzone bg-light rounded-lg" id="tinydash-dropzone">
                        <div class="dz-message needsclick">
                          <div class="circle circle-lg bg-primary">
                            <i class="fe fe-upload fe-24 text-white"></i>
                          </div>
                          <h5 class="text-muted mt-4">Drop files here or click to upload</h5>
                        </div>
                      </form>
                      <!-- Preview -->
                      <!-- <div class="dropzone-previews mt-3" id="file-previews"></div> -->
                      <!-- file preview template -->
                      <div class="d-none" id="uploadPreviewTemplate">
                        <div class="card mt-1 mb-0 shadow-none border">
                          <div class="p-2">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                              </div>
                              <div class="col pl-0">
                                <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                                <p class="mb-0" data-dz-size></p>
                              </div>
                              <div class="col-auto">
                                <!-- Button -->
                                <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                  <i class="dripicons-cross"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col -->
              </div> <!-- .row -->
            </div>
          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
</main> <!-- main -->
<?php echo $this->include('master_partial/dashboard/footer'); ?>