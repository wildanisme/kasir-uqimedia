<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4 no-print">
		<h1 class="h3 mb-0 text-gray-800 no-print"><?=$judul;?></h1>
		<ol class="breadcrumb no-print">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?=$judul;?></li>
		</ol>
	</div>
	<div class="row row-cards">
		<div class="col-12">
			<div class="card">
				<div class="card-header  d-flex flex-row align-items-center justify-content-between">
					<h5 class="card-title">Data Laporan Stok Barang </h5>
				</div>
				<div class="card-body">
					<form action="<?=base_url('gudang/laporan/');?>" method="get" class="form-horizontal well no-print">
						<div class="row row-cards">
							<div class="col">
								<div class="btn-list text-white">
									<input type="text" id="datepicker" name="bulan" class="form-control form-control-sm" value="<?=$bulan;?>" onchange="this.form.submit()"/>
								</div>
							</div>
							<div class="col">
								
								<div class="custom-control custom-radio">
									<?php if($level=='admin'){ ?>
										<input type="radio" class="custom-control-input" id="show1" <?php if(isset($show)){if($show == 1){echo "checked";}}?> name="show" value="1" onchange="this.form.submit()">
										<label class="custom-control-label" for="show1">Stok Gudang</label>
									<?php } ?>
								</div>
								
							</div>
							<div class="col">
								<div class="custom-control custom-radio">
									<input type="radio" class="custom-control-input" id="show2" <?php if(isset($show)){if($show == 2){echo "checked";}}?> name="show" value="2" onchange="this.form.submit()">
									<label class="custom-control-label" for="show2">Pengguna</label>
								</div>
							</div>
							
							<div class="col">
								
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="dtl" id="dtl" value="1" onchange="this.form.submit()" <?php if(isset($detail)){if($detail == 1){echo "checked";}}?>>
									<label class="custom-control-label" for="dtl">Tampilkan Detail</label>
								</div>
								
							</div>
							
							
							<?php
								if(isset($show)){
									if($show == 2){
									?>
									<div class="col">
										<label for="filter">Filter</label>
										<select name="filter" id="filter" class="form-select form-control form-control-sm" onchange="this.form.submit()">
											<?php if($level=='admin'){ ?>
												<option value="">Semua</option>
												<?php
												}
												foreach($listdiv as $iddv=>$dvname){
													$sel = "";
													if(isset($filter)){
														if($filter == $iddv){
															$sel = "selected";
														}
													}
													if($id_divisi==$iddv AND $level!='admin'){
														$sel = "selected";
														echo "<option value='$iddv' $sel>$dvname</option>";
													}
													if($level=='admin'){
														echo "<option value='$iddv' $sel>$dvname</option>";
													}
												}
											?>
										</select>
										
									</div>
									<?php
									}
								}
							?>
							
						</div>
					</form>
					
					
					<div class="pb-2" id="posts_content">
						<div class="print-area">
							<?php
								if(isset($show)):
								
								if($show == 1) :
							?>
							<div class="table-responsive pt-3">
								<table id="table-global" class="table card-table table-vcenter text-nowrap datatable">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama Barang</th>
											<?php if($detail == 1){ ?>
												<th>Tanggal</th>
												<?php }else{ ?>
												<th>Stok Sebelumnya</th>
											<?php } ?>
											<th>Masuk</th>
											<th>Keluar</th>
											<?php
												if($detail == 1){
													echo "<th>Keterangan</th>";
												}
												else{
													echo "<th>Stok Akhir</th>";
												}
											?>
										</tr>			
									</thead>
									<tbody>
										<?php
											if(isset($query)){
												$n = 1;
												$query = array_filter($query); 
												
												foreach($query as $idmaster=>$isi){
													if(isset($list_cc[$idmaster])){
														
														$nama = $list_cc[$idmaster];
														$mutasi = 0;
														$total = 0;
														$_terima = 0;
														$_kirim = 0;
														$total_stok = 0;
														$masuk = $keluar = 0;
														$total_masuk = $total_keluar = 0;
														foreach($isi as $tgl => $row){
															if($tgl!='total'){
																$date = date("Y-m-d",$tgl);
																
																$terima =0;
																if(isset($row['terima'])){
																	$terima = $row['terima'];
																	$mutasi += $terima;
																	$_terima += $terima;
																}
																$kirim = 0;
																if(isset($row['kirim'])){
																	$kirim = $row['kirim'];
																	$_kirim += $row['kirim'];
																	$mutasi -= $kirim;
																}
																
																
																$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";
																
																
																if($detail == 1){
																	echo "
																	<tr>
																	<td>$n</td>
																	<td>$nama</td>
																	<td>".tgl_ambil($date)."</td>
																	<td>$terima</td>
																	<td>$kirim</td>
																	<td>$ket</td>
																	</tr>
																	";
																	$n++;
																}
																else{
																	$masuk += intval($terima);
																	$keluar += intval($kirim);
																}
															}
															if($tgl=='total'){
																if(isset($row['total_masuk'])){
																	$total_masuk = $row['total_masuk'];
																	$total_masuk = $total_masuk;
																}
																if(isset($row['total_keluar'])){
																	$total_keluar = $row['total_keluar'];
																	$total_keluar = $total_keluar;
																}
																
															}
															$total = $total_masuk - $total_keluar;
															$total_stok = $total + $mutasi;
															
														}
														if($detail == 1 ){
															echo "
															<tr class='active'>
															<td colspan='2' align='left'>Stok Sebelumnya : <strong>$total</strong></td>
															<td align='left'></td>
															<td><strong>$_terima</strong></td>
															<td><strong>$_kirim</strong></td>
															<td><strong>Sisa : $total_stok</strong></td>
															</tr>
															<tr>
															<td colspan=6></td>
															</tr>
															";
														}
														else{
															echo "
															<tr>
															<td>$n</td>
															<td>$nama</td>
															<td>$total</td>
															<td>$masuk</td>
															<td>$keluar</td>
															<td><strong>$total_stok</strong></td>
															</tr>
															";
															$n++;
														}
													}
												}
											}
										?>
									</tbody>
								</table>
							</div>
							
							<?php
								elseif($show == 2):
							?>
							<div  class="table-responsive pt-3">
								<table id="table-satker" class="data table">
									<thead>
										<tr>
											<th>#</th>
											<th>Pengguna</th>
											<th>Nama Barang</th>
											<?php if($detail == 1){ ?>
												<th>Tanggal</th>
												<?php }else{ ?>
												<th>Stok Sebelumnya</th>
											<?php } ?>
											<th>Masuk</th>
											<th>Keluar</th>
											<th>Keterangan</th>
											
										</tr>		
									</thead>
									<tbody>
										<?php
											if(isset($query)){
												$n = 1;
												foreach($query as $iddivisi=>$isi){
													if(isset($listdiv[$iddivisi])){
														
														$divisi = $listdiv[$iddivisi];
														// dump($isi);
														$total = 0;
														$total_masuk = 0;
														$total_keluar = 0;
														$total_stok = 0;
														foreach($isi as $idmaster => $isis){
															$ccname = isset($list_cc[$idmaster]) ? $list_cc[$idmaster] : null;
															$mutasi = 0;
															$_kirim = 0;
															$_jual = 0;
															$masuk = $keluar = 0;
															
															// dump($isis);
															foreach($isis as $tgl => $row){
																if($tgl!='total'){
																	$date = date("Y-m-d",$tgl);
																	
																	$kirim = "";
																	if(isset($row['kirim'])){
																		$kirim = $row['kirim'];
																		$mutasi += $kirim;
																		$_kirim += $kirim;
																	}
																	$jual = "";
																	if(isset($row['jual'])){
																		$jual = $row['jual'];
																		$mutasi -= $jual;
																		$_jual += $jual;
																		
																	}
																	
																	$ket = isset($row['ket']) ? "<em>$row[ket]</em>" : "";
																	if($detail == 1){
																		echo "
																		<tr>
																		<td>$n</td>
																		<td>$divisi</td>
																		<td>$ccname</td>
																		<td>".tgl_ambil($date)."</td>
																		<td>$kirim</td>
																		<td>$jual</td>
																		<td>$ket</td>
																		</tr>
																		";
																		
																		$n++;
																	}
																	else{
																		$masuk += intval($kirim);
																		$keluar += intval($jual);
																	}
																}
																if($tgl=='total'){
																	if(isset($row['total_masuk'])){
																		$total_masuk = $row['total_masuk'];
																	}
																	if(isset($row['total_keluar'])){
																		$total_keluar = $row['total_keluar'];
																	}
																	
																}
																$total = $total_masuk - $total_keluar;
																$total_stok = $total + $mutasi;
															}
															
															if($detail == 1){
																echo "
																<tr class='active'>
																<td colspan='2' align='left'>Stok Sebelumnya : <strong>$total</strong></td>
																<td></td>
																<td></td>
																<td><strong>$_kirim</strong></td>
																<td align='left'>$_jual</td>
																<td><strong>Sisa : $total_stok</strong></td>
																
																</tr>
																<tr>
																<td colspan=7></td>
																</tr>
																";
															}
															else{
																echo "
																<tr>
																<td>$n</td>
																<td>$ccname</td>
																<td>$divisi</td>
																<td>$total</td>
																<td>$masuk</td>
																<td>$keluar</td>
																<td><em>Stok Akhir : <strong>$total_stok</strong></em></td>
																</tr>
																";
																$n++;
															}	
														}
													}
												}
											}
										?>
									</tbody>
								</table>
							</div>
							<?php
								endif;
								echo "
								<a href='javascript:;' onclick='window.print()' class='btn btn-primary no-print mt-2'><span class='fa fa-print fa-fw'></span> Print</a>
								";
								endif;
							?>
						</div>
					</div>
				</div>
			</div><!-- /.card -->
		</div>
		<?php if(is_demo() == 'Y'){ ?>
			<div class="col-md-12 mt-2">
				<div class="card">
					<div class="card-header pb-0">
						<h4 class="card-title">Catatan</h4>
					</div>
					<div class="card-body pt-0">
						<p>Modul ini tidak termasuk dalam pembelian</p>
						<p>Info lebih lanjut hubungi pengembang</p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>									
<script>
	$("#datepicker").datepicker( {
		format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months"
	});
	// $(document).ready(function () {
	
	// $.fn.dataTable.ext.errMode = 'none';
	
	// $('#table-global,#table-satker').on( 'error.dt', function ( e, settings, techNote, message ) {
	// console.log( 'An error has been reported by DataTables: ', message );
	// } ) .DataTable();
	// $('#table-global').DataTable({
	// dom: 'Bfrtip',
	// buttons: [
	// {
	// extend: 'print',
	// autoPrint: false
	// }
	// ]
	// } );
	// $('#table-satker').DataTable({
	// dom: 'Bfrtip',
	// buttons: [
	// {
	// extend: 'print',
	// autoPrint: false
	// }
	// ]
	// } );
	// });
</script>				