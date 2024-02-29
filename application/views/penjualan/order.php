<style>
	.card .table td, .card .table th {
    padding-right: 1rem;
    padding-left: 1rem;
	}
	
</style>

<div class="container-fluid mb-3" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">
			<div class="btn-group" role="group" aria-label="Basic example">
				<button class="btn btn-success btn-icon-split cek_transaksi flat" data-id="0" data-modEdit="baru">
					<span class="icon text-white-50" >
						<i class="fa fa-cart-plus fa-fw"></i>
					</span>
					<span class="text">Tambah Transaksi</span>
				</button>
				<a href="#" class="btn btn-info btn-icon-split ceklunas">
					<span class="icon text-white-50">
						<i class="fa fa-shopping-cart fa-fw"></i>
					</span>
					<span class="text">Transaksi Lunas</span>
				</a>
				<a href="#" class="btn btn-primary btn-icon-split cekBaru">
					<span class="icon text-white-50">
						<i class="fa fa-shopping-cart fa-fw"></i>
					</span>
					<span class="text">Transaksi Baru</span>
				</a>
				<a href="#" class="btn btn-warning btn-icon-split cekPending">
					<span class="icon text-white-50">
						<i class="fa fa-shopping-cart fa-fw"></i>
					</span>
					<span class="text">Transaksi Pending</span>
				</a>
				<a href="#" class="btn btn-danger btn-icon-split cekBatal">
					<span class="icon text-white-50">
						<i class="fa fa-shopping-cart fa-fw"></i>
					</span>
					<span class="text">Transaksi Batal</span>
				</a>
				<a href="javascript:void(0);" class="btn btn-info btn-icon-split url_doc flat" data-url="transaksi" data-toggle="tooltip" data-original-title="Dokumentasi Transaksi" data-placement="left">
					<span class="icon text-white-50">
						<i class="fa fa-info-circle fa-fw fa-lg"></i>
					</span>	
				</a>
			</div>
		</h1>
		
	</div>
	<div class="card">
		<div class="row">
			<div class="col-md-12">
				<div class="card-header pb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text flat">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select w-5" onchange="searchFilter()">
							<option value="DESC" selected>TERBARU</option>
							<option value="ASC">TERLAMA</option>
							<option value="min_order">ORDER KECIL - BESAR</option>
							<option value="max_order">ORDER BESAR - KECIL</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select w-5" onchange="searchFilter()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">PILIH</span>
						</div> 
						<select id="trx" name="trx" class="form-control custom-select w-5" onchange="searchFilter()">
							<?php foreach($select AS $key=>$val){
								echo '<option value="'.$key.'">'.$val.'</option>';
							}
							?>
						</select>
						<input type="text" id="tgl" class="form-control w-10 date-order" name="range" onchange="searchFilter();"/>
						<input type="text" id="keywords" class="form-control w-15" placeholder="Cari data" onkeyup="searchFilter();"/>
						<div class="btn-group" role="group" aria-label="Basic example">
							<button type="button"  class="btn btn-danger btn-sm clear flat" id="clear" data-toggle="tooltip" data-original-title="Clear filter"><i class="fa fa-times fa-1x"></i> Clear</button>
							<button type="button"  class="btn btn-info btn-sm print_order flat" id="print_order" data-toggle="tooltip" data-original-title="Print PDF"><i class="fa fa-file-pdf-o fa-1x"></i> Print</button>
						</div>
					</div>
				</div>
				
				<div class="post-list pt-0" id="dataList">
				</div>
				<table class="table table-striped table-mailcard">
					<thead class="thead-dark">
						<tr>
							<th style="width:6% !important;">&nbsp;</th>
							<th class="pl-0" style="width:14% !important;">&nbsp;</th>
							<th class="w-10">&nbsp;</th>
							<th style="width:10% !important;">&nbsp;</th>
							<th class="text-right w-10">TOTAL</th>
							<th class="text-right w-10">BAYAR</th>
							<th class="text-right w-10">DISKON</th>
							<th class="text-right w-10">PIUTANG</th>
							<th class="text-right w-3">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="font-weight-bold" colspan="4">TOTAL KESELURUHAN</td>
							<td class="text-right font-weight-bold w-10">
								<span class="total_order"></span>
							</td>
							<td class="text-right font-weight-bold w-10 total_bayar"></td>
							<td class="text-right font-weight-bold w-10">
								<span class="total_diskon"></span>
							</td>
							<td class="text-right font-weight-bold w-10 total_piutang"></td>
							<td style="width:16%!important"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form method="POST" action="<?=base_url();?>laporan/cetak_order_harian" id="target_print" target="_blank">
	<input type="hidden" name="sortby_cetak" id="sortby_cetak" readonly  />
	<input type="hidden" name="trx_cetak" id="trx_cetak" readonly />
	<input type="hidden" name="tanggal_cetak" id="tanggal_cetak" readonly  />
</form>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal left fade" id="OpenModalWa" role="dialog" tabindex="-1">
	<div class="modal-dialog" id="kirim-pesan">
		<div class="modal-content flat">
			<div class="modal-header pt-1 pb-1">
				<h4 class="modal-title" id="WaLabel">Kirim Invoice</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<div class="load-data-wa"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-sm flat kirim_pesan" type="button"><i class="fa fa-send"></i>&nbsp;Kirim</button> 
				<button class="btn btn-danger btn-sm flat" data-dismiss="modal" type="button">Batal</button> 
			</div>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="delete-order" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Konfirmasi penghapusan order</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus order dengan nomor <span id="data-hapus-trx"></span>, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
				<input type="hidden" id="data-hapus-order">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus_order_batal" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	 
	$('.date-order').daterangepicker({
		"autoApply": true,
		"dateLimit": {
			"days": 120
		},
		"alwaysShowCalendars": true,
		"startDate": tgl_awal,
		"endDate": end,
		"maxDate": end,
		"opens": "left",
		locale: {
			format: 'DD/MM/YYYY'
		},
		ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		}
		}, function(start, end, label) {
		// console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
	});
	 
	 
	// $('input[name="range"]').daterangepicker();
	// $('.cari_data').click(function(){
	// $('#myModalTab').modal('show');
	// var id =  $(this).data("id")
	// $('#tab01').click();
	// $('#cari_invoice').attr('disabled',false);
	// $('#keyword_cari').val(id)
	// $('#cari_invoice').click();
	// })
	
	$(".kirim_wa").click(function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var nomor = $(this).attr('data-nomor');
		var trx = $(this).attr('data-trx');
		var tgl = $(this).attr('data-tgl');
		// console.log(id);
		$('#WaLabel').html('Kirim '+trx);  
		$('#OpenModalWa').modal({backdrop: 'static', keyboard: false})  
		$.ajax({
			url: base_url + 'whatsapp/get_form_wa',
			data: {id:id,nomor:nomor,tgl:tgl},
			method: 'POST',
			dataType:'html',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$(".load-data-wa").html(data);
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	
	$(".kirim_pesan").click(function(e) {
		var dataform = $("#form-wa").serialize();
		$.ajax({
            type: "POST",
            url: base_url+"whatsapp/kirim_pesan",
            dataType: 'json',
            data: dataform,
			cache: false,
            beforeSend: function () {
                $('#kirim-pesan').loading({zIndex:1070,message:'kirim pesan...'});
			},
            success: handleKirim
			,error: function(xhr, status, error) {
                showNotif('top-right','Kirim pesan',error,'error');
                $('#kirim-pesan').loading('stop');
			}
		});
		
	});
	
	function handleKirim(data) {
		
		$('#kirim-pesan').loading('stop');
		$('#OpenModalWa').modal('hide'); 
		if(data.status=='offline'){
			showNotif('bottom-right','Kirim pesan',data.msg.detail,'danger');
			}else if(data.status==true){
			showNotif('bottom-right','Kirim pesan',data.msg.detail,'success');
			}else{
			var number = data.target; 
			var message = encodeURIComponent(data.msg);
			var url_wa = getLinkWhastapp(number,message)
			window.open(url_wa, '_blank');
		}
	}
	
	function getLinkWhastapp(number, message) {
		var url = 'https://wa.me/' 
		+ number 
		+ '?text='
		+ message
		return url
	}
	
	function open_popup(id)
	{
		
		var w = 880;
		var h = 570;
		var l = Math.floor((screen.width-w)/2);
		var t = Math.floor((screen.height-h)/2);
		if(thermal===1){
			$.post(base_url+"produk/print_invoice_html/"+id,{id: id},
			function(data, status){
				if(status=='success'){
					// alert("Data: " + data + "\nStatus: " + status);
				}
			});
			}else{
			var url_cetak = base_url +'produk/print_invoice_html/'+id;
			window.open(url_cetak, 'Cetak Invoice', "scrollbars=1");
		}
	}
	
	
	$("#print_order").click(function(e) {
		e.preventDefault();
		var sortby = $('#sortBy').val();
		var trx = $('#trx').val();
		var tanggal = $('#tgl').val();
		if(tanggal==''){
			sweet('Print Notif!!!','Tanggal masih kosong','warning','warning');
			return;
		}
		$('#sortby_cetak').val(sortby);
		$('#trx_cetak').val(trx);
		$('#tanggal_cetak').val(tanggal);
		$( "#target_print" ).submit();
	});
	// // var date2 = new Date();
	// // $('.date-order').datepicker({        
	// // format: 'dd/mm/yyyy', 
	// // "endDate": date2,
	// // autoclose: true,     
	// // todayHighlight: true,   
	// // todayBtn: 'linked',
	// // });  
	
	$(".hapus_invoice").click(function(e) {
		var id = $(this).attr('data-id');
		var idtrx = $(this).attr('data-trx');
		$('#data-hapus-order').val(id);
		$('#data-hapus-trx').html(idtrx);
		$('#delete-order').modal('show');
	});
	
	$(document).on('click','.hapus_order_batal',function(e){
		e.preventDefault();
		var id = $("#data-hapus-order").val();
		$.ajax({
			url: base_url + 'penjualan/hapus_order_batal',
			method: 'POST',
			dataType:'json',
			data:{id:id,type:"hapus"},
			beforeSend: function(){
				$('.hapus_order_batal').attr('disabled',true);
				$('body').loading();
			},
			success: function(data) {
				if(data.status==200){
					sweet_time(500,'Status!!!',data.msg);
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#delete-order').modal('hide');
				searchFilter();
				load_total();
				$('body').loading('stop');
				$('.hapus_order_batal').attr('disabled',false);
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	
</script>			