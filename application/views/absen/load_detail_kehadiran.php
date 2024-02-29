
<?php 
	if(!empty($detail)){
		$no =1;
		foreach($detail AS $val){
			$masuk = '00:00';
			if(!empty($val->masuk)){
				$masuk = times($val->masuk);
			}
			
			$pulang = '00:00';
			if(!empty($val->pulang)){
				$pulang = times($val->pulang);
			}
			$_masuk = new DateTime($val->masuk);
			$_pulang = new DateTime($val->pulang);
			$diff = $_pulang->diff( $_masuk );
			$lama_kerja_jam = ($diff->format( '%H' ))- 1;  //dikurangi istirahat
			$lama_kerja_menit = $diff->format( '%I' ); 
			$lama_kerja = $lama_kerja_jam . ":" . $lama_kerja_menit;
		?>
		<tr>
			<td><?=$no;?>.</td>
			<td><?=dtime($val->tgl);?></td>
			<td><?=$masuk;?></td>
			<td><?=$pulang;?></td>
			<td><?=$lama_kerja;?></td>
		</tr>
	<?php $no++; }}else{ echo '<tr><td colspan="4">Belum ada data</td></tr>';} ?>
		