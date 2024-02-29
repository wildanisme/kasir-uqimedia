<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengaturan Kehadiran</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengaturan Kehadiran</li>
        </ol>
    </div>
    <?php
        echo $this->session->flashdata('message');
    ?>
    <div class="row">
        <div class="col-md-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <form id="simpan_data" method="POST" action="<?=base_url();?>absen/save_pengaturan">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="toleransi_shift_1">Toleransi Masuk Shift I</label>
                                <input type="text" class="form-control jam" id="toleransi_shift_1" name="toleransi_shift_1" value="<?=jam_ambil($row['toleransi_shift_1']);?>">
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jam_masuk_shift_1">Jam Masuk Shift I</label>
                                <input type="text" class="form-control jam" id="jam_masuk_shift_1" name="jam_masuk_shift_1" value="<?=jam_ambil($row['jam_masuk_shift_1']);?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jam_pulang_shift_1">Jam Pulang Shift I</label>
                                <input type="text" class="form-control jam" id="jam_pulang_shift_1" name="jam_pulang_shift_1" value="<?=jam_ambil($row['jam_pulang_shift_1']);?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="toleransi_shift_2">Toleransi Masuk Shift II</label>
                                <input type="text" class="form-control jam" id="toleransi_shift_2" name="toleransi_shift_2" value="<?=jam_ambil($row['toleransi_shift_2']);?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jam_masuk_shift_2">Jam Masuk Shift II</label>
                                <input type="text" class="form-control jam" id="jam_masuk_shift_2" name="jam_masuk_shift_2" value="<?=jam_ambil($row['jam_masuk_shift_2']);?>">
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jam_pulang_shift_2">Jam Pulang Shift II</label>
                                <input type="text" class="form-control jam" id="jam_pulang_shift_2" name="jam_pulang_shift_2" value="<?=jam_ambil($row['jam_pulang_shift_2']);?>">
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="toleransi_shift_2">Jumlah Hari Libur</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" id="jumlah_libur" name="jumlah_libur" value="<?=$row['jumlah_libur'];?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Hari</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hari_kerja">Jumlah Hari Kerja</label>
                                <div class="input-group mb-1">
                                    <input type="number" class="form-control" id="hari_kerja" name="hari_kerja" value="<?=$row['hari_kerja'];?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Hari</span>
                                    </div>
                                    <button type="button" class="btn btn-info cek_hari">Cek jumlah hari</button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!--Row-->
    </div>
</div>
<script>
    $('.jam').clockpicker({
        autoclose: true
    });
    $(".cek_hari").click(function(){
        var libur = $('#jumlah_libur').val();
        var bulan = moment().month();
        var tahun =moment().year()
        var j_hari=hitunghari(bulan,tahun) - libur;
        $('#hari_kerja').val(j_hari);
    });
    
    var hitunghari=function(bulan,taun){
        return new Date(taun,bulan,0).getDate()
    }
</script>