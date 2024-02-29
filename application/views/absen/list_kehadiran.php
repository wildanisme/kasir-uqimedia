<?php
	if(!empty($kehadiran)){
		$no = 1;
		foreach($kehadiran AS $row)
		{
			$jam_masuk = '00:00';
			$jam_pulang = '00:00';
			if(empty($row->real_masuk)){
				$jam_masuk = times($row->masuk);
			}
			if(empty($row->masuk)){
				$jam_masuk = times($row->real_masuk);
			}
			if(!empty($row->masuk) AND !empty($row->real_masuk)){
				$jam_masuk = times($row->real_masuk);
			}
			
			if(empty($row->real_pulang)){
				$jam_pulang = times($row->pulang);
			}
			if(empty($row->pulang)){
				$jam_pulang = times($row->real_pulang);
			}
			
			if(!empty($row->real_pulang) AND !empty($row->pulang)){
				$jam_pulang = times($row->real_pulang);
			}
			if(empty($row->real_pulang) AND empty($row->pulang)){
				$jam_pulang = '00:00';
				
			}
		?>
		
		<tr>
			<td><?=$no;?></td>
			<td class="text-left"><?=juser($row->id_user);?></td>
			<td class="text-left"><?=dtime($row->tgl);?></td>
			<td class="text-right"><?=$jam_masuk;?></td>
			<td class="text-right"><?=$jam_pulang;?></td>
		</tr>';
		<?php	$no++; }	}else{
		echo '<tr><td colspan="4">Belum ada yang hadir</td></tr>';
	} 
