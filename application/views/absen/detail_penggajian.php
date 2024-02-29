<?php
	if(!empty($cekgajipokok)){
		
		$gaji_pokok = $cekgajipokok['gaji_pokok'];
		$makan = $cekgajipokok['makan'];
		$transport = $cekgajipokok['transport'];
		$asuransi = $cekgajipokok['asuransi'];
		$tun_jab = $cekgajipokok['tun_jab'];
		$jam_kerja = $cekgajipokok['jam_kerja'];
		$istirahat = $cekgajipokok['istirahat'];
		
		
		}else{
		$gaji_pokok = 0;
		$makan = 0;
		$transport = 0;
		$asuransi = 0;
		$tun_jab = 0;
		$jam_kerja = 0;
		$istirahat = 0;
	}
	 
	if(!empty($cekbonus)){  	  
		$bonus = $cekbonus->bonus;
		$ket_bonus = $cekbonus->keterangan;
		
		}else{
		$bonus = 0;
		$ket_bonus = "";
	}
	if(!empty($uang_makan)){  	  
		$uang_makan = $uang_makan->jumlah;
		}else{
		$uang_makan = 0;
	}
	 
	if(!empty($uang_transport)){  	  
		$uang_transport = $uang_transport->jumlah;
		}else{
		$uang_transport = 0;
	}
	// print_r($row_gaji);exit;
	if(!empty($row_gaji)){
		
		$id_slip = $row_gaji['id_slip'];
		$lembur			= $row_gaji['lembur'];
		$gaji_kotor		= $row_gaji['gaji_kotor'];
		$total_lembur	= $row_gaji['lembur'];
		$tot_makan		= $row_gaji['tot_makan'];
		$tot_transport	= $row_gaji['tot_transport'];
		$tot_tun_cuti	= $row_gaji['tot_tun_cuti'];
		$tot_tun_libur	= $row_gaji['tot_tun_libur'];
		$tot_tun_jab	= $row_gaji['tot_tun_jab'];
		$pot_absen		= $row_gaji['pot_absen'];
		$pot_asuransi	= $row_gaji['pot_asuransi'];
		$pot_kasbon		= $row_gaji['pot_kasbon'];
		
		$tot_gaji = $lembur + $gaji_kotor + $tot_tun_cuti  + $tot_tun_libur + $tot_tun_jab + $tot_makan + $tot_transport - $pot_asuransi + $bonus - abs($pot_kasbon);
		
		}else{
		$id_slip = '';
		$rekap ='N';
		$tot_gaji='';
		// $pot_kasbon='';
	}
	//cek kasbon
	if(empty($row_gaji)){
		$pot_kasbon = $kasbon['debet'] - $kasbon['kredit'];
	}
	 
 
?>

<input type="hidden" class="form-control text-center" id="bln" name="bln" value="<?=getMonth($tglawal);?>">
<input type="hidden" class="form-control text-center" id="thn" name="thn" value="<?=getYear($tglawal);?>">
<div class="row mb-3">
	<div class="col-md-12">
		<!-- Form Elements -->
		<div class="card">
			<div class="card-header">
				Rincian Gaji  <b><?=$nama;?></b> Bulan <b><?=date("F Y",strtotime($tglakhir));?></b>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="card mb-3">
							<div class="card-header">
								Gaji Dasar <span class="button-btn pull-right"><a href="javascript:void(0)" data-toggle="tooltip" title="Tambah Catatan" class="tooltip-left" onclick="showModalsG('<?=$iduser;?>')"><i class="fa fa-edit"></i> Edit</a></span>
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Gaji Pokok</span>
									</div>
									<input type="text" class="form-control text-right" id="gaji_pokok" value="<?=rp($gaji_pokok);?>" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Uang Makan</span>
									</div>
									<input type="text" class="form-control text-right" id="makan" value="<?=rp($makan);?>" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Uang Transport</span>
									</div>
									<input type="text" class="form-control text-right" id="transport" value="<?=rp($transport);?>" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Asuransi</span>
									</div>
									<input type="text" class="form-control text-right" id="asuransi" value="<?=rp($asuransi);?>" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Tunjangan Jabatan</span>
									</div>
									<input type="text" class="form-control text-right" id="tun_jab" value="<?=rp($tun_jab);?>" readonly="readonly">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Jumlah Jam Kerja</span>
									</div>
									<input type="text" class="form-control text-right" id="jam_kerja" value="<?=rp($jam_kerja);?>" readonly="readonly">
								</div>                                     
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Jumlah Jam Istirahat</span>
									</div>
									<input type="text" class="form-control text-right" id="istirahat" value="<?=rp($istirahat);?>" readonly="readonly">
								</div>
							</div>
						</div>
						
						<div class="card">
							<div class="card-header">
								Jumlah Hari Kerja
							</div>
							<div class="card-body">
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Jumlah Hari Kerja</span>
									</div>
									<input type="text" class="form-control text-right" id="jmlhari" readonly="readonly">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Jumlah Hari Sakit </span>
									</div>
									<input type="text" class="form-control text-right" id="jmlharicuti" readonly="readonly">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Jumlah Hari Libur</span>
									</div>
									<input type="text" class="form-control text-right" id="jmlharilibur" readonly="readonly">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="card">
							<div class="card-header">Perhitungan Gaji</div>
							<div class="card-body">
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Gaji Kotor</span>
									</div>
									<input type="text" class="form-control text-right" id="gaji_kotor" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Total Lembur</span>
									</div>
									<input type="text" class="form-control text-right" id="total_lembur" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Uang Makan</span>
									</div>
									<input type="text" class="form-control text-right" id="tot_makan" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Uang Transport</span>
									</div>
									<input type="text" class="form-control text-right" id="tot_transport" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Tunjangan Sakit</span>
									</div>
									<input type="text" class="form-control text-right" id="tun_cuti" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
									<span class="input-group-text">Tunjangan Hari Libur</span></div>
									<input type="text" class="form-control text-right" id="tun_libur" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
									<span class="input-group-text">Tunjangan Jabatan</span></div>
									<input type="text" class="form-control text-right" id="tun_jabatan" readonly="readonly">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<button class="btn btn-primary btn-icon-split btn-sm"  onClick="showModalsB('<?=$iduser;?>','<?=$tglawal;?>','<?=$tglakhir;?>')">
											<span class="icon text-white-50">
												<i class="fa fa-edit"></i>
											</span>
											<span class="text">Bonus</span>
										</button>
									</div>
									<input type="text" class="form-control form-control-sm text-right" id="bonus" readonly="readonly">
								</div>
								
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
									<span class="input-group-text"><b>Potongan Absen</b></span></div>
									<input type="text" class="form-control text-right" id="pot_absen" readonly="readonly">
								</div>	                                     
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
									<span class="input-group-text">Potongan Asuransi</span></div>
									<input type="text" class="form-control text-right" id="pot_asuransi" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
									<span class="input-group-text"><b>Gaji Bersih</b></span></div>
									<input type="text" class="form-control text-right" id="gaji_bersih" readonly="readonly">
								</div>
								 
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<button class="btn btn-primary btn-icon-split btn-sm"  onClick="showKasbon('<?=$iduser;?>','<?=$tglawal;?>','<?=$tglakhir;?>')">
											<span class="icon text-white-50">
												<i class="fa fa-edit"></i>
											</span>
											<span class="text">Potongan Kasbon</span>
										</button>
									</div>
									<input type="text" class="form-control form-control-sm text-right" id="kasbon" value="<?=$pot_kasbon;?>">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<button class="btn btn-primary btn-icon-split btn-sm"  onClick="showUangMakan('<?=$iduser;?>','<?=$tglawal;?>','<?=$tglakhir;?>')">
											<span class="icon text-white-50">
												<i class="fa fa-edit"></i>
											</span>
											<span class="text">Total Uang Makan diambil</span>
										</button>
									</div>
									<input type="text" class="form-control form-control-sm text-right" id="uang_makan_diambil" readonly="readonly">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<button class="btn btn-primary btn-icon-split btn-sm"  onClick="showUangTransport('<?=$iduser;?>','<?=$tglawal;?>','<?=$tglakhir;?>')">
											<span class="icon text-white-50">
												<i class="fa fa-edit"></i>
											</span>
											<span class="text">Total Uang Transport diambil</span>
										</button>
									</div>
									<input type="text" class="form-control form-control-sm text-right" id="uang_transport_diambil" readonly="readonly">
								</div>
								<div class="input-group input-group-sm mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text"><b>Gaji diterima</b></span>
									</div>
									<input type="text" class="form-control text-right" id="gajiditerima" readonly="readonly">
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<!-- End Form Elements -->
	</div>
</div>
<!-- /. ROW  -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-3" id="GFG">
			<div class="card-header">
				Rincian Perhitungan Gaji <b><?=$nama;?></b> bulan August 2022 (dihitung permenit)
				<span class="pull-right no-print"><a class="btn btn-sm btn-white m-b-10 p-l-5" href="javascript:;" onclick="printDiv()"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a></span>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center p-1">No.</th>
								<th class="text-center p-1">Tanggal</th>
								<th class="text-center p-1">Jam_Masuk</th>
								<th class="text-center p-1">Jam_Pulang</th>
								<th class="text-center p-1">LamaKerja</th>
								<th class="text-center p-1">Lembur</th>
								<th class="text-center p-1">Gaji_Kotor</th>
								<th class="text-center p-1">Potongan</th>
								<th class="text-center p-1">Lembur</th>
								<th class="text-center p-1">Gaji_Bersih</th>
							</tr>
						</thead>
						
						<tbody>
							<?php
								
								$total_gaji_kotor = 0;
								$total_lembur = 0;
								$total_gaji_pokok = 0;
								$total_potongan = 0 ;
								$total_uang_makan = 0;
								$total_transport = 0;
								$total_gaji_bersih = 0;
								$jmlhari = 0;
								$jml_hari = 1;
								$gaji_pokok_perhari = $gaji_pokok/$hari_kerja;
								
								//echo $tglakhir;
								
								$no=1;
								if($gaji_pokok_perhari > 0){
									foreach($kehadiran AS $rowg){
										$tgl = 	$rowg['tgl'];	
										
										if($rowg['jam_masuk_lembur']!=''){
											$jam_masuk_lembur = $rowg['jam_masuk_lembur'];
											$jam_pulang_lembur =  $rowg['jam_pulang_lembur'];
											}else{
											$jam_masuk_lembur = $tgl.' 00:00:00';
											$jam_pulang_lembur = $tgl.' 00:00:00';
										}
										
										$jam_masuk_lembur = new DateTime($jam_masuk_lembur);
										$jam_pulang_lembur = new DateTime($jam_pulang_lembur);
										
										$masuk = new DateTime($rowg['masuk']);
										$pulang = new DateTime($rowg['pulang']);
										$diffl = $jam_pulang_lembur->diff( $jam_masuk_lembur );
										
										$diff = $pulang->diff( $masuk );
										
										
										$lama_kerja_jam = ($diff->format( '%H' ))- $istirahat;  //dikurangi istirahat
										$lama_kerja_menit = $diff->format( '%I' ); 
										$lama_kerja = $lama_kerja_jam . ":" . $lama_kerja_menit;
										$lama_kerja_dalam_menit = (($jam_kerja)*60);
										
										$gaji_pokok_permenit= $gaji_pokok/($jam_kerja*$hari_kerja*60);
										
										
										//Hitung Lembur
										// if ($lama_kerja_jam>=$jam_kerja){
										if ($lama_kerja_jam>=$jam_kerja){
											$lama_lembur_jam = $lama_kerja_jam - $jam_kerja;
											$lama_lembur_menit = $lama_kerja_menit;
											
											$lama_lembur_dalam_menit = ($lama_lembur_jam*60) + $lama_lembur_menit;
											//hitung nominal lembur
											if ($lama_lembur_jam > 1){
												$lembur_satujam_pertama = round($gaji_pokok_permenit * 60 * 1.5) ; //satu jam pertama di gaji pokok kali 1,5
												$lembur_jamberikutnya = round($gaji_pokok_permenit * ($lama_lembur_dalam_menit-60) * 2); //jam berikutnya gaji pokok kali 2
												}else{
												$lembur_satujam_pertama = round($gaji_pokok_permenit * $lama_lembur_dalam_menit * 1.5) ; //satu jam pertama di gaji pokok kali 1,5
												$lembur_jamberikutnya = '0';
											}
											$lembur = $lembur_satujam_pertama + $lembur_jamberikutnya;
											
											}else{
											$lama_kerja_dalam_menit = (($lama_kerja_jam)*60) + ($lama_kerja_menit);
											$lama_lembur_dalam_menit = '0';
											$lama_lembur_jam = '0';
											$lama_lembur_menit = '0';
											$lembur = '0';
										}
										
										$gaji_kotor_sehari = round($gaji_pokok_permenit * $lama_kerja_dalam_menit);
										//Hitung Potongan Absen
										if ($lama_kerja_jam < $jam_kerja){
											$potongan = round($gaji_pokok_perhari - $gaji_kotor_sehari);
											}else{
											$potongan = 0;
										}	
										
										$total_gaji_kotor= $total_gaji_kotor + $gaji_kotor_sehari ;
										$gaji_bersih = $gaji_kotor_sehari + $lembur ;
										$total_lembur = $total_lembur + $lembur;
										$total_gaji_pokok = $total_gaji_pokok + $gaji_kotor_sehari;
										$total_potongan = $total_potongan + $potongan ;
										$total_uang_makan = $makan*$jml_hari;
										$total_transport =  $transport * $jml_hari;
										$total_gaji_bersih = $total_gaji_bersih + $gaji_bersih;
										$jml_hari++;
										$jmlhari++;
										
									?>		
									
									<tr class="odd gradeX">
										<td class="text-center p-0"><?=$no++;?></td>
										<td class="text-center p-0"><?=dtime($rowg['tgl']);?></td>
										<td class="text-center p-0"><?=jam_ambil($rowg['masuk']);?></td>
										<td class="text-center p-0"><?=jam_ambil($rowg['pulang']);?></td>
										<td class="text-center p-0"><?=$lama_kerja;?></td>
										<td class="text-center p-0"><?=$lama_lembur_jam . ":" . $lama_lembur_menit;?></td>
										<td class="text-center p-0"><?=rp($gaji_kotor_sehari);?></td>
										<td class="text-center p-0"><?=rp($potongan);?></td>
										<td class="text-center p-0"><?=rp($lembur);?></td>
										<td class="text-center p-0"><?=rp($gaji_bersih);?></td>
									</tr>
									<?php
									}
									}else{
									echo '<tr class="odd gradeX">
									<td colspan="9">Belum ada data</td>
									</tr>';
								}
								
							?>									
							
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
		
		<div class="card mb-3">
			<div class="card-header">
				Kasbon <b><?=$nama;?></b> Dari Tanggal <b>01 Agustus 2022</b> sampai dengan <b>31 Agustus 2022</b><span class="button-btn pull-right"><a href="#"><i class="fa fa-pencil-square-o"></i></a></span>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th class="text-left">Tanggal</th>
								<th class="text-left">Jenis</th>
								<th>Catatan</th>
								<th class="text-right">Debet</th>
								<th class="text-right">Kredit</th>
							</tr>
						</thead>
						<tbody>
							
							<?php
								foreach($detail_kasbon AS $rowb){
								?>
								<tr class="odd gradeX">
									<td class="text-left"><?=dtime($rowb['tgl_kasbon']);?></td>
									<td><?=$rowb['jenis_kasbon'];?></td>
									<td><?=$rowb['catatan'];?></td>
									<td class="text-right"><?=$rowb['debet'];?></td>
									<td class="text-right"><?=$rowb['kredit'];?></td>
								</tr>
								<?php
								}
								$sisakasbon = $kasbon['debet']-$kasbon['kredit'];
							?>
							<tr>
								<td colspan="5">Total Sisa Kasbon Rp.<?=rp($sisakasbon);?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>
<!-- /. ROW  -->
<div class="row mb-3">
	<div class="col-sm-6">			
		<div class="card">
			<div class="card-header pb-0">
				Jumlah Hari Sakit </b><span class="button-btn pull-right">
					<a href="javascript:void(0);" class="btn btn-primary btn-icon-split btn-sm" id="addLink" onclick="javascript:$('#addFormC').slideToggle();">
						<span class="icon text-white-50">
							<i class="fa fa-plus"></i>
						</span>
						<span class="text">Tambah</span>
					</a>
				</span>
			</div>
			<div class="card-body none formData" id="addFormC">
				<h5 id="actionLabel">Add Izin / Cuti / Sakit <?=$nama;?></h5>
				<form class="form" id="cutiForm">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" class="form-control tanggalc" name="tgl" id="tgl">
					</div>
					
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Keterangan</span>
						</div>
						<input type="text" class="form-control" name="keterangan" id="keterangan">
					</div>
					
					<input type="hidden" class="form-control" name="iduser" id="iduser" value="<?=$iduser;?>">
					<input type="hidden" class="form-control" name="tgla" id="tgla" value="<?=$tglawal;?>">
					<input type="hidden" class="form-control" name="tglak" id="tglak" value="<?=$tglakhir;?>">
					<a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="$('#addFormC').slideUp();">Batal</a>
					<a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="cutiAction('add')">Simpan</a>
				</form>
			</div>
			<div class="card-body none formData" id="editFormC">
				<h5 id="actionLabel">Edit Izin / Cuti / Sakit <?=$nama;?></h5>
				<form class="form" id="cutiForm">
					
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" class="form-control tanggal" name="tgl" id="tglEdit" required="">
					</div>
					
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Keterangan</span>
						</div>
						<input type="text" class="form-control" name="keterangan" id="keteranganEdit" required="">
					</div>
					
					<input type="hidden" class="form-control" name="iduser" id="iduserEdit">
					<input type="hidden" class="form-control" name="id" id="idEdit">
					<input type="hidden" class="form-control" name="tgla" id="tglaEdit" value="<?=$tglawal;?>">
					<input type="hidden" class="form-control" name="tglak" id="tglakEdit" value="<?=$tglakhir;?>">
					<a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="$('#editFormC').slideUp();">Batal</a>
					<a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="cutiAction('edit')">Update</a>
				</form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th class="text-center">Tanggal</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="CutiData">
							<?php
								
								$cuti = 0;
								
								if(!empty($cekcuti)){
									foreach($cekcuti AS $rowc){
									?>
									<tr class="odd gradeX">
										<td class="text-center"><a href="javascript:void(0);" onclick="editCuti('<?php echo $rowc['id']; ?>')"><?=tgl_ambil($rowc['tgl']);?></a></td>
										<td><?=$rowc['keterangan'];?></td>
										<td>
											<a href="javascript:void(0);" class="fa fa-trash" onclick="return confirm('Are you sure to delete data?')?cutiAction('delete','<?php echo $rowc['id']; ?>'):false;"></a>
										</td>
									</tr>
									<?php
										$cuti++;
									}
									}else{
									echo '<tr><td colspan="6">Data masih kosong ...</td></tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				
			</div>
			
		</div>
		
	</div>
	<div class="col-sm-6">			
		<div class="card">
			<div class="card-header pb-0">
				Hari Libur Nasional <span class="button-btn pull-right">
					<a href="javascript:void(0);" class="btn btn-primary btn-icon-split btn-sm" id="addLink" onclick="javascript:$('#addForm').slideToggle();">
						<span class="icon text-white-50">
							<i class="fa fa-plus"></i>
						</span>
						<span class="text">Tambah</span>
					</a>
				</span>
			</div>
			<div class="card-body none formData" id="addForm">
				<h5 id="actionLabel">Add Hari Libur</h5>
				<form class="form" id="liburForm">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" class="form-control tanggal" name="tgl" id="tglL">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Keterangan</span>
						</div>
						<input type="text" class="form-control" name="keterangan" id="keteranganL">
					</div>
					<a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="$('#addForm').slideUp();">Batal</a>
					<a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="liburAction('add')">Simpan</a>
				</form>
			</div>
			<div class="card-body none formData" id="editForm">
				<h5 id="actionLabel">Edit Hari Libur</h5>
				<form class="form" id="liburForm">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" class="form-control tanggal" name="tgl" id="tglEditL">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Keterangan</span>
						</div>
						<input type="text" class="form-control" name="keterangan" id="keteranganEditL">
					</div>
					<input type="hidden" class="form-control" name="id" id="idEditL">
					<a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="$('#editForm').slideUp();">Batal</a>
					<a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="liburAction('edit')">Update</a>
				</form>
			</div>
			
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">Tanggal</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="LiburData">
							<?php
								$libur = 0;
								if(!empty($cekharilibur)){
									foreach($cekharilibur AS $rowl){
									?>
									<tr class="odd gradeX">
										<td class="text-center"><a href="javascript:void(0);" onclick="editLibur('<?php echo $rowl['id']; ?>')"><?=tgl_ambil($rowl['tgl']);?></a></td>
										<td><?=$rowl['keterangan'];?></td>
										<td>
											<a href="javascript:void(0);" class="fa fa-trash" onclick="return confirm('Are you sure to delete data?')?liburAction('delete','<?php echo $rowl['id']; ?>'):false;"></a>
										</td>
									</tr>
									<?php
										$libur++;
									}
									}else{
									echo '<tr><td colspan="6">Data masih kosong ...</td></tr>';
								}
							?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>


<!--modal:S-->

<div id="edit_gaji" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Edit Gaji Pokok</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<span class="error"></span>
				<form id="formGaji">
					<input type="hidden" class="form-control" id="id" name="id">
					<input type="hidden" class="form-control" id="type" name="type">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Gaji Pokok</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="gaji_pokokE" name="gaji_pokok">
					</div>
					
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Uang Makan</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="makanE" name="makan">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Uang Transport</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="transportE" name="transport">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Asuransi</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="asuransiE" name="asuransi">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tunjangan Jabatan</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="tun_jabE" name="tun_jab">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Jam Kerja</span>
						</div>
						<input type="text" class="form-control text-right" id="jam_kerjaE" name="jam_kerja">
					</div>				 
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Jam Istirahat</span>
						</div>
						<input type="text" class="form-control text-right" id="istirahatE" name="istirahat">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="submitGaji()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>

<div id="edit_bonus" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Bonus <b><?=$nama;?></b> Bulan <b>August 2022</b> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form id="formBonus">
					<input type="hidden" id="iduser_bonus" name="id">
					<input type="hidden" id="tglawal_bonus" name="tgl1">
					<input type="hidden" id="tglakhir_bonus" name="tgl2">
					<input type="hidden" id="type_bonus" name="type">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Besarnya Bonus</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="bonus_bonus" name="bonus_bonus">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Keterangan</span>
						</div>
						<input type="text" class="form-control text-right" id="ket_bonus" name="ket_bonus">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="submitBonus()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>
<!--modal uang makan-->
<div id="edit_uang_makan" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Uang Makan <b><?=$nama;?></b> Bulan <b>August 2022</b> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form id="formUangMakan">
					<input type="hidden" id="iduser_makan" name="id">
					<input type="hidden" id="tglawal_makan" name="tgl1">
					<input type="hidden" id="tglakhir_makan" name="tgl2">
					<input type="hidden" id="type_makan" name="type">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Jumlah uang yang diambil</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="jumlah_uang_makan_diambil" name="jumlah_uang_makan_diambil">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="submitUangMakan()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>
<!--modal uang transport-->
<div id="edit_uang_transport" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Uang Transport <b><?=$nama;?></b> Bulan <b>August 2022</b> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form id="formUanTrans">
					<input type="hidden" id="iduser_trans" name="id">
					<input type="hidden" id="tglawal_trans" name="tgl1">
					<input type="hidden" id="tglakhir_trans" name="tgl2">
					<input type="hidden" id="type_trans" name="type">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Jumlah uang yang diambil</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="jumlah_uang_transport_diambil" name="jumlah_uang_transport_diambil">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="submitUangTransport()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>
<!--modal kasbon-->
<div id="edit_kasbon" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Potong Kasbon<b><?=$nama;?></b> Bulan <b>August 2022</b> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form id="formKasbon">
					<input type="hidden" id="iduser_kasbon" name="id">
					<input type="hidden" id="tglawal_kasbon" name="tgl1">
					<input type="hidden" id="tglakhir_kasbon" name="tgl2">
					<input type="hidden" id="type_kasbon" name="type">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Jumlah Kasbon</span>
						</div>
						<input type="text" class="form-control text-right" onkeyup="format(this);" id="jml_bayar_kasbon" name="jml_bayar_kasbon">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="submitKasbon()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>
<!-- /.modal -->
<div id="bayar" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Bayar Gaji</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<form class="bayar" id="formBayar">
					<span id="notif"></span>
					<input type="hidden" id="id_usr" name="id_usr" value="443">	
					<input type="hidden" id="id_slip" name="id_slip" value="">	
					<input type="hidden" id="tglakhir" name="tglakhir" value="<?=$tglakhir;?>">
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Cara Bayar</span>
						</div>
						<select name="id_byr" id="id_byr" value="" class="selectpicker  show-tick form-control" data-style="btn-info">
							<option value="1">Tunai</option>
							<option value="2">Transfer BCA</option>
							<option value="9">Transfer Bank BNI</option>
							<option value="10">Transfer Bank Mandiri</option>
							<option value="11">Transfer Bank Jabar</option>
							<option value="21">Tranfer Bank BJB</option>
							<option value="19">Transfer Bank BRI</option>
						</select> 
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Tanggal</span>
						</div>
						<input type="text" id="tanggal" name="tanggal" class="date-picker form-control margin-5">
					</div>
					
					<br>
					
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Gaji yang dibayarkan</span>
						</div>
						<input type="text" name="uang" id="uang" onkeyup="format(this)" value="" class="form-control margin-5" required="">
					</div>
					<div class="input-group input-group-sm mb-1">
						<div class="input-group-prepend">
							<span class="input-group-text">Sisa yang Harus Dibayar</span>
						</div>
						<input type="text" name="sisabayar" id="sisabayar" class="form-control margin-5" readonly="readonly" value="0">
					</div>				
					<div class="box-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width:2%">No</th>
									<th style="width:10%">Tanggal</th>
									<th style="width:10%">Pinjam</th>
									<th style="width:10%">Bayar</th>
									
								</tr> 
							</thead>
							<tbody>
								
								<?php
									$nom = 1;
									foreach($detail_kasbon AS $rowb){
									?>
									<tr class="odd gradeX">
										<td class="text-center"><?=$nom++;?></td>
										<td class="text-center"><?=tgl_ambil($rowb['tgl_kasbon']);?></td>
										<td class="text-right"><?=$rowb['pinjam'];?></td>
										<td class="text-right"><?=$rowb['bayar'];?></td>
									</tr>
									<?php
									}
									
									$_sisakasbon = $kasbon['debet']-$kasbon['kredit'];
								?>
								<tr>
									<td colspan="2">Sisa Total Kasbon Rp.<?=rp($_sisakasbon);?></td>
									<td colspan="2"></td>
								</tr>
							</tbody>
						</table>
						<div class="input-group input-group-sm mb-1">
							<div class="input-group-prepend">
								<span class="input-group-text">Total Bayar</span>
							</div>
							<input type="text" name="tot_bayar" id="total"  class="form-control margin-5" readonly="">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" onclick="submitBayar()" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>	
</div>	
</div>		

<?php
	$tun_cuti = $cuti * $gaji_pokok_perhari;
	
	$potongan_lain = $uang_makan + $uang_transport + $pot_kasbon;
	
	$tun_libur = $libur * $gaji_pokok_perhari;
	$total_gaji_bersih = $total_gaji_bersih + $tun_cuti  + $tun_libur + $tun_jab + $total_uang_makan + $total_transport - $asuransi + $bonus;
	$total_gaji_diterima = $total_gaji_bersih - $potongan_lain;
	 
?>    

<style id="table_style" type="text/css">
	
    table
    {
	border: 1px solid #ccc;
	border-collapse: collapse;
    }
    table th
    {
	background-color: #F7F7F7;
	color: #333;
	font-weight: bold;
    }
    table th, table td
    {
	padding: 2px;
	border: 1px solid #ccc;
    }
	@media print
	{    
	.no-print, .no-print *
	{
	display: none !important;
	}
	}
</style>

<script>
	function printDiv() {
        var printWindow = window.open('', '', 'height=600,width=600');
        printWindow.document.write('<html><head><title>Detail Kehadiran</title>');
		
        //Print the Table CSS.
        var table_style = document.getElementById("table_style").innerHTML;
        printWindow.document.write('<style type = "text/css">');
        printWindow.document.write(table_style);
        printWindow.document.write('</style>');
        printWindow.document.write('</head>');
		
        //Print the DIV contents i.e. the HTML Table.
        printWindow.document.write('<body>');
        var divContents = document.getElementById("GFG").innerHTML;
        printWindow.document.write(divContents);
        printWindow.document.write('</body>');
		
        printWindow.document.write('</html>');
        printWindow.document.close();
        printWindow.print();
	}
	
	function rekap(){
		iduser = document.getElementById("iduser").value; 
		tglakhir = document.getElementById("tglakhir").value; 
		gaji_pokok = document.getElementById("gaji_pokok").value; 
		tun_jab = document.getElementById("tun_jab").value; 
		transport = document.getElementById("transport").value; 
		makan = document.getElementById("makan").value; 
		asuransi =document.getElementById("asuransi").value; 
		jam_kerja = document.getElementById("jam_kerja").value; 
		istirahat = document.getElementById("istirahat").value; 
		jmlhari = document.getElementById("jmlhari").value;  //jmlhari
		jmlharicuti = document.getElementById("jmlharicuti").value;  //jmlharicuti
		jmlharilibur = document.getElementById("jmlharilibur").value;  //jmlharilibur
		gaji_kotor =document.getElementById("gaji_kotor").value; 
		total_lembur = document.getElementById("total_lembur").value;  //total_lembur
		tot_makan = document.getElementById("tot_makan").value;  //uang_makan
		tot_transport = document.getElementById("tot_transport").value; 
		tot_tun_cuti = document.getElementById("tun_cuti").value;  //tun_cuti
		tot_tun_libur = document.getElementById("tun_libur").value;  //tun_libur
		tot_tun_jab = document.getElementById("tun_jabatan").value;  / //bonus
		bonus = document.getElementById("bonus").value;  / //bonus
		pot_absen = document.getElementById("pot_absen").value;  //potongan
		pot_asuransi = document.getElementById("pot_asuransi").value;  //pot_asuransi
		pot_kasbon = document.getElementById("kasbon").value; 
		uang_makan = document.getElementById("uang_makan_diambil").value; 
		uang_transport = document.getElementById("uang_transport_diambil").value; 
		 
		$.ajax({
			url: base_url+"post/rekap",
			type: 'POST',
			data: {gaji_pokok:gaji_pokok,tun_jab:tun_jab,transport:transport,makan:makan,asuransi:asuransi,jam_kerja:jam_kerja,istirahat:istirahat,jmlhari:jmlhari,jmlharicuti:jmlharicuti,jmlharilibur:jmlharilibur,gaji_kotor:gaji_kotor,total_lembur:total_lembur,tot_makan:tot_makan,tot_transport:tot_transport,tot_tun_cuti:tot_tun_cuti,tot_tun_libur:tot_tun_libur,tot_tun_jab:tot_tun_jab,bonus:bonus,pot_absen:pot_absen,pot_asuransi:pot_asuransi,pot_kasbon:pot_kasbon,uang_makan:uang_makan,uang_transport:uang_transport,tglakhir:tglakhir,iduser:iduser},
			beforeSend: function(){
				$("body").loading();
			},
			success: function(data) {
				if (data.status==200) {
					sweet('Rekap!!', data.msg, "success","success");
					$('.detail_kehadiran').click()
					}else{
					sweet('Rekap!!', data.msg, "warning","warning");
				}
				$("body").loading('stop');
			},
			error : function(res, status, httpMessage) {
				$("body").loading('stop');
				sweet("Peringatan!!!", httpMessage, "warning", "warning");
			}
		});
		
	}
	$('.tanggal,.tanggalc,.date-picker').datepicker({
		autoclose: true,
		todayBtn: "linked",
		format: 'dd/mm/yyyy'
	});
	$("input[type=text]").focus(function() {
		$(this).select();
	});
	var users = $("#iduser").val();
	
	var tglakhirs = $("#tglakhir").val();
	
	$.ajax({
		url: base_url+"post/cek_rekap",
		type: 'POST',
		data: {iduser:users,tglakhir:tglakhirs},
		dataType:'json',
		success: function(data) {
			// console.log(data);
			if (data.status==200) {
				if (data.msg=='Y') {
					$(".slip").show();
					$("#klipp").html(data.judul);
					$(".klip").removeClass("btn-danger").addClass("btn-success");
					}else{
					$(".slip").hide();
					$("#klipp").html(data.judul);
					$(".klip").removeClass("btn-success").addClass("btn-danger");
				}
			}
		}
	});
	$(document).ready(function() {
		$("#gaji_kotor").val("<?=rp(($total_gaji_kotor));?>"); 		
		$("#total_lembur").val("<?=rp($total_lembur);?>"); 		
		$("#tot_makan").val("<?=rp($total_uang_makan);?>"); 	
		$("#tot_transport").val("<?=rp($total_transport);?>"); 	
		$("#tun_jabatan").val("<?=rp($tun_jab);?>"); 	
		$("#pot_asuransi").val("<?=rp($asuransi);?>"); 	
		$("#pot_absen").val("<?=rp($total_potongan);?>"); 	
		$("#gaji_bersih").val("<?=rp(($total_gaji_bersih));?>"); 	
		$("#jmlhari").val("<?=$jmlhari;?>"); 	
		$("#jmlharicuti").val("<?=$cuti;?>"); 	
		$("#tun_cuti").val("<?=rp($cuti * $gaji_pokok_perhari);?>"); 	
		$("#jmlharilibur").val("<?=$libur;?>"); 	
		$("#gajiditerima").val("<?=rp(($total_gaji_diterima));?>"); 			
		$("#tun_libur").val("<?=rp(($tun_libur));?>"); 			
		$("#bonus").val("<?=rp($bonus);?>"); 
		$("#uang_makan_diambil").val("<?=rp($uang_makan);?>"); 
		$("#uang_transport_diambil").val("<?=rp($uang_transport);?>"); 
		// $(".klip").addClass("blink");		
	});
	
	
	// function  hitung() {
	// var vgaji_bersih = angka(document.getElementById("gaji_bersih").value);
	// var vkasbon = angka(document.getElementById("kasbon").value);
	// var sisa = parseInt(vgaji_bersih) - parseInt(vkasbon) ; 
	// console.log(vgaji_bersih)
	// console.log(sisa)
	// document.getElementById("gajiditerima").value = formatMoney(sisa);
	
	// }
	function formatMoney(number, places, symbol, thousand, decimal) {
		number = number || 0;
		places = !isNaN(places = Math.abs(places)) ? places : 0;
		symbol = symbol !== undefined ? symbol : "";
		thousand = thousand || ".";
		decimal = decimal || ",";
		var negative = number < 0 ? "-" : "",
		i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
		j = (j = i.length) > 3 ? j % 3 : 0;
		return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
	}
	
	function formatNumber(myElement) { // JavaScript function to insert thousand separators
		var myVal = ""; // The number part
		
		var parts = myElement.value.toString().split("|");
		
		parts[0] = parts[0].replace(/[^0-9]/g,""); 
		// Adding the thousand separator
		while ( parts[0].length > 3 ) {
			myVal = "."+parts[0].substr(parts[0].length-3, parts[0].length )+myVal;
			parts[0] = parts[0].substr(0, parts[0].length-3)
		}
		myElement.value = parts[0]+myVal;
		
	}
	
	function angka(number) {
		var str = number;
		var re = str.replace("Rp.","");
		var res = replaceAll(".","",re); 
		return res;
	}
	
	function replaceAll(find, replace, str) {
		while( str.indexOf(find) > -1)      {
		str = str.replace(find, replace); }
		return str;    
	}
	
	var xmlhttp = false;
	
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
			xmlhttp = false;
		}
	}
	
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	
	
	function cetak_slip(){
		var user = document.getElementById("user").value;
		var bln = document.getElementById("bln").value;
		var thn = document.getElementById("thn").value;
		var tglakhir = document.getElementById("tglakhir").value;
		// var url='views/absensi/cetak_slip.php?iduser='+user+'&bln='+bln+'&thn='+thn+'&tglakhir='+tglakhir;
		var urlpprint=base_url+'absen/cetak_slip/?iduser='+user+'&bln='+bln+'&thn='+thn+'&tglakhir='+tglakhir;
		console.log(urlpprint);
		window.open(urlpprint);
		
	}
	</script>																					