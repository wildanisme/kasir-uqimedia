<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Form Penggajian</h1>
		<div class='btn-group' role='group'>
			<a href="#" class="btn btn-danger btn-icon-split klip">
				<span class="icon text-white-50">
					<i class="fa fa-folder fa-fw"></i>
				</span>
				<span class="text blink" id="klipp">Belum Direkap</span>
			</a>
			<a href="#" class="btn btn-primary btn-icon-split slip none" onclick="cekprint()">
				<span class="icon text-white-50">
					<i class="fa fa-print fa-fw"></i>
				</span>
				<span class="text">Cetak Slip Gaji</span>
			</a>
			<a href="#" class="btn btn-info btn-icon-split cetak-gaji">
				<span class="icon text-white-50">
					<i class="fa fa-print fa-fw"></i>
				</span>
				<span class="text">Cetak Semua</span>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Karyawan</span>
						</div>
						<select class="form-control" id="user" name="user">
							<?php foreach ($user as $val) { ?>
								<option value="<?= $val->id_user; ?>"><?= $val->nama_lengkap; ?></option>
							<?php } ?>
						</select>

						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<div id="date-omset">
							<div class="input-daterange input-group">
								<input type="text" value="<?= $dari; ?>" class="form-control form-control-sm w-15" name="dari" id="dari">

								<input type="text" value="<?= $sampai; ?>" class="form-control form-control-sm w-15" name="sampai" id="sampai">
							</div>
						</div>
						<div class='btn-group' role='group'>
							<button class="btn btn-primary btn-sm detail_kehadiran" type="button">Tampilkan</button>
							<button class="btn btn-danger btn-sm koreksi" type="button">Koreksi</button>
							<button type="button" class="btn btn-warning btn-sm rekap" onclick="rekap()" style="display: none;"><i class="fa fa-archive"></i> Rekap</button>

							<button class="btn btn-info btn-icon-split btn-sm tambah_kehadiran  koreksi-show" data-toggle="modal" data-target="#tambah_kehadiran">
								<span class="icon text-white-50">
									<i class="fa fa-plus"></i>
								</span>
								<span class="text bg-info">Tambah</span>
							</button>
							<button class="btn btn-success btn-sm btn-icon-split btn-sm update_masuk koreksi-show">
								<span class="icon text-white-50">
									<i class="fa fa-refresh"></i>
								</span>
								<span class="text bg-success">Masuk</span>
							</button>
							<button class="btn btn-info btn-sm btn-icon-split btn-sm koreksi-show update_pulang">
								<span class="icon text-white-50">
									<i class="fa fa-refresh"></i>
								</span>
								<span class="text bg-info">Pulang</span>
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div id="tampilkan_detail"></div>
	<div id="koreksi"></div>
</div>
<!-- Modal -->
<div class="modal fade" id="tambah_kehadiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group date input-group-sm mb-1">
					<div class="input-group-prepend">
						<span class="input-group-text">Tanggal</span>
					</div>
					<input type="text" class="form-control text-right" id="tgl_kehadiran">
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary simpan_tanggal">Simpan</button>
			</div>
		</div>
	</div>
</div>
<style>
	.koreksi-show {
		display: none;
	}

	.none {
		display: none;
	}

	.btn {
		cursor: pointer;
	}

	.blink {
		-webkit-animation: blink .75s linear infinite;
		-moz-animation: blink .75s linear infinite;
		-ms-animation: blink .75s linear infinite;
		-o-animation: blink .75s linear infinite;
		animation: blink .75s linear infinite;
	}

	@-webkit-keyframes blink {
		0% {
			opacity: 1;
		}

		50% {
			opacity: 1;
		}

		50.01% {
			opacity: 0;
		}

		100% {
			opacity: 0;
		}
	}
</style>
<script>
	var date2 = '<?= $sampai; ?>';
	$('#date-omset .input-daterange').datepicker({
		format: 'dd/mm/yyyy',
		"endDate": date2,
		autoclose: true,
		todayHighlight: false,
		todayBtn: 'linked',
	});
	$('#tgl_kehadiran').datepicker({
		format: 'dd/mm/yyyy',
		"endDate": date2,
		autoclose: true,
		todayHighlight: false,
		todayBtn: 'linked',
	});

	$(".koreksi").click(function() {
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		$.ajax({
			url: base_url + "absen/detail_koreksi",
			type: 'POST',
			cache: false,
			data: {
				user: user,
				dari: dari,
				sampai: sampai
			},
			beforeSend: function() {
				$("body").loading();
			},
			success: function(data) {
				$("body").loading('stop');
				$('#koreksi').html(data);
				$('.hide').hide();
				$('#tampilkan_detail').hide();
				$('#koreksi').show();
				$('.rekap-blink').show();
				$('.koreksi-show').show();
				// $('.rekap').hide();
				$('.koreksi').hide();
			},
			error: function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});
	$(document).on("click", ".simpan_tanggal", function() {
		var tanggal = $('#tgl_kehadiran').val();
		var user = $('#user').val();
		$.ajax({
			url: base_url + "post/tambah_data",
			type: 'POST',
			cache: false,
			data: {
				user: user,
				tanggal: tanggal
			},
			beforeSend: function() {
				$("body").loading();
			},
			success: function(data) {
				if (data.status == 200) {
					sweet_time(500, "Simpan!!!", "Data Berhasil di tambahkan");
				} else {
					sweet('Simpan!!', data.msg, "warning", "warning");
				}
				$("#tambah_kehadiran").modal('hide');
				$('.koreksi').click();
				$("body").loading('stop');
			},
			error: function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});

	$(document).on("click", ".update_masuk", function() {
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		$.ajax({
			"url": base_url + "post/update_jam_masuk",
			"data": {
				user: user,
				dari: dari,
				sampai: sampai
			},
			"method": "POST",
			"dataType": "html",
			beforeSend: function() {
				$("body").loading();
			},
			success: function(response) {
				$("body").loading('stop');
				$('.koreksi').click();
			},
			error: function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});

	$(document).on("click", ".update_pulang", function() {
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		$.ajax({
			"url": base_url + "post/update_jam_pulang",
			"data": {
				user: user,
				dari: dari,
				sampai: sampai
			},
			"method": "POST",
			"dataType": "html",
			beforeSend: function() {
				$("body").loading();
			},
			success: function(response) {
				$("body").loading('stop');
				$('.koreksi').click();
			},
			error: function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});
	$(document).on("click", ".detail_kehadiran", function() {
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		$.ajax({
			"url": base_url + "absen/detail_penggajian",
			"data": {
				user: user,
				dari: dari,
				sampai: sampai
			},
			"method": "POST",
			"dataType": "html",
			beforeSend: function() {
				$("body").loading();
			},
			success: function(response) {
				$("body").loading('stop');
				$("#tampilkan_detail").html(response);
				$('#koreksi').hide();
				$('#tampilkan_detail').show();
				$('.hide').show();
				$('.koreksi-show').hide();
				$('.rekap').show();
				$('.koreksi').show();
				$('.hide').show();
			},
			error: function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});

	function cekprint() {
		var rekap = document.getElementById("rekap").value;
		if (rekap == 'Y') {
			cetak_slip();
			return true;
		} else {
			sweet_time(500, "Status!!!", "Data Belum direkap");
			return false;
		}
	}

	function cekbayar() {
		var rekap = document.getElementById("rekap").value;
		if (rekap == 'Y') {
			$('#bayar').modal('show');
		} else {
			alert("Belum direkap");
		}
	}
</script>
<script src="<?= base_url('assets/'); ?>js/number.js?v=<?= time(); ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/'); ?>js/penggajian.js?v=<?= time(); ?>" type="text/javascript"></script>