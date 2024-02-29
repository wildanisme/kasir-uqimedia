<table class="table table-bordered table-striped table-mailcard" id="data_report">
	<thead class="thead-dark">
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Tujuan</th>
			<th>Pesan</th>
			<th style="width:5%;text-align:center">Status</th>
			<th style="width:5%;text-align:right">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(!empty($result)){
				$no = 1;
				foreach ($result as $row){
					$cekKonsumen = cekKonsumen($row->id_konsumen);
					if(empty($row->id_konsumen)){
						$konsumen = $row->target;
						}else{
						$konsumen = $cekKonsumen['nama'].' - '.$cekKonsumen['no_hp'];
					}
					$hapus = '<button type="button" class="btn btn-danger btn-icon-split btn-sm flat" data-id="'.encrypt_url($row->id).'" data-konsumen="'.encrypt_url($row->id_konsumen).'"  data-toggle="modal" data-target="#confirm-delete">
					<span class="icon text-white-50">
					<i class="fa fa-remove"></i>
					</span>
					<span class="text">Hapus</span>
					</button>';
					echo "<tr><td>$no</td>
					<td>{$konsumen}</td>
					<td class='text-left'>{$row->message}</td>
					<td class='text-center'>{$row->status}</td>
					<td class='text-right'>{$hapus}</td>
					</tr>";
					$no++;
				}
				}else{
				echo "<tr><td colspan='5'>Belum ada data</td></tr>";
			}
		?>
	</tbody>
</table>
<nav aria-label="Page navigation" class="mt-2">
	<?php echo $this->ajax_pagination->create_links(); ?>
</nav>