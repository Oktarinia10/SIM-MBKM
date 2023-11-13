
    <?php echo $this->include('bot/bot_partial/dashboard/header'); ?>
    <?php echo $this->include('bot/bot_partial/dashboard/top_menu'); ?>
    <?php echo $this->include('master_partial/dashboard/side_menu'); ?>
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h2 class="page-title">Blast Chat</h2>
                        </div>
                        <?php if(has_permission('admin')) : ?>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right text-sm">
                                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>"><small>Dashboard</small></a></li>
                                    <li class="breadcrumb-item active"><a href="<?= base_url('bot/blast_chat') ?>"><small>Blast Chat</small></a></li>
                                    <li class="breadcrumb-item active"><a href="<?= base_url('bot/blast_chat/terjadwal/pilih_penerima') ?>"><small>Pilih Penerima</small></a></li>
                                    <li class="breadcrumb-item active"><small>Multiplatform Terjadwal</small></li>
                                </ol>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-12">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <strong class="card-title">Kirim Pesan Multiplatform Terjadwal</strong>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?=base_url("bot/blast_chat/terjadwal/kirim")?>" onsubmit="return disableButton()">
                                        <div class="form-group row">
                                            <label class="col-sm-3" for="inputPenerima">Penerima</label>
                                            <div class="col-sm-9">
                                                <select name="id_recipient" id="inputPenerima" rows="2" class="form-control select2 <?= ($validation->hasError('id_recipient')) ? 'is-invalid' : ''; ?>">
                                                    <option>Pilih Penerima</option>
                                                    <?php foreach ($recipient as $s) : ?>
                                                        <?php if ($identitas == 'staff') : ?>
                                                            <option value="<?= $s->id_staf ?>"><?= $s->nama ?></option>
                                                        <?php elseif ($identitas == 'mahasiswa') : ?>
                                                            <option value="<?= $s->id_mhs ?>"><?= $s->nama ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('id_recepient'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">Platform</div>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="platform[]" value="email">
                                                    <label class="form-check-label" for="gridCheck1">
                                                        <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Femail.png?alt=media&token=fb081954-5bb9-4b12-b8be-c45db6976816" alt="Email Icon" width="20" height="20"> Email
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck2" name="platform[]" value="whatsapp">
                                                    <label class="form-check-label" for="gridCheck2">
                                                        <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Fwa.png?alt=media&token=97f48b34-b099-4a0d-a0e5-87fc2f05e174" alt="Whatsapp Icon" width="20" height="20"> Whatsapp
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="gridCheck3" name="platform[]" value="telegram">
                                                    <label class="form-check-label" for="gridCheck3">
                                                        <img src="https://firebasestorage.googleapis.com/v0/b/myfin-ktp.appspot.com/o/Logo%2Ftelegram.png?alt=media&token=cb49e0f5-f42c-4d38-b94f-0cf5bf8b8d9c" alt="Telegram Icon" width="20" height="20"> Telegram
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3" for="exampleFormControlTextarea1">Pesan</label>
                                            <div class="col-sm-9">
                                                <textarea name="pesan" class="form-control" id="exampleFormControlTextarea1" rows="2" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3" for="email_subject">Email Subject</label>
                                            <div class="col-sm-9">
                                                <input name="email_subject" class="form-control" id="email_subject" rows="2" placeholder="Wajib diisi jika platform Email dipilih"></input>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3" for="pesan_email">Pesan Email (Bisa HTML)</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="pesan_email" id="pesan_email" rows="2" placeholder="Wajib diisi jika platform Email dipilih"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExcelFile" class="col-sm-3 col-form-label">Lampiran Dokumen (PDF)</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="lampiran_file">
                                                   <label class="custom-file-label" for="customFile">Tambahkan Jika Diperlukan | PDF Maks. 5 Mb</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="list-group list-group-flush my-n3">
                                <div class="list-group-item">
                                <div class="row align-items-center">
                            <div class="col-auto">
                              <span class="circle circle-sm bg-success"><i class="fe fe-clock fe-16 text-white"></i></span>
                            </div>
                            <div class="col">
                              <medium><strong>Jadwal Pengiriman</strong></medium>
                              <div class="mb-2 text-muted medium"><strong class="mb-2 text-muted medium" >Anda dapat menambahkan lebih dari satu jadwal pengiriman pesan</strong></div>
                            </div>
                          </div> <!-- / .row -->
                          <br>
                         
                                        <div id="datetime-fields">
                                            <div class="form-group row">
                                                <label class="col-sm-3" for="exampleFormControlTextarea1">Pilih Tanggal</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group date">
                                                        <input name="tanggal[]" type="text" class="form-control drgpicker" aria-describedby="button-addon2" readonly>
                                                        <div class="input-group-append">
                                                          <div class="input-group-text" id="button-addon-date" >
                                                             <span class="fe fe-calendar fe-16"></span>
                                                          </div>
                                                          </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3" for="example-time">Pukul</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="example-time" type="time" name="time[]" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-outline-primary" onclick="addDateTimeField()">Tambah Tanggal</button>
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <button id="submitBtn" type="submit" class="btn btn-primary">Kirim Pesan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end section -->
                    </div>
                    <!-- .col-12 -->
                </div>
                <!-- .row -->
            </div>
            <!-- .container-fluid -->
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
            });

            function disableButton() {
                var submitBtn = document.getElementById("submitBtn");
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
                submitBtn.disabled = true;

                var emailCheckbox = document.getElementById("gridCheck1");
                var pesanEmail = document.getElementById("pesan_email").value;
                var emailSubject = document.getElementById("email_subject").value;

                if (emailCheckbox.checked && (pesanEmail.trim() === '' || emailSubject.trim() === '')) {
                    alert("Mohon lengkapi Pesan Email dan Subject Email.");
                    submitBtn.innerHTML = 'Kirim';
                    submitBtn.disabled = false;
                    return false;
                }

                return true;
            }

            function addDateTimeField() {
                var container = document.getElementById("datetime-fields");
                var template = document.createElement("div");
                template.innerHTML = `
                <hr>
                    <div class="form-group row">
                        <label class="col-sm-3" for="exampleFormControlTextarea1">Pilih Tanggal</label>
                        <div class="col-sm-9">
                            <div class="input-group date" data-provide="datepicker">
                                <input name="tanggal[]" type="text" class="form-control" readonly>
                                <div class="input-group-append">
                                                          <div class="input-group-text" id="button-addon-date" >
                                                             <span class="fe fe-calendar fe-16"></span>
                                                          </div>
                                                          </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3" for="example-time">Pukul</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="example-time" type="time" name="time[]" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-danger" onclick="removeDateTimeField(this)">Hapus</button>
                        </div>
                    </div>
                `;
                container.appendChild(template);
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
            }

            function removeDateTimeField(element) {
                var container = document.getElementById("datetime-fields");
                container.removeChild(element.parentNode.parentNode.parentNode);
            }
        </script>
    <?php echo $this->include('bot/bot_partial/dashboard/footer'); ?>
