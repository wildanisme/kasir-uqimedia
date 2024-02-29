<div id="posts_content">
	<?php if(!empty($list)){ ?>
		<div class="table-responsive">
			<table class="table card-table table-vcenter text-nowrap datatable">
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