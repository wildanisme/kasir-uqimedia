<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h5 class="h3 mb-0 text-gray-800"><?=$judul;?></h5>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?=$judul;?></li>
		</ol>
	</div>
	
	<div class="row row-cards">
		<div class="col-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text" for"limits">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select w-1"  onchange="searchMutasiPenerimaan()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text" for="sortBy">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select w-3" onchange="searchMutasiPenerimaan()">
							<option value="" selected>SORT BY</option>
							<option value="ASC">TITLE ASC</option>
							<option value="DESC">TITLE DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">CARI DATA</span>
						</div>
						
						<input type="text" id="keywords" class="form-control w-30" placeholder="Cari data" onkeyup="searchMutasiPenerimaan();"/>
						
						<div class="input-group-append">
							<button class="btn btn-danger clear_search" type="button"><i class="fa fa-times"></i> CLEAR</button>
							<button type="button" class="btn btn-info add_masuk" data-id="0"><i class="fa fa-plus"></i> INPUT BARANG</button>
							
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<div id="posts_content">
						<?php if(!empty($list)){ ?>
							<div class="table-responsive">
								<table class="table card-table table-vcenter text-nowrap">
									<thead class="thead-dark">
										<tr>
											<th width=5%>No.</th>
											<th width=38%>Nama Barang</th>
											<th class="text-center" width="10%">Jumlah Stok | Satuan</th>
											<th class="text-right" width=10%>Detail | Masuk | Keluar</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=0;
											foreach($list as $row){
												$no++;
												if(!empty($mutasi[$row['id']])){
													$jumlah = $mutasi[$row['id']];
													$disabled = '';
													}else{
													$jumlah =0;
													$disabled = 'disabled';
												}
											?>
											<tr>
												<td><?=$no?></td>
												<td><a href="javascript:void(0)" class="add_masuk" data-id="<?=encrypt_url($row['id']);?>"><?=$row['title']?></a></td>
												<td align="center"><?=$jumlah.' '.get_satuan($row['id_satuan']);?></td>
												<td class="text-right">
													<div class="btn-group btn-group-sm">
														<button class="btn btn-primary" data-toggle='modal' data-target='#OpenModalDetail' data-id='<?=$row['id'];?>' data-mod='kirim' <?=$disabled;?>><i class="fa fa-list"></i> Detail</button>
														<a href='javascript:void(0);' data-toggle='modal' data-target='#OpenModalTerima' data-id='<?=$row['id'];?>' data-mod='terima' class="btn btn-info"><i class="fa fa-plus"></i> Masuk</a>
														<button class="btn btn-warning" data-toggle='modal' data-target='#OpenModalKirim' data-id='<?=$row['id'];?>' data-mod='kirim' <?=$disabled;?>><i class="fa fa-minus"></i> Keluar</button>
													</div>
												</td>
											</tr>
											<?php
											}
										?>
									</tbody>
								</table> 
							</div>
							<div class="p-3">
								<?php echo $this->ajax_pagination->create_links(); ?>
							</div>
							<?php }else{ ?>
							<table class='table table-bordered'>
								<tr>
									<td>Belum ada data</td>
								</tr>
							</table>
						<?php } ?>
					</div>
				</div>
				
			</div><!-- /.card -->
		</div><!-- /.row -->
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

<div class="modal fade" id="OpenModalTerima" tabindex="-1">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="LabelTerimaBarang">Tambah Data Terima</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body pb-0 mt-0 pt-1">
                <form id="terimaBarang">
					<input type="hidden" class="form-control" id="id_terima" name="id">
					<input type="hidden" class="form-control" id="mod" name="mod">
					
					<div class="card-block">
						<label class="form-label" for="tanggal">Tanggal Terima</label>
						<div class="input-icon mb-1">
							<input type="date" name="tanggal" value="" class="form-control" id="tanggal" required="" autocomplate="off">
							<span class="input-icon-addon"><i class="ti ti-calendar"></i>
							</span>
						</div>
						<div class="form-group mb-1">
							<label class="form-label" for="jumlah">Jumlah item </label>
							<input type="number" name="jumlah" value="" class="form-control" id="jumlah" required="" autocomplate="off">
						</div>
						<div class="form-group mb-1">
							<label class="form-label" for="keterangan">Keterangan</label>
							<input type="text" name="keterangan" value="" class="form-control" id="keterangan" required="" autocomplate="off">
						</div>
						
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onClick="terimaBarang()" id="btn-bahan" class="btn btn-success">Submit</button>
				<button type="button" class="btn bg-red" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-blur fade" id="OpenModalKirim" tabindex="-1">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fs-5" id="LabelKirimBarang">Kirim Barang</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body pb-0 mt-0 pt-1">
                <form id="kirimBarang">
					<input type="hidden" class="form-control" id="id_kirim" name="id">
					<input type="hidden" class="form-control" id="mod_kirim" name="mod_kirim">
					
					<div class="card-block">
						<div class="form-group mb-1">
							<label class="form-label" for="tanggal_kirim">Tanggal Kirim</label>
							<input type="date" name="tanggal_kirim" value="" class="form-control" id="tanggal_kirim" required="">
						</div>
						<div class="form-group mb-1">
							<label class="form-label" for="jumlah_kirim">Jumlah item </label>
							<input type="number" name="jumlah_kirim" value="" class="form-control" id="jumlah_kirim" required="">
						</div>
						<div class="form-group mb-1">
							<label class="form-label" for="pengguna">Pengguna</label>
							<select name="pengguna" id="pengguna" class="form-control custom-select"  required="">
								<?php
									foreach($divisi->result_array() AS $row){
										if($iduser==$row[id_user]){
											echo "<option value=$row[id_user] selected>$row[nama_lengkap]</option>"; 
										}
									}
								?>
							</select>
						</div>
						<div class="form-group mb-1">
							<label class="form-label" for="ket_kirim">Keterangan</label>
							<input type="text" name="ket_kirim" value="" class="form-control" id="ket_kirim">
						</div>
						
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onClick="simpanKirim()" id="btn-bahan" class="btn btn-success">Submit</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="OpenModalDetail" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Rekam Mutasi Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body pb-0 mt-0 pt-1" id="loading-detail">
                <div id="load_detail"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="ModalBahanMasuk" class="modal left fade" role="dialog">
    <div class="modal-dialog" id="load-save-bahan">
        <div class="modal-content flat">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Input Data Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="title_masuk">Nama Barang</label>
							<input type="text" name="title" id="title_masuk" class="form-control" required>
							<input type="hidden" name="id_barang" id="id_barang" class="form-control" required>
							<input type="hidden" name="id_satuan" id="id_satuan" class="form-control" required>
							<input type="hidden" name="type" id="type" class="form-control" required>
							<input type="hidden" name="id" id="stok_id" class="form-control" required>
						</div>
						
						<div class="form-group">
							<label for="satuan">Satuan</label>
							<input type="text" name="satuan" id="satuan" class="form-control" required>
						</div>
						
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_barang">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).on('click','.add_masuk',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		$('.form-control').addClass('form-control-sm');
		$('.form-group').css('margin-bottom','5px');
		clearform();
		$('#ModalBahanMasuk').modal('show');
		setTimeout(function() {
			$("#title_masuk").focus();
		}, 1000);
		if(id==0){
			$("#type").val('add');
			return
			}else{
			$("#type").val('edit');
		}
		$.ajax({
			url: base_url + 'gudang/edit_barang',
			data: {type:'edit',id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$("#id_satuan").val(data.id_satuan);
				$("#stok_id").val(data.id);
				$("#title_masuk").val(data.title);
				$("#satuan").val(data.satuan);
				
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	$(document).on('click','.save_barang',function(e){
		e.preventDefault();
		
		var id = $("#stok_id").val();
		var id_satuan = $("#id_satuan").val();
		var type = $("#type").val();
		var title = $("#title_masuk").val();
		var jumlah = angka($("#jumlah").val());
		var tanggal = $("#tanggal").val();
		
		if(id_satuan=='' || id_satuan==0){
			$("#satuan").addClass('is-invalid');
			$("#satuan").focus();
			sweet('Peringatan!!!','Satuan tidak ditemukan','warning','warning');
			return;
		}
		
		if(title==''){
			$("#title_masuk").addClass('is-invalid');
			$("#title_masuk").focus();
			return;
		}
		if(satuan==''){
			$("#satuan").addClass('is-invalid');
			$("#satuan").focus();
			return;
		}
		
		$.ajax({
			url: base_url + 'gudang/save_barang',
			data: {type:type,id:id,id_satuan:id_satuan,title:title},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('#load-save-bahan').loading({zIndex:1060,theme:'dark'});
			},
			success: function(data) {
				if(data.status==200){
					showNotif('bottom-right','Data barang',data.msg,'success');
					$('#ModalBahanMasuk').modal('hide');
					}else{
					sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
				}
				searchMutasiPenerimaan();
				$('#load-save-bahan').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('#load-save-bahan').loading('stop');
			}
		});
	});
	
	$('#satuan').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: base_url + 'produk/ajax',
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'satuan_table',
                    row_num: 1
				},
                success: function(data) {
                    response($.map(data, function(item) {
                        var code = item.split("|");
                        return {
                            label: code[0],
                            value: code[0],
                            data: item
						}
					}));
				},
				error: function (xhr, ajaxOptions, thrownError) {
					sweet('Peringatan!!!',thrownError,'warning','warning');
				}
			});
		},
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            var names = ui.item.data.split("|");
			id_arr = $(this).attr('id');
			id = id_arr.split("_");
            $('#satuan').val(names[0]);
            $('#id_satuan').val(names[1]);
		}
		
	});
	
	
	function clearform(){
		$("#title_masuk").val("");
		$("#satuan").val("");
		
	}
	
	$('.clear_search').on('click', function(){
		$('#keywords').val('');
		searchMutasiPenerimaan();
	});
    function searchMutasiPenerimaan(page_num){
        page_num = page_num?page_num:0;
        var limit = $('#limits').val();
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        $.ajax({
            type: 'POST',
            url: base_url+'gudang/ajaxInventory/'+page_num,
            data:'page='+page_num+'&limit='+limit+'&keywords='+keywords+'&sortBy='+sortBy,
            beforeSend: function(){
                $('body').loading();
			},
            success: function(html){
                $('#posts_content').html(html);
                $('body').loading('stop');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
				$('body').loading('stop');
			}
		});
	}
	
	$('#OpenModalTerima').on('show.bs.modal', function(e) {
		var id = $(e.relatedTarget).data('id');
		var mod = $(e.relatedTarget).data('mod');
		setTimeout(function() {
			$("#jumlah").focus();
		}, 800);
		if(id != 0){
			$.ajax({
				type: 'POST',
				url: base_url + "gudang/load_terima",
				data: {id:id,mod:mod},
				dataType: "json",
				beforeSend: function () {
					$('body').loading();
				},
				success: function(data) {
					// console.log(data)
					$('#id_terima').val(data.id);
					$('#tanggal').val(data.tgl);
					$('#mod').val(mod);
					$("#LabelTerimaBarang").html("Terima Barang "+data.title)
					$('body').loading('stop');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					sweet('Peringatan!!!',thrownError,'warning','warning');
					$('body').loading('stop');
				}
			});
			}else{
			$('#type').val('add');
		}
		
	});
	
	$('#OpenModalKirim').on('show.bs.modal', function(e) {
		var id = $(e.relatedTarget).data('id');
		var mod = $(e.relatedTarget).data('mod');
		setTimeout(function() {
			$("#jumlah_kirim").focus();
		}, 800);
		if(id != ''){
			$.ajax({
				type: 'POST',
				url: base_url + "gudang/load_terima",
				data: {id:id,mod:mod},
				dataType: "json",
				beforeSend: function () {
					$('body').loading();
				},
				success: function(data) {
					$('#id_kirim').val(data.id);
					$('#tanggal_kirim').val(data.tgl);
					$('#mod_kirim').val(mod);
					$('#pengguna').val(data.pengguna);
					$("#LabelKirimBarang").html("Kirim Barang "+data.title)
					$('body').loading('stop');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					sweet('Peringatan!!!',thrownError,'warning','warning');
					$('body').loading('stop');
				}
			});
			
		}
		
	});
	
	$('#OpenModalDetail').on('show.bs.modal', function(e) {
		var id = $(e.relatedTarget).data('id');
		
		if(id > 0){
			$.ajax({
				type: 'POST',
				url: base_url + "gudang/load_detail",
				data: {id:id},
				dataType: "html",
				beforeSend: function () {
					$('body').loading();
				},
				success: function(data) {
					// console.log(data)
					$('#load_detail').html(data);
					$('body').loading('stop');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					sweet('Peringatan!!!',thrownError,'warning','warning');
					$('body').loading('stop');
				}
			});
			}else{
			$('#type').val('add');
		}
		
	});
	
	
	function terimaBarang()
	{
		
		if($("#tanggal").val()==''){
			$("#tanggal").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#tanggal").focus();
			return;
		}
		if($("#jumlah").val()==''){
			$("#jumlah").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#jumlah").focus();
			return;
		}
		
		if($("#keterangan").val()==''){
			$("#keterangan").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#keterangan").focus();
			return;
		}
		
		var formData = $("#terimaBarang").serialize();
		$.ajax({
			type: "POST",
			url: base_url+"gudang/simpan_barang_diterima",
			dataType: 'json',
			data: formData,
			beforeSend: function () {
				$('body').loading();
			},
			success: function(data) {
				$('body').loading('stop');
				if(data.status==true){
					showNotif('bottom-right',data.title,data.msg,'success');
					}else{
					showNotif('bottom-right',data.title,data.msg,'error');
				}
				$("#OpenModalTerima").modal('hide');
				searchMutasiPenerimaan();
				} ,error: function(xhr, status, error) {
				showNotif('bottom-right','Peringatan',error,'error');
				$('body').loading('stop');
			}
		});
	}
	
	function simpanKirim()
	{
		
		if($("#tanggal_kirim").val()==''){
			$("#tanggal_kirim").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#tanggal_kirim").focus();
			return;
		}
		if($("#jumlah_kirim").val()==''){
			$("#jumlah_kirim").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#jumlah_kirim").focus();
			return;
		}
		if($("#pengguna").val()==0){
			$("#pengguna").addClass('form-control-warning');
			showNotif('top-center','Input Data','Harus diisi','warning');
			$("#pengguna").focus();
			return;
		}
		
		
		var formData = $("#kirimBarang").serialize();
		$.ajax({
			type: "POST",
			url: base_url+"gudang/simpan_barang_kirim",
			dataType: 'json',
			data: formData,
			beforeSend: function () {
				$('body').loading();
			},
			success: function(data) {
				$('body').loading('stop');
				if(data.status==true){
					showNotif('bottom-right',data.title,data.msg,'success');
					$("#OpenModalKirim").modal('hide');
					}else{
					showNotif('bottom-right',data.title,data.msg,'error');
				}
				searchMutasiPenerimaan();
				} ,error: function(xhr, status, error) {
				showNotif('bottom-right','Peringatan',error,'error');
				$('body').loading('stop');
			}
		});
	}
	$('#OpenModalKirim').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
	})
	$('#OpenModalTerima').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
	})
	$(document).on('click','.clear',function(e){
		$("#limits").val(10);
		$("#keywords").val('');
		searchMutasiPenerimaan();
	});
	
	$(document).on('change','#divisi',function(e){
		var idmaster = $('#idmaster').val();
		var id = $(this).val();
		$('#load_detail').html('');
		$.ajax({
			type: 'POST',
			url: base_url + "gudang/load_detail_divisi",
			data: {id:id,idmaster:idmaster},
			dataType: "html",
			beforeSend: function () {
				$('#loading-detail').loading({zIndex:1060});
			},
			success: function(data) {
				// console.log(data)
				$('#load_detail').html(data);
				$('#loading-detail').loading('stop');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
				$('#loading-detail').loading('stop');
			}
		});
	});
	
</script>        	