<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Surat Jalan</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Surat Jalan</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control form-control-sm custom-select" onchange="search_surat()">
							<option value="ASC">ASC</option>
							<option value="DESC" selected>DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control form-control-sm custom-select" onchange="search_surat()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">PENGIRIM</span>
						</div>
						<select name="user" id="user" class="form-control form-control-sm custom-select" onchange="search_surat()">
							<option value="0">Semua</option>
							<?php  
								foreach ($pilihan AS $values){
									echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
								}
							?>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">TANGGAL</span>
						</div>
						<div id="date-omset">
							<div class="input-daterange input-group">
								<input type="text" onchange="search_surat()"  class="form-control form-control-sm" name="dari" id="dari" value="<?=$dari;?>">
								<input type="text" onchange="search_surat()"  class="form-control form-control-sm" name="sampai" id="sampai" value="<?=$sampai;?>">
							</div>
						</div>
						<div class="input-group-append">
							<button type="button" data-toggle="tooltip" class="btn btn-danger btn-sm clear" id="clearCari" data-original-title="Clear" onclick="clearSearch('<?=$dari;?>')"><i class="fa fa-times fa-1x"></i> Clear</button>
							<button type="button" data-info="harian" class="btn btn-success btn-sm" data-id="0" onclick="search_surat()"><i class="fa fa-search"></i> Lihat</button>
							<button class="btn btn-primary url_doc" data-url="lap_rincian" type="button" data-toggle="tooltip" data-original-title="Dok Operator" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
					</div>
				</div>
				
				<div class="card-body table-responsive">
					<div class="card-block">
						<!--div id="data_omset"></div-->
						<div class="post-list pt-0" id="dataListOmset">
							<div class="table-responsive-sm">
								<table class="table">
									<tbody>
										<?php 
											if(!empty($posts)) {
												$no=1;
												foreach($posts AS $row){ 
													$id_invoice = encrypt_url($row['id']);
													$url_pdf = base_url().'laporan/cetak_surat/'.$id_invoice;
													$pdf = '<a href="'.$url_pdf.'" target="_blank" class="btn btn-primary btn-sm flat"><i class="fa fa-print"></i> SURAT</a>';
													$detail = detail_order($row['id_invoice']);
													
												?>
												<thead class="thead-dark">
													<tr>
														<th>No.Order</th>
														<th>Tgl.Order</th>
														<th>Tgl.Kirim</th>
														<th class="text-right">Customer</th>
														<th class="text-right">Pengirim</th>
														<th class="text-right">Aksi</th>
													</tr>
												</thead>
												<tr>
													<td><button class="btn btn-info btn-sm flat"><?php echo $row["id_transaksi"]; ?></button></td>
													<td><?=dtimes($row['tgl_trx'],false,false);?></td>
													<td><?=dtimes($row['tanggal'],false,false);?></td>
													<td class="text-right"><?=$row['nama'];?></td>
													<td class="text-right"><span class="badge badge-success flat"><?=$row['nama_lengkap'];?></span></td>
													<td class="text-right"><?=$pdf;?></td>
												</tr> 
												<thead class="thead-light">
													<tr> 
														<th>QTY</th>
														<th class="text-right">Produk</th>
														<th class="text-right">Jenis</th>
														<th class="text-right">Keterangan</th>
														<th class="text-right">Operator</th>
														<th class="text-right">Status</th>
													</tr>
												</thead>
												<?php 
													
													// print_r($detail);
													
													$num = 1;
													foreach($detail AS $val)
													{
														
														$operator = '-';
														if($val->id_operator!=0){
															$operator = juser($val->id_operator);
														}
														
														
													?>
													<tr>
														<td><?=$val->jumlah;?></td>
														<td class="text-right"><?=nama_produk($val->id_produk);?></td>
														<td class="text-right"><?=jenis_cetakan($val->jenis_cetakan);?></td>
														<td class="text-right"><?=$val->keterangan;?></td>
														<td class="text-right"><?=$operator;?></td>
														<td class="text-right">-</td>
													</tr>
													<?php 
													}
													
												}
											}
											else{ ?>
											<tr>
												<td colspan="6">Data belum ada</td>
											</tr> 
										<?php }?>
									</tbody>
								</table>
								<nav aria-label="Page navigation" class="mt-2">
									<?php echo $this->ajax_pagination->create_links(); ?>
								</nav>
							</div>
						</div>
					</div><!-- /.card-body -->
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</div>

<style>
	.custom-select {
    display: inline-block;
    width: 100%;
    height: 40px;
	padding: 5px 1.75rem 5px .75rem;
	
	}
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
	padding: 2px;
	
	}
	.card .table td, .card .table th {
	padding-right: 5px;
	padding-left: 5px;
	}
	.small {
	height: 30px;
	padding: 2px 10px;
	}
	button, input, select, textarea {
	font-family: inherit;
	font-size: inherit;
	line-height: inherit;
	}
</style>

<script>
	
	var date2 = new Date();
	$('#date-omset .input-daterange').datepicker({        
        format: 'dd/mm/yyyy',        
		"endDate": date2,
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
	}); 
	function search_surat(page_num){
		page_num = page_num?page_num:0;
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		var sortBy = $('#sortBy').val();
		var limits = $('#limits').val();
		var urlnya = base_url+"laporan/ajaxSuratjalan/"+page_num
		$.ajax({
			type: 'POST',
			url: urlnya,
			data:{page:page_num,user:user,dari:dari,sampai:sampai,sortBy:sortBy,limits:limits},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(html){
				$('#dataListOmset').html(html);
				$('body').loading('stop');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
				$('body').loading('stop');
			}
		});
	}
	
	function clearSearch(tgl){
		$('#dari').val(tgl);
		search_surat();
	}
</script>				