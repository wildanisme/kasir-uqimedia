<table class="table table-striped table-hover">
    <thead>
        <?php if(!empty($user)){ ?>
            <tr class="bg-success text-white">
                <th style="width:2%">No.</th>
                <th style="width:2%">No.Order</th>
                <th style="width:5%">Tgl.Order</th>
                <th style="width:5%">Konsumen</th>
                <th style="width:5%">Tgl.Bayar</th>
                <th style="width:5%">Keterangan</th>
                <th style="width:5%">Lampiran</th>
                <th style="width:5%" class="text-right">Jml. Bayar</th>
			</tr>
            <?php }else{ ?>
            <tr class="bg-success text-white">
                <th style="width:1%">No.</th>
                <th style="width:10%">FO</th>
                <th style="width:5%" class="text-right">Tunai</th>
                <th style="width:5%" class="text-right">Transfer</th>
                <th style="width:5%" class="text-right">Total</th>
			</tr>
		<?php } ?>
	</thead>
    <tbody>
        <?php 
            if(!empty($user)){
                $no=1;  
                $tunai = $transfer = $debit = $total = $grandtotal = $grand_total = 0;
                $total_tunai = 0;
                $id_bayar = 0;
				if(!empty($invoice)){
					foreach($invoice AS $rowcara){
						$totsetor = 0;
						$databayar = detail_bayar($rowcara['id'],$dari,$sampai,$user,$setor);
						$a = 0;
						foreach($databayar AS $row){
							$a++;
							$lampiran ='-';
							if($row['id_bayar']==1){
								$total_tunai += $row['jml_bayar'];
								$id_bayar = $row['id_bayar'];
							}
							if($row['id_bayar']==2){
								$lampiran ='<a class="lightbox" href="'.base_url('uploads/lampiran/').$row['lampiran'].'">View</a>';
							}
							$id_invoice[] = $row['id_invoice'];
							$id_transaksi = $row['id_transaksi'];
							
						?>
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $id_transaksi;?></td>
							<td><?php echo dtimes($row['tgl_trx'],false,false);?></td>
							<td><?php echo $row['nama'];?></td>
							<td><?php echo dtimes($row['tgl_bayar'],false,false);?></td>
							<td><?php echo $row['nama_bayar'];?></td>
							<td><?php echo $lampiran;?></td>
							<td class="text-right"><?php echo rp($row['jml_bayar']);?></td>
						</tr>
						<?php 
							$totsetor = $totsetor + $row['jml_bayar'];
							$no++;
						}
						
					?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><i><strong><?=$rowcara['nama_bayar'];?></i></strong></td>
						<td>&nbsp;</td>
						<td class="text-right"><i><strong><?= rp($totsetor);?></i></strong></td>
					</tr>
					
					<?php
						$grandtotal = $grandtotal + $totsetor;
					} 
					$invoice_setor = '';
					if(!empty($id_invoice)){
						$invoice_setor = implode(",",$id_invoice);
					}
					 
				?>
				<tr>
					<td colspan="2">
						<?php if($setor=='N' AND $id_bayar==1 AND $user==$this->session->idu){ ?>
							<button class="btn btn-success btn-sm setor" id="setor_u_masuk"><i class="fa fa-send"></i> Setor</button>
							<input type="hidden" name="total_u" id="total_u" value="<?=$total_tunai;?>">
							<input type="hidden" name="invoice_setor" id="invoice_setor" value="<?=$invoice_setor;?>">
						<button class="btn btn-info btn-sm" id="cetak_u_masuk"><i class="fa fa-file-pdf-o"></i> Print</button></td>
					</td>
					<?php }else{ ?>
				<button class="btn btn-info btn-sm" id="cetak_u_masuk"><i class="fa fa-file-pdf-o"></i> Print</button></td>
			<?php } ?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><strong>Grand Total</strong></td>
			<td>&nbsp;</td>
			<td class="text-right"><i><strong><?= rp($grandtotal);?></i></strong></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td colspan="8">
				BELUM ADA DATA
			</td>
		</tr>
	<?php } ?>
	<tr>
		<td colspan="8">
			Note : uang yang di setorkan hanya penerimaan tunai
		</td>
	</tr>
	<div class="lightbox"></div>
	<script>
		var lampiran = '<?=$lampiran;?>';
		if(lampiran !=''){
			var lightboxDescription = GLightbox({
				selector: '.lightbox',
				loop: true,
			});
		}
	</script>
	<?php 
		}else{
		$no=1;  
		$tunai = 0;
		$transfer = 0;
		$debit = 0;
		$total = 0;
		$grandtotal = 0;
		if(!empty($carabayar)){
			foreach($carabayar AS $row){
				$total = $row['tunai'] + $row['transfer'];
			?>
			
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $row['nama_lengkap'];?></td>
				<td class="text-right"><?php echo rp($row['tunai']);?></td>
				<td class="text-right"><?php echo rp($row['transfer']);?></td>
				<td class="text-right"><?php echo rp($total);?></td>
			</tr>
			<?php
				$tunai += $row['tunai'];
				$transfer += $row['transfer'];
				$grandtotal += $total;
				$no++;
			}
		?>    
		<tr>
		<td><button class="btn btn-info btn-sm" id="cetak_u_masuk"><i class="fa fa-file-pdf-o"></i> Print</button></td></td>
		<td ><strong>Total</strong></td>
		<td class="text-right"><i><strong><?= rp($tunai);?></i></strong></td>
		<td class="text-right"><i><strong><?= rp($transfer);?></i></strong></td>
		<td class="text-right"><i><strong><?= rp($grandtotal);?></i></strong></td>
	</tr>
	<?php }
}?>    
</tbody>
</table>

<script>
    
    $(".edit_order").click(function(event) {
        event.preventDefault();
        var id = $(this).data("id");
        var mod = $(this).data("modedit");
        $("#id_tab").val($(this).data("tab"));
        // console.log(tab);return;
        $.ajax({
            type : "POST",
            url : base_url               + "order/cek_akses",
            data : {id : id,mod : mod},
            dataType : "json",
            beforeSend : function() {
                $('body').loading();
			},
            success : handleCart,
            error : function(res, status, httpMessage) {
                swal("Error!", httpMessage)
                // sweet("Peringatan!!!", httpMessage, "warning", "warning");
                $('body').loading('stop');
			}
		});
	});
    var handleCart = function(result) {
        // console.log(result);
        $('body').loading('stop');
        if (result.status == 200) {
            $("#OpenCart").modal("show");
            var id = result.id;
            // console.log(id);
            var permissions = result.mod;
            $("#print").attr("data-id", id);
            $("#bayarin").attr("data-id", id);
            $("#print_pdf").attr("data-id", id);
            $("#batal_order").attr("data-id", id);
            $("#batal_order").attr("data-modEdit", "batal");
            if (permissions == "view" && result.total_order == result.total_bayar && result.total_order > 0) {
                $("#print").hide();
                $("#bayarin").hide();
                $("#pending").hide();
                $("#batal_order").show();
                $("#print_pdf").show();
                } else {
                $("#print").show();
                $("#bayarin").show();
                $("#pending").show();
                $("#batal_order").hide();
                $("#print_pdf").hide();
			}
            $.ajax({
                type : "POST",
                url : base_url           + "order/cart",
                data : {
                    id : id,
                    edit : permissions
				},
                cache : false,
                beforeSend : function() {
				},
                success : function(htmlExercise) {
                    $.getScript(base_url + "assets/js/app.js");
                    $(".load-data").html(htmlExercise);
				},
                error : function(res, status, httpMessage) {
                    swal("Here's a message!", httpMessage)
                    $('body').loading('stop');
				}
			});
            } else {
            // console.log(2);
            Swal.fire({
                title : result.msg,
                icon : "warning",
                showDenyButton : false,
                showCancelButton : false,
                confirmButtonText : "OK",
                denyButtonText : `Don't save`
                }).then((tx) => {
                if (tx.isConfirmed) {
                    $("#OpenTrx").modal("hide");
                    $("#OpenCart").modal("hide");
                    $('body').loading('stop');
                    } else {
                    if (tx.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                        $('body').loading('stop');
					}
				}
			});
		}
	}
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
	}
    $('.cetak').on('click', function (e) {
        e.preventDefault(); 
        var id = $(this).attr('data-id');
        var url = base_url               +"cetak/invoice/"+id+"/?type=1&token=0";
        window.open(url);
	})
	</script>                				