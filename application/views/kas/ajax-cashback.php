<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table  table-striped table-mailcard" id="jsonuser">
			<thead class="thead-dark">
				<tr>
					<th class="w-2 text-center">#</th>
					<th class="w-25">Nama</th>
					<th class="w-10 text-right">Cash Masuk</th>
					<th class="w-10 text-right">Cash Keluar</th>
					<th class="w-10 text-right">Sisa Cash</th>
					<th class="w-10 text-right">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					
					$masuk=0;
					$keluar=0;
					$total_masuk=0;
					$total_keluar=0;
					$sisa_cash=0;
					$button='';
					if(!empty($result)){
						$no=$this->uri->segment(3)+1;
						foreach($result AS $aRow){ 
							$jenis_masuk ='';
							$jenis_keluar ='';
							if($aRow->total_masuk){
								$masuk = '<span class="text-success">'.rp($aRow->total_masuk).'</span>';
								$jenis_masuk = '<button class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-right"></i></button> ';
								$total_masuk += $aRow->total_masuk;
							}
							if($aRow->total_keluar){
								$keluar = '<span class="text-danger">'.rp($aRow->total_keluar).'</span>';
								$jenis_keluar = '<button class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i></button> ';
								$total_keluar +=$aRow->total_keluar;
							}
							$sisa = $aRow->total_masuk - $aRow->total_keluar;
							$sisa_cash += $aRow->total_masuk - $aRow->total_keluar;
						?>
						<tr style="">
							<td class="w-2 text-center"><?=$no;?></td>
							<td class="text-left"><?=$aRow->nama;?></td>
							<td class="text-right"><?=$jenis_masuk.$masuk;?></td>
							<td class="text-right"><?=$jenis_keluar.$keluar;?></td>
							<td class="text-right text-info"><?=rp($sisa);?></td>
							<td class="text-right text-info"><button class="btn btn-warning btn-sm add_widthdraw" data-id="<?=$aRow->id;?>" data-noin="<?=$aRow->id_invoice;?>" data-jumlah="<?=$aRow->total_masuk;?>"><i class="fa fa-arrow-circle-down"></i> Widthdraw</button> </td>
						</tr>
					<?php $no++;} ?>
					<?php }else{ ?>
					<tr>
						<td colspan="6">BELUM ADA DATA</td>
					</tr>
				<?php } ?>
				<tr>
					<td class="w-2 text-center"><button class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-right"></i></button></td>
					<td colspan="3" class="text-left text-success"><strong>TOTAL CASH MASUK</strong></td>
				<td class="text-right text-success"><strong><?=rp($total_masuk);?></strong></td>
				<td class="text-right text-success"></td>
				</tr>
				<tr>
					<td class="w-2 text-center"><button class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i></button></td>
					<td colspan="3" class="text-left text-danger"><strong>TOTAL CASH KELUAR</strong></td>
					<td class="text-right text-danger"><strong><?=rp($total_keluar);?></strong></td>
					<td class="text-right text-success"></td>
				</tr>
				<tr>
					<td class="w-2 text-center"><button class="btn btn-info btn-sm"><i class="fa fa-money"></i></button></td>
					<td colspan="3" class="text-left text-info"><strong>TOTAL SISA CASH</strong></td>
					<td class="text-right text-info"><strong><?=rp($sisa_cash);?></strong></td>
					<td class="text-right text-success"></td>
				</tr>
				
			</tbody>
		</table>
		<nav aria-label="Page navigation" class="mt-3">
			<?php echo $this->ajax_pagination->create_links(); ?>
		</nav>
	</div><!-- /.card-body -->
</div><!-- /.card-body -->
<script>
	$(".rekap").on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var tgl = $("#dari").val();
		var user = $('#user').val();
		var subtotal = $('#subtotal').val();
		
		if(subtotal==0){
			sweet('Peringatan!!!','Maaf Data masih kosong','warning','warning');
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/save_rekap_pengeluaran',
			method: 'POST',
			dataType: 'json',
			data :{tgl:tgl,id:id,user:user,subtotal:subtotal},
			success: function(data) {
				console.log(data);
				if(data.ok=='ok'){
					sweet('Rekap data!!!','Data berhasil direkap','success','success');
					FilterPengeluaran();
					}else{
					sweet('Rekap data!!!','Data telah direkap','warning','warning');
				}
			}
		})
	});
</script>										