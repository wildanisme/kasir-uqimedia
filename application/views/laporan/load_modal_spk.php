<?php
	$kon = pilih('konsumen','id',$row->id_konsumen);
	if($kon['tampil']==1){
		$nick        = '';
		$nama        = $kon['perusahaan'];
		$telp        = $kon['no_telp'];
		$alamat      = $kon['alamat_lembaga'];
		}else{
		$nick        = $kon['panggilan'];
		$nama        = $kon['nama'];
		$telp        = $kon['no_hp'];
		$alamat      = $kon['alamat'];
	}
	$readonly ='';
	// if($status > 0){
		// $readonly ='readonly';
	// }
	
?>
<div class="row mb-2">
	<div class="col-md-12">
		<div class="card shadow-none row">
			<div class="card-body py-0">
				<div class="row">
					<div class="col-md-4">
						<div class="card shadow-none row">
							<div class="card-body py-0">
								Pelanggan : <?=$nama;?> (<?php echo $telp;?>)
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group mb-1">
							<div class="input-group">
								<span class="input-group-prepend col-4 ml-0 mr-0 pl-0 pr-0">
									<span class="input-group-text border-info bg-info col-12" data-toggle="tooltip" data-placement="right" title="Format MM/DD/YYYY">Tanggal Order</span>
								</span>
								<input type="date" class="form-control text-center tgl_invoice" id="tgl_invoice" value="<?=$row->tgl_trx;?>" readonly>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group mb-1">
							<div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text">No. Order</span>
								</span>
								<input type="text" class="form-control text-right margin-5" id="no_order" name="no_order" value="<?=$row->id_transaksi;?>" readonly>
								<input type="hidden" id="id_invoive" name="id_invoive" value="<?=encrypt_url($row->id_invoice);?>" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='row'>
	<div class="col-md-12">
		<table class="table table-striped table-sm" id="table_pengeluaran">
			<thead>
				<tr>
					<td style="width:5%" class="text-left">NO. SPK</td>
					<td style="width:5%" class="text-center">QTY</td>
					<td>PRODUK</td>
					<td>BAHAN</td>
					<td>UKURAN</td>
				</tr>
			</thead>
			
			<?php 
				$no=0;
				foreach($detail AS $val){
					$kategori = jkategori($val['id_produk']);
					if($kategori!=9){
						$generate_spk = "SPK-".$val['id_rincianinvoice'].tgl_spk($val['tgl_trx']);
						$no_spk = empty($val['no_spk']) ? $generate_spk : $val['no_spk'];
					?>
					<tbody><tr class="row_Count" id="row_Count<?=$no;?>">
						<td class="text-center">
							<input value="<?=$no_spk;?>" id="no_spk_<?=$no;?>" name="no_spk[]" type="hidden" readonly><?=$no_spk;?>
						</td>
						<td class="text-center">
							<input value="<?=$val['id_rincianinvoice'];?>" id="id_rincianinvoice_<?=$no;?>" name="id[]" type="hidden" readonly>
							<input class="form-control form-control-sm inputs" name="jumlah[]" value="<?php echo !empty($val['jumlah']) ? $val['jumlah'] : ''; ?>" type="hidden" readonly>
							<?=$val['jumlah'];?>
						</td>
						<td>
							<?=$val['title'];?>
						<input name="title[]" value="<?php echo !empty($val['title']) ? $val['title'] : ''; ?>" type="hidden" readonly></td>
					</td>
					<td>
						<?=$val['nbahan'];?>
					<input name="bahan[]" value="<?php echo !empty($val['nbahan']) ? $val['nbahan'] : ''; ?>" type="hidden" readonly></td>
					</td>
					<td>
						<?=$val['ukuran'];?>
					<input name="ukuran[]" value="<?php echo !empty($val['ukuran']) ? $val['ukuran'] : ''; ?>" type="hidden" readonly></td>
				</tr></tbody>
				<?php $no++;}
		}
	?>
</table>
</div>
</div>
<style>
	.img-responsive-height
	{
	display: block;
	width: auto;
	max-height: 500px
	}
	input[readonly] {
	pointer-events: none;
	}
	#tablein thead tr td{text-transform:uppercase}
	.card.shadow-none {
	-webkit-box-shadow: none !important;
	box-shadow: none !important;
	}
	
	.form-control {
	border-radius: 0 !important;
	}
	
	.input-group .form-control:last-child,
	.input-group-prepend:last-child,
	.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,
	.input-group-btn:first-child>.btn:not(:first-child),
	.input-group-btn:last-child>.btn,
	.input-group-btn:last-child>.btn-group>.btn,
	.input-group-btn:last-child>.dropdown-toggle {
	border-top-left-radius: 0px !important;
	border-bottom-left-radius: 0px !important;
	
	}
	
	.input-group-lg>.input-group-prepend>.input-group-text {
	padding: .5rem 1rem;
	font-size: 1.25rem;
	line-height: 1.5;
	border-radius: 0;
	}
	
	.input-group-prepend span {
	-webkit-box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
	box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2) !important;
	color: #fff;
	background-color: #888888;
	border-color: #777777;
	}
	
	.input-group-text {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	padding: .375rem .75rem;
	margin-bottom: 0;
	font-size: 1rem;
	font-weight: 400;
	line-height: 1.5;
	color: #6e707e;
	text-align: center;
	white-space: nowrap;
	background-color: #eaecf4;
	border: 1px solid #d1d3e2;
	border-top-color: rgb(209, 211, 226);
	border-right-color: rgb(209, 211, 226);
	border-bottom-color: rgb(209, 211, 226);
	border-left-color: rgb(209, 211, 226);
	border-radius: 0;
	
	}
	
	.btnDelete {
	cursor: pointer;
	color: red
	}
	
	
</style>
