<div class="card-body table-responsive">
	<div class="card-block">
		<table class="table table-bordered table-striped table-mailcard" id="jsonuser">
			<thead>
				<tr>
					<th style="width:1% !important;">No.</th>
					<th>Nama</th>
					<th>No. HP</th>
					<?php if($sortBy=='last_order' OR $sortBy=='min_order' OR $sortBy=='max_order'){
						echo '<th class="text-right">Tgl.Order</th>';
						}else{
						echo '<th class="text-right">Tgl.Daftar</th>';
					} ?>
					<th class="text-right">Total Order</th>
					<th style="width:5%;">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($posts)){
					$no=$this->uri->segment(3)+1;
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