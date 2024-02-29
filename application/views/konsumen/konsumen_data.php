<style>
	.card .table td, .card .table th {
    padding-right: 1rem;
    padding-left: 1rem;
	}
</style>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Data Pelanggan</li>
		</ol>
	</div>
	<div class="card">
		<div class="row">
			<div class="col-md-12">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select w-5" onchange="searchFilterKonsumen()">
							<option value="ASC" selected>Nama A-Z</option>
							<option value="DESC">Nama Z-A</option>
							<option value="min_order">Order Kecil - Besar</option>
							<option value="max_order">Order Besar - Kecil</option>
							<option value="last_order">Terakhir Order</option>
							<option value="last_register">Terakhir Daftar</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="searchFilterKonsumen()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						
						<input type="text" id="keywords" class="form-control" placeholder="Cari data" onkeyup="searchFilterKonsumen();"/>
						<div class="input-group-append">
							<button type="button" class="btn btn-primary btn-sm cari-pelanggan" onclick="searchFilterKonsumen();"><i class="fa fa-search fa-1x"></i> Cari</button>
							<button type="button" data-toggle="tooltip" title="" data-id="0" class="btn btn-info btn-sm tambah2" id="tambah2" data-original-title="Tambah pelanggan"><i class="fa fa-user-plus fa-1x"></i> [F3]</button>
							<button class="btn btn-primary url_doc" data-url="pelanggan" type="button" data-toggle="tooltip" data-original-title="Dok pelanggan" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
						
					</div>
				</div>
				<div class="post-list pt-0" id="dataListKonsumen">
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
								<thead>
									<tr>
										<th style="width:1% !important;">No.</th>
										<th>Nama</th>
										<th>No. HP</th>
										<th class="text-right">Tgl.Daftar</th>
										<th class="text-right">Total Order</th>
										<th class="text-right" style="width:10%;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($posts)){
										$no=1;
										foreach($posts as $row){ 
											$query = $this->db->query("SELECT 
											id_konsumen AS idkonsumen, SUM(`invoice`.`total_bayar`) AS `total`
											FROM `invoice` WHERE
											`invoice`.`id_konsumen` =".$row['id']);
											
											$rows = $query->row();
											$idkonsumen = $rows->idkonsumen;
											if($idkonsumen > 0){
												$total = $rows->total;
												$aksi = '<button class="btn btn-secondary btn-sm flat" disabled>Hapus</button>';
												}else{
												$total = 0;
												$aksi = '<button class="btn btn-danger btn-sm flat" data-toggle="modal" data-target="#confirm-delete" data-id="'.encrypt_url($row["id"]).'">Hapus</button>';
											}
											
											$edit = '<a href="#"  class="edit_konsumen" data-member="'.$row["jenis_member"].'" data-jenis="'.$row["jenis"].'" data-id="'.encrypt_url($row["id"]).'">'.$row["nama"].'</a>';
										?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $edit; ?></td>
											<td><?=$row["no_hp"];?></td>
											<td class="text-right"><?=dtime($row["tgl_daftar"]);?></td>
											<td class="text-right"><?=rp($total);?></td>
											<td class="text-right">
												<div class="btn-group btn-group-sm flat" role="group" aria-label="Basic example">
													<a class="btn btn-info flat" href="<?=base_url();?>konsumen/detail/<?php echo encrypt_url($row["id"]); ?>">Detail</a>
													<?=$aksi;?>
												</div>
												
											</td>
										</tr>
									<?php $no++;} }else{ ?>
									<tr>
										<td colspan="10">Data belum ada</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<nav aria-label="Page navigation" class="mt-2">
								<?php 
									echo $this->ajax_pagination->create_links(); 
								?>
							</nav>
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
					<!-- Display posts list -->
				</div>
			</div>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm-delete" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus data, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
				<input type="hidden" id="data-hapus">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus_konsumen" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>

<script>
	$(document).on('click','.hapus_konsumen',function(e){
		var id = $("#data-hapus").val();
		$.ajax({
			url: base_url + 'konsumen/delete_konsumen',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function () {
                $('body').loading();
			},
			success: function(data) {
				if(data.status==true){
					showNotif('bottom-right',data.title,data.msg,'success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				searchFilterKonsumen();
				$('#confirm-delete').modal('hide');
				$('body').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('body').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
	});
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapus').val($(e.relatedTarget).data('id'));
	});
	shortcut.add("F3", function() {
		$(".tambah2").click();
		console.log(1)
	});
</script>