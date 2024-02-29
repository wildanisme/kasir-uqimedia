<div class="table-responsive">
	<table class="table table-sm table-striped table-hover">
		<thead>
			<tr>
				<th class="w-1 text-center">NO</th>
				<th>NAMA_BARANG/MERK</th>
				<th class="">KATEGORI</th>
				<th class="w-8 text-right">HARGA_BELI</th>
				<th class="w-5 text-right">STOK_SATUAN</th>
				<th class="w-2 text-center">DEFAULT</th>
				<th class="w-2 text-right">ATUR | STATUS | AKSI</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($result)){
				$no=$this->uri->segment(3)+1;
				foreach ($result as $row){
					if ($row->pub == 1){ 
						$aktif ='<i class="fa fa-check-circle"></i>'; 
						$text ='text-white'; 
						}else{ 
						$aktif = '<i class="fa fa-times"></i>'; 
						$text ='text-white-50'; 
					}
					if ($row->status_stok == 'Y'){ 
						$stok ='<i class="fa fa-check-circle"></i>'; 
						}else{ 
						$stok = '<i class="fa fa-times"></i>'; 
					}
					if ($row->featured == 1){ 
						$featured ='<a href="javascript:void(0)" data-id="'.$row->id.'" data-jenis="'.$row->id_jenis.'" data-featured="0"  class="featured"><i class="fa fa-star text-warning"></i></a>'; 
						}else{ 
						$featured = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-jenis="'.$row->id_jenis.'"  data-featured="1"  class="featured"><i class="fa fa-star-o"></i></a>'; 
					}
					$jml_masuk = stok_masuk($row->id) - stok_keluar($row->id);
					$hapus = '<button type="button" class="btn btn-danger btn-sm text-white"  data-id="'.$row->id.'" data-toggle="modal" data-target="#confirm-delete">Hapus</button>';
					echo "<tr><td class='text-center'>$no</td>
					<td class='pl-1'><a class='btn-sm add_bahan text-info' title='Edit Data' data-id='".$row->id."' href='#'>".$row->title."</a></td>
					<td class='text-left'>".jenis_cetakan($row->id_jenis)."</td>
					<td class='text-right'>".rp($row->harga_modal)."</td>
					<td class='text-right'>".rp($jml_masuk)." ".$row->satuan." ".$stok."</td>
					<td class='text-center'>".$featured."</td>
					<td class='text-right w-20'>
					<div class='btn-group btn-group-sm' role='group'>
					<a href='#' class='btn btn-success btn-sm'>{$row->type_harga}</a>
					<a href='#' data-type='".$row->type_harga."' data-id='".$row->id."' class='btn btn-success btn-sm menu_harga'><i class='fa fa-tag'></i></a>
					<button type='button' class='btn btn-success btn-sm menu_harga flat' data-type='".$row->type_harga."' data-id='".$row->id."'>Atur</button>
					<button type='button' class='btn btn-info btn-sm' data-id='".$row->id."'><span class='icon $text'>$aktif</span></button>
					<button type='button' class='btn btn-info btn-sm add_bahan flat' data-id='".$row->id."'></i>Edit</button>
					$hapus
					</div>
					</td>
					</tr>";
					$no++;
				} }else{ ?>
				<tr>
					<td colspan="7">Data belum ada</td>
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
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>