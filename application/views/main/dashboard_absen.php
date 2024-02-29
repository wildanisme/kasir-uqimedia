<!-- Container Fluid-->
<?php
$sync = $this->db->query('SELECT NOW() AS now')->row()->now;
$waktu_server = strtotime($sync);
$waktu_sekarang = date('Y-m-d H:i:s');
$waktu_sekarang = strtotime($waktu_sekarang);

$jam_sekarang = date('H:i');
$jam_sekarang = strtotime($jam_sekarang);

$title_masuk = '';
$title_pulang = '';
$disabled_masuk = 'disabled';
$disabled_pulang = 'disabled';

$jam_awal_shift_1 = '07:00';
$jam_awal_shift_1 = strtotime($jam_awal_shift_1);
$jam_awal_shift_2 = '11:00';
$jam_awal_shift_2 = strtotime($jam_awal_shift_2);
$max_masuk = '09:00';
$max_masuk = strtotime($max_masuk);

$awal_pulang = '14:00';
$awal_pulang = strtotime($awal_pulang);

$max_pulang1 = '23:59';
$max_pulang1 = strtotime($max_pulang1);
$max_pulang = '00:00';
$max_pulang = strtotime($max_pulang);

//masuk shift I
if ($jam_sekarang < $jam_awal_shift_1) {
	$disabled_masuk = 'disabled';
	$title_masuk = 'Presensi Mulai pukul ' . $jam_awal_shift_1;
}

if ($jam_sekarang > $jam_awal_shift_1 and $jam_sekarang < $max_masuk) {
	$disabled_masuk = '';
	$title_masuk = 'Shift I Aktif';
}
//masuk shift II

if ($jam_sekarang > $max_masuk) {
	$disabled_masuk = 'disabled';
	$title_masuk = 'Waktu masuk sudah lewat';
	$title_pulang = 'Belum masuk Waktu pulang';
}

if ($jam_sekarang >= $jam_awal_shift_2) {
	$disabled_masuk = '';
	$title_masuk = 'Shift II Aktif';
}
//pulang shift I
if ($jam_sekarang >= $awal_pulang) {
	$disabled_pulang = '';
	$title_pulang = 'Tombol Aktif';
}
//shift I disabled
if ($jam_sekarang >= $awal_pulang) {
	$disabled_masuk = 'disabled';
	$title_masuk = 'Waktu masuk sudah lewat';
}

if ($jam_sekarang >= $max_pulang1) {
	$disabled_pulang = 'disabled';
	$title_pulang = 'Waktu pulang sudah lewat';
}

if ($jam_sekarang == $max_pulang) {
	$disabled_pulang = 'disabled';
	$title_pulang = 'Waktu pulang sudah lewat';
}

if ($waktu_sekarang < $waktu_server) {
?>
	<!-- Container Fluid-->
	<div class="container-fluid" id="container-wrapper">
		<div class="text-center">
			<img src="<?= base_url('assets/'); ?>img/error.svg" style="max-height: 100px;" class="mb-3">
			<h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
			<p class="lead text-gray-800 mx-auto">Waktu di komputer tidak sesuai</p>
			<p class="lead text-gray-600 mx-auto">Sesuaikan terlebih dahulu</p>
			<a href="<?= base_url('absen/data'); ?>">&larr; Back to Dashboard</a>
		</div>

	</div>
	<!---Container Fluid-->
<?php } else { ?>
	<div class="container-fluid" id="container-wrapper">
		<div class="row mb-3">
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100 ">
					<div class="card-body" id="LoadingTotal">
						<div class="row align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Masuk</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800 load-count">0</div>
							</div>
							<div class="col-auto" data-toggle='tooltip' title="<?= $title_masuk; ?>">
								<button class="btn btn-success save_masuk" data-id='<?= $id; ?>' <?= $disabled_masuk; ?>>Masuk</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Earnings (Annual) Card Example -->
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body" id="LoadingToday">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Pulang</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800 load-now">0</div>
							</div>
							<div class="col-auto" data-toggle='tooltip' title="<?= $title_pulang; ?>">
								<button class="btn btn-info save_pulang" data-id='<?= $id; ?>' <?= $disabled_pulang; ?>>Pulang</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Pending Requests Card Example -->
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100">
					<div class="card-body" id="LoadingBaru">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="text-xs font-weight-bold text-uppercase mb-1">Total Karyawan</div>
								<div class="h5 mb-0 font-weight-bold text-gray-800 load-baru">0</div>
							</div>
							<div class="col-auto">
								<a href="#" data-id="baru">
									<i class="fa fa-shopping-cart fa-2x text-info"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-12 col-lg-12">
				<div class="card" id="LoadingKehadiran">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">List Absen Hari ini</h6>
						<a class="m-0 float-right btn btn-danger btn-sm" href="<?= base_url('absen/detail/') . $id; ?>">Detail Absen</a>
					</div>
					<div class="table-responsive">
						<table class="table align-items-center table-flush">
							<thead class="thead-light">
								<tr>
									<th class="w-1">NO.</th>
									<th class="text-left">NAMA</th>
									<th class="text-left">TANGGAL</th>
									<th class="text-right">JAM MASUK</th>
									<th class="text-right">JAM PULANG</th>
								</tr>
							</thead>
							<tbody id="load-kehadiran">

							</tbody>
						</table>
					</div>
					<div class="card-footer"></div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<style>
	.title {

		margin-bottom: 50px;
		text-transform: uppercase;
	}

	.card-block {
		font-size: 1em;
		position: relative;
		margin: 0;
		padding: 1em;
		border: none;
		border-top: 1px solid rgba(34, 36, 38, .1);
		box-shadow: none;

	}

	.card {
		font-size: 1em;
		overflow: hidden;
		padding: 5;
		border: none;
		border-radius: .28571429rem;
		box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
		margin-top: 20px;
	}

	.carousel-indicators li {
		border-radius: 12px;
		width: 12px;
		height: 12px;
		background-color: #404040;
	}

	.carousel-indicators li {
		border-radius: 12px;
		width: 12px;
		height: 12px;
		background-color: #404040;
	}

	.carousel-indicators .active {
		background-color: white;
		max-width: 12px;
		margin: 0 3px;
		height: 12px;
	}

	.carousel-control-prev-icon {
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E") !important;
	}

	.carousel-control-next-icon {
		background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E") !important;
	}

	lex-direction: column;
	}

	.btn {
		margin-top: auto;
	}
</style>
<script>
	$(document).ready(function() {
		load_list();
		load_masuk();
		load_pulang();
		load_karyawan();
	});

	function load_list() {
		$.ajaxQueue({
			url: base_url + "absen/list_kehadiran",
			cache: false,
			beforeSend: function() {
				$("#LoadingKehadiran").loading();
			},
			success: function(data) {
				$("#LoadingKehadiran").loading('stop');
				$('#load-kehadiran').html(data);
			}
		});
	}


	function load_masuk() {
		$.ajaxQueue({
			url: base_url + "absen/load_masuk",
			cache: false,
			beforeSend: function() {
				$("#LoadingTotal").loading();
			},
			success: function(data) {
				$("#LoadingTotal").loading("stop");
				$('.load-count').html(data);
			}
		});
	}

	function load_pulang() {
		$.ajaxQueue({
			url: base_url + "absen/load_pulang",
			cache: false,
			beforeSend: function() {
				$("#LoadingToday").loading();
			},
			success: function(data) {
				$("#LoadingToday").loading('stop');
				$('.load-now').html(data);
			}
		});
	}

	function load_karyawan() {
		$.ajaxQueue({
			url: base_url + "absen/load_karyawan",
			cache: false,
			beforeSend: function() {
				$("#LoadingBaru").loading();
			},
			success: function(data) {
				$("#LoadingBaru").loading('stop');
				$('.load-baru').html(data);
			},
			error: function(res, status, httpMessage) {
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	}

	$(document).on("click", ".save_masuk", function() {
		var id = $(this).attr("data-id");
		$.ajax({
			"url": base_url + "absen/save_masuk",
			"data": {
				id: id
			},
			"method": "POST",
			"dataType": "json",
			success: function(response) {
				if (response.status == 200) {
					sweet_login(response.msg, 'success');
				} else {
					sweet_login(response.msg, 'warning');
				}
				console.log(response);
				// $("#error_piutang").css("display", "none");
				// $("#data-cari").html(htmlExercise);
			},
			error: function(res, status, httpMessage) {
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});

	$(document).on("click", ".save_pulang", function() {
		var id = $(this).attr("data-id");
		$.ajax({
			"url": base_url + "absen/save_pulang",
			"data": {
				id: id
			},
			"method": "POST",
			"dataType": "json",
			success: function(response) {
				if (response.status == 200) {
					sweet_login(response.msg, 'success');
				} else {
					sweet_login(response.msg, 'warning');
				}
				console.log(response);
				// $("#error_piutang").css("display", "none");
				// $("#data-cari").html(htmlExercise);
			},
			error: function(res, status, httpMessage) {
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
	});
</script>