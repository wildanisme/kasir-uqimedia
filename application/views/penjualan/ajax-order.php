<div class="table-responsive table-responsive">
	<table class="table table-sm table-striped table-hover text-nowrap">
		<thead>
			<tr>
				<th style="width:4% !important;">NO_ORDER</th>
				<th class="pl-0" style="width:14% !important;">TGL.ORDER</th>
				<th class="w-10">PELANGGAN</th>
				<th style="width:10% !important;">KASIR</th>
				<th class="text-right w-10">TOTAL</th>
				<th class="text-right w-160px">BAYAR</th>
				<th class="text-right w-10">DISKON</th>
				<th class="text-right w-10">PIUTANG</th>
				<th class="text-right w-3">STATUS | AKSI</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($posts)) {
				$no = 1;
				$totalorder = 0;
				$_totalbayar = 0;
				$totalbayar = 0;
				$totaldiskon = 0;
				$totalpajak = 0;
				$totalsisa = 0;
				$pajak = 0;
				foreach ($posts as $row) {
					$pdf = $print = $target = $pelunasan = $edit = $batal = $view = '';
					$lunas = '<button type="button" class="btn btn-secondary btn-sm flat" data-toggle="tooltip" data-original-title="ORDER BELUM DISIMPAN">BELUM</button>';
					$id_invoice = encrypt_url($row['id_invoice']);
					$url_pdf = base_url() . 'produk/print_invoice/' . $id_invoice;
					$url_print = base_url() . 'produk/print_invoice_html/' . $id_invoice;

					$sumOrderDiskon = sumOrderDiskon($row["id_invoice"]);

					$sumOrder = sumOrder($row['id_invoice']);

					$diskon = $row['potongan_harga'];
					$cashback = $row['cashback'];
					$sumPiutang = sumPiutang($row["id_invoice"]);
					$pajak = $row['pajak'];
					if ($pajak > 0) {
						$pajak = ($sumOrder * $pajak) / 100;
						$sumPiutang = $sumPiutang[0]['piutang'] - $pajak;
						$popper = '<a tabindex="0" class="btn btn-primary btn-sm flat" role="button" data-toggle="popover" data-trigger="focus" title="" data-content="' . rp($pajak) . '" data-original-title="Pajak ' . $row['pajak'] . '%">' . rp($sumPiutang) . '</a>';
					} else {
						$sumPiutang = $sumPiutang[0]['piutang'];
						$popper = rp($sumPiutang);
					}

					$sisa = $sumOrder - $sumPiutang - $diskon;
					echo "<script>
				var url_print =  '$url_print';
				</script>";
					if ($row["oto"] == 0) {
						$status = 'BUKA';
						$view = 'edit';
					} elseif ($row["oto"] == 1) {
						$status = 'EDIT ORDER';
						$view = 'edit';
					} elseif ($row["oto"] == 2) {
						$status = 'HAPUS PEMBAYARAN';
						$view = 'view';
					} elseif ($row["oto"] == 3) {
						$status = 'EDIT ORDER LUNAS';
						$view = 'edit';
					} elseif ($row["oto"] == 4) {
						$status = 'PENDING';
						$view = 'view';
					} elseif ($row["oto"] == 5) {
						$status = 'BATAL';
						$view = 'batal';
					} else {
						$status = 'KUNCI';
						$view = 'view';
					}
					if ($row["cetak"] > 0) {
						$cetak = 'YA';
					} else {
						$cetak = 'BELUM';
					}

					if ($row["tampil"] == 0) {
						$nama = nama_depan($row["nama"]);
						$nama_popup = ($row["nama"]);
					} else {
						$nama = nama_depan($row["perusahaan"]);
						$nama_popup = ($row["perusahaan"]);
					}

					if ($row["status"] == 'baru') {
						$status = '<button type="button" class="btn btn-outline-primary btn-sm flat" data-toggle="tooltip" data-original-title="ORDER BARU">BARU</button>';
					} else if ($row["status"] == 'simpan') {
						$status = '<button type="button" class="btn btn-outline-success btn-sm flat" data-toggle="tooltip" data-original-title="ORDER SAVED">SIMPAN</button>';
					} else if ($row["status"] == 'edit') {
						$status = '<button type="button" class="btn btn-outline-info btn-sm flat" data-toggle="tooltip" data-original-title="ORDER DI EDIT">EDIT ORDER</button>';
					} else if ($row["status"] == 'pending') {
						$status = '<button type="button" class="btn btn-outline-warning btn-sm flat" data-toggle="tooltip" data-original-title="ORDER PENDING">PENDING</button>';
						$edit = '<a href="#" class="dropdown-item cek_order"  data-id="' . $row["id_invoice"] . '" data-modEdit="' . $view . '"  id="cart"><span class="badge badge-info flat">EDIT ORDER</span></a>';
					} else if ($row["status"] == 'batal') {

						$status = '<button type="button" data-modEdit="hapus" data-id="' . $id_invoice . '" data-trx="' . $row["id_transaksi"] . '"  class="btn btn-outline-danger btn-sm flat hapus_invoice" data-toggle="tooltip" data-original-title="HAPUS ORDER BATAL">HAPUS</button>';
					}
					if ($row["lunas"] == 1 and $row["status"] != 'simpan') {
						$lunas = '<button type="button" class="btn btn-success btn-sm flat" data-toggle="tooltip" data-original-title="ORDER LUNAS">LUNAS</button>';
						$pdf = '<a class="dropdown-item" href="' . $url_pdf . '" target="_blank"><span class="badge badge-success flat"><i class="fa fa-file-pdf-o"></i> PRINT PDF</span></a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("' . $id_invoice . '") ><span class="badge badge-primary flat"><i class="fa fa-print"></i> PRINT ORDER</span></a>';
						$target = '_blank';
						$pelunasan = '';
					} elseif ($row["lunas"] == 1 and $row["status"] == 'simpan') {
						$lunas = '<button type="button" class="btn btn-success btn-sm flat">LUNAS</button>';
						$pdf = '<a class="dropdown-item" href="' . $url_pdf . '" target="_blank"><span class="badge badge-success flat"><i class="fa fa-file-pdf-o"></i> PRINT PDF</span></a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("' . $id_invoice . '"); ><span class="badge badge-primary flat"><i class="fa fa-print"></i> PRINT ORDER</span></a>';
					}
					if ($row["status"] == 'baru' and $row["id_konsumen"] == 1) {
						$print = '';
						$edit = '<a href="#" class="dropdown-item cek_order"  data-id="' . $row["id_invoice"] . '" data-modEdit="' . $view . '"  id="cart"><span class="badge badge-info flat">EDIT ORDER</span></a>';
						$pelunasan = '';
						$batal = '<a class="dropdown-item pending_order" data-modEdit="pending" data-id="' . $row["id_invoice"] . '" href="#"><span class="badge badge-warning flat">PENDING</span></a>';
					}
					if ($row["status"] == 'baru' and $row["id_konsumen"] != 1) {
						$print = '';
						$edit = '<a href="#" class="dropdown-item cek_order"  data-id="' . $row["id_invoice"] . '" data-modEdit="edit" id="cart"><span class="badge badge-info flat">EDIT ORDER</span></a>';
						$pelunasan = '';
						$batal = '<a class="dropdown-item pending_order" data-modEdit="pending" data-id="' . $row["id_invoice"] . '" href="#"><span class="badge badge-warning flat">PENDING</span></a>';
					}
					if ($row["status"] == 'simpan' and $row["lunas"] == 0) {
						$pdf = '<a class="dropdown-item" href="' . $url_pdf . '" target="_blank"><span class="badge badge-success flat"><i class="fa fa-file-pdf-o"></i> PRINT PDF</span></a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("' . $id_invoice . '") ><span class="badge badge-primary flat"><i class="fa fa-print"></i> PRINT ORDER</span></a>';
						if ($this->session->level == 'admin') {
							$edit = '<a href="#" class="dropdown-item cek_order" data-id="' . $row["id_invoice"] . '" data-modEdit="' . $view . '"  id="cart"><span class="badge badge-info flat">EDIT ORDER</span></a>';
							$batal = '<a class="dropdown-item batal_order" data-modEdit="batal" data-id="' . $row["id_invoice"] . '" href="#"><span class="badge badge-danger flat"><i class="fa fa-times"></i>  BATAL ORDER</span></a>';
						}
						$pelunasan = '<a class="dropdown-item bayar_sisa" data-modEdit="bayar" data-id="' . $id_invoice . '" data-trx="' . $row["id_transaksi"] . '"  data-bayar="' . $sumPiutang . '" data-sisa="' . $sisa . '" data-total="' . $sumOrder . '" data-status="' . $row["status"] . '" href="#"><span class="badge badge-success flat">Pelunasan</span></a>';
					}
					if ($row["status"] == 'simpan' and $row["lunas"] == 1) {
						$pdf = '<a class="dropdown-item" href="' . $url_pdf . '" target="_blank"><span class="badge badge-success flat"><i class="fa fa-file-pdf-o"></i> PRINT PDF</span></a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("' . $id_invoice . '") ><span class="badge badge-primary flat"><i class="fa fa-print"></i> PRINT ORDER</span></a>';
						if ($this->session->level == 'admin') {
							$edit = '';
							$batal = '<a class="dropdown-item batal_order" data-modEdit="batal" data-id="' . $row["id_invoice"] . '" href="#"><span class="badge badge-danger flat"><i class="fa fa-times"></i> BATAL ORDER</span></a>';
						}
						$pelunasan = '';
					}
					if ($row["status"] == 'simpan' and $sisa == 0) {
						$lunas = '<button type="button" class="btn btn-success btn-sm flat" data-toggle="tooltip" data-original-title="ORDER LUNAS">LUNAS</button>';
						$pdf = '<a class="dropdown-item" href="' . $url_pdf . '" target="_blank"><span class="badge badge-success flat"><i class="fa fa-file-pdf-o"></i> PRINT PDF</span></a>';
						$print = '<a class="dropdown-item" href=javascript:open_popup("' . $id_invoice . '") ><span class="badge badge-primary flat"><i class="fa fa-print"></i> PRINT ORDER</span></a>';
						if ($this->session->level == 'admin') {
							$edit = '';
							$batal = '<a class="dropdown-item batal_order" data-modEdit="batal" data-id="' . $row["id_invoice"] . '" href="#"><span class="badge badge-danger flat"><i class="fa fa-times"></i> BATAL ORDER</span></a>';
						}
						$pelunasan = '';
					}


					if (($row["status"] == 'baru' and $row["id_konsumen"] != 1) or ($sumOrder - $diskon != $sumPiutang and $row["id_konsumen"] != 1)) {

						$lunas = '<button data-toggle="tooltip" data-original-title="BAYAR PIUTANG" class="btn btn-info btn-sm flat bayar_sisa" data-modEdit="bayar" data-id="' . $id_invoice . '" data-trx="' . $row["id_transaksi"] . '"  data-bayar="' . $sumPiutang . '" data-sisa="' . $sisa . '" data-total="' . $sumOrder . '" data-status="' . $row["status"] . '"  href="javascript:void(0)">BAYAR</button>';
					}

					if ($row["status"] == 'batal') {
						$lunas = '<button type="button" class="btn btn-danger btn-sm flat">BATAL</button>';
					}
					$button = $pdf . $print . $edit . $pelunasan . $batal;
					$totalorder += sumOrder($row['id_invoice']) - $sumOrderDiskon->sisa;
					$totalbayar += $sumPiutang;
					$totaldiskon += $diskon;
					$totalpajak += $pajak;
					$totalsisa += $sisa;
			?>
					<tr>
						<td>
							<div class="btn-group btn-group-sm flat" role="group" aria-label="Basic example">
								<button class="btn btn-info btn-sm flat cek_order" data-id="<?= $row["id_invoice"]; ?>" data-modEdit="<?= $view; ?>"><?= $row["id_transaksi"]; ?></button>
								<button type="button" class="btn btn-secondary btn-sm flat cari_data" data-id="<?= $row["id_transaksi"]; ?>"><i class="fa fa-search"></i></button>
							</div>
						</td>
						<td class="pl-0"><?php echo date_short($row["tgl_trx"]); ?></td>
						<td>
							<?php if ($row["status"] == 'simpan' and $row["id_konsumen"] != 1) {

							?>
								<a data-toggle="tooltip" data-original-title="Kirim Ke <?= $nama_popup . ' : ' . phone_number($row["no_hp"]); ?>" data-placement="left" class="text-success kirim_wa" data-id="<?= $id_invoice; ?>" data-nomor="<?= ($row["no_hp"]); ?>" data-trx="<?= ($row["id_transaksi"]); ?>" data-tgl="<?= $row["tgl_trx"]; ?>" href="javascript:void(0)"><i class="fa fa-whatsapp"></i> &nbsp;<?= $nama_popup; ?></a>
							<?php } else { ?>
								<a class="text-secondary" href="#"><i class="fa fa-whatsapp"></i> &nbsp;<?= $nama; ?></a>
							<?php } ?>
						</td>
						<td><?= nama_depan($row["nama_lengkap"]); ?></td>
						<td align='right'><?php echo rp($sumOrder); ?></td>
						<td class="text-right"><?= $popper; ?></td>
						<td align='right'><?= rp($diskon); ?></td>
						<td align='right'><?php echo rp($sisa); ?></td>

						<td class="text-right">
							<div class="btn-group btn-group-sm dropleft flat">
								<?= $status . $lunas; ?>
								<button type="button" class="btn btn-danger btn-sm dropdown-toggle flat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									AKSI
								</button>
								<div class="dropdown-menu flat">
									<a class="dropdown-item" href="#">NO. #<?php echo $row["id_transaksi"]; ?></a>
									<div class="dropdown-divider"></div>
									<?= $button; ?>
								</div>
							</div>
						</td>
					</tr>
				<?php $no++;
				}
				if ($totalorder > 9000000) {
					$totalorder = number_format_short($totalorder);
				} else {
					$totalorder = rp($totalorder);
				}
				if ($totalbayar > 9000000) {
					$_totalbayar = $totalbayar + $totalpajak;
					$totalbayar = number_format_short($totalbayar);
				} else {
					$_totalbayar = $totalbayar + $totalpajak;
					$totalbayar = rp($totalbayar);
				}
				if ($totalsisa > 9000000) {
					$totalsisa = number_format_short($totalsisa);
				} else {
					$totalsisa = rp($totalsisa);
				}
				if ($totalpajak > 0) {
					$_popper = '<a tabindex="0" data-placement="top" class="btn btn-primary btn-sm flat" role="button" data-toggle="popover" data-trigger="focus" title="" data-content="' . $totalbayar . ' + ' . rp($totalpajak) . ' = ' . rp($_totalbayar) . ' " data-original-title="Total Bayar + Total Pajak">' . $totalbayar . '</a>';
				} else {
					$_popper = $totalbayar;
				}
				?>
		<tfoot>
			<tr>
				<th style="width:6% !important;">NOMOR_ORDER</th>
				<th class="pl-0" style="width:14% !important;">TGL.ORDER</th>
				<th class="w-10">PELANGGAN</th>
				<th style="width:10% !important;">KASIR</th>
				<th class="text-right w-10">TOTAL</th>
				<th class="text-right w-160px">BAYAR</th>
				<th class="text-right w-10">DISKON</th>
				<th class="text-right w-10">PIUTANG</th>
				<th class="text-right w-3">STATUS | AKSI</th>
			</tr>
			<tr>
				<td class="font-weight-bold" colspan="4">TOTAL PER PAGE</td>
				<td class="text-right font-weight-bold w-10"><?= ($totalorder); ?></td>
				<td class="text-right"><?= $_popper; ?></td>
				<td class="text-right font-weight-bold w-10"><?= rp($totaldiskon); ?></td>
				<td class="text-right font-weight-bold w-10"><?= ($totalsisa); ?></td>
				<td class="text-right w-10"></td>
			</tr>
		</tfoot>
	<?php } else { ?>
		<tr>
			<td colspan="9">BELUM ADA PENJUALAN <?= $tanggal; ?></td>
		</tr>
	<?php } ?>
	</tbody>

	</table>
	<nav aria-label="Page navigation example" class="p-2">
		<?php echo $this->ajax_pagination->create_links(); ?>
	</nav>
</div><!-- /.card-body -->
<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
		$('[data-toggle="popover"]').popover()
	})

	$(".hapus_invoice").click(function(e) {
		var id = $(this).attr('data-id');
		var idtrx = $(this).attr('data-trx');
		$('#data-hapus-order').val(id);
		$('#data-hapus-trx').html(idtrx);
		$('#delete-order').modal('show');
	});

	$(".kirim_wa").click(function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var nomor = $(this).attr('data-nomor');
		var trx = $(this).attr('data-trx');
		var tgl = $(this).attr('data-tgl');

		$('#WaLabel').html('Kirim ' + trx);
		$('#OpenModalWa').modal({
			backdrop: 'static',
			keyboard: false
		})
		$.ajax({
			url: base_url + 'whatsapp/get_form_wa',
			data: {
				id: id,
				nomor: nomor,
				tgl: tgl
			},
			method: 'POST',
			dataType: 'html',
			beforeSend: function() {
				$('body').loading();
			},
			success: function(data) {
				$(".load-data-wa").html(data);
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText;
				sweet('Server!!!', err, 'error', 'danger');
				$('body').loading('stop');
			}
		});
	});

	$('.cek_order').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		var id = $(this).data("id") // will return the number 123
		var mod = $(this).data('modedit');

		$.ajax({
			type: 'POST',
			url: base_url + "main/cek_akses",
			data: {
				id: id,
				mod: mod
			},
			dataType: "json",
			beforeSend: function() {
				$('body').loading();
			},
			success: handle_Cart,
			error: function(xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!', thrownError, 'warning', 'warning');
			}
		});
	});

	$('.cari_data').click(function() {
		$('#myModalTab').modal('show');
		var id = $(this).data("id")
		$('#tab01').click();
		$('#cari_invoice').attr('disabled', false);
		$('#keyword_cari').val(id)
		$('#cari_invoice').click();
	})
</script>