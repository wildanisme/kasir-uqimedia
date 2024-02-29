
<div class="table-responsive">
	<table class="table align-items-center table-flush">
		<thead class="thead-light">
			<tr>
				<th>Produk & Jasa</th>
				<th class="text-right w-5">Jumlah</th>
				<th class="text-right w-15">Omset</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$total = 0;
				$jumlah = 0;
				$grandtotal = 0;
			if(!empty($result)){
				$no = 1;
				foreach ($result as $row){
					$jumlah += $row->jumlah;
					$total = $row->total;
					$grandtotal += $row->total;
				?>
				<tr>
					<td><?=$row->title;?></td>
					<td class="text-right"><?=$row->jumlah;?></td>
					<td align="right"><?=rp($total);?></td>
				</tr>
			<?php }} ?>
		</tbody>
		<tfoot class="thead-light">
			<tr>
				<th>Total Omset</th>
				<th class="text-right"><?=$jumlah;?></th>
				<th class="text-right"><input type="hidden" id="total_pj" value="<?=($grandtotal);?>"><?=rp($grandtotal);?></th>
			</tr>
		</tfoot>
	</table>
</div>
