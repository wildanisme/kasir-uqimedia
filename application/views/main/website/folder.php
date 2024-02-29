<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Network Shared Folder</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Network</li>
		</ol>
	</div>
    <?php
        echo $this->session->flashdata('message');
	?>
    <div class="row">
        <div class="col-md-12">
            <!-- Form Basic -->
            <div class="card mb-4">
                <form id="simpan_data" method="POST" action="<?=base_url();?>main/save_folder">
                    <div class="card-body">
                        <div class="card-header pl-0">
                            <h6 class="m-0 font-weight-bold text-primary ml-0 "><?=$title;?></h6>
						</div>
                        
                        <div class="form-group">
                            <label for="computer_name">Network Computer Name</label>
							<input type="text" class="form-control" id="computer_name" name="computer_name" value="<?=$rows['computer_name'];?>" required>
						</div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="folder_af">Shared Folder A-F</label>
                                <input type="text" class="form-control" id="folder_af" name="folder_af" value="<?=$rows['folder_af'];?>" readonly>
								<small id="folder_afHelp" class="form-text text-muted">Contoh : \\<?=$rows['computer_name'];?>\A-F\A\Andy - 08123456789</small>
							</div>
                            <div class="form-group col-md-6">
                                <label for="folder_gm">Shared Folder G-M</label>
                                <input type="text" class="form-control" id="folder_gm" name="folder_gm" value="<?=$rows['folder_gm'];?>" readonly>
                                <small id="folder_gmHelp" class="form-text text-muted">Contoh : \\<?=$rows['computer_name'];?>\G-M\L\Lala - 08133456789</small>
							</div>
						</div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="folder_ns">Shared Folder N-S</label>
                                <input type="text" class="form-control" id="folder_ns" name="folder_ns" value="<?=$rows['folder_ns'];?>" readonly>
                                <small id="folder_nsHelp" class="form-text text-muted">Contoh : \\<?=$rows['computer_name'];?>\N-S\S\Sandy - 085623456789</small>
							</div>
                            <div class="form-group col-md-6">
                                <label for="folder_tz">Shared Folder T-Z</label>
                                <input type="text" class="form-control" id="folder_tz" name="folder_tz" value="<?=$rows['folder_tz'];?>" readonly>
                                <small id="folder_tzHelp" class="form-text text-muted">Contoh : \\<?=$rows['computer_name'];?>\T-Z\T\Tedy - 08963456789</small>
							</div>
						</div>
						<div class="card-header pl-0">
                            <h6 class="m-0 font-weight-bold text-primary ml-0 ">Pengaturan penamaan file</h6>
						</div>
						<div class="row">
                            <div class="form-group col-md-6">
                                <label for="ukuran_folder">UKURAN</label>
                                <input type="text" class="form-control" id="ukuran_folder" name="ukuran_folder" value="<?=$rows['ukuran'];?>">
								<small class="form-text text-muted">TRX-00001-<span class="text-danger font-weight-bold"><?=$rows['ukuran'];?>.</span>2x1m-<?=$rows['qty'];?>.101-B.FLEXI CHINA 280Gr-<?=$rows['produk'];?>.SPANDUK-<?=$rows['tanggal'];?>.25.5.2023_15.3-<?=$rows['fo'];?>.Kasir</small>
							</div>
                            <div class="form-group col-md-6">
                                <label for="qty_folder">QTY</label>
                                <input type="text" class="form-control" id="qty_folder" name="qty_folder" value="<?=$rows['qty'];?>">
								<small class="form-text text-muted">TRX-00001-<?=$rows['ukuran'];?>.2x1m-<span class="text-danger font-weight-bold"><?=$rows['qty'];?>.</span>.101-B.FLEXI CHINA 280Gr-<?=$rows['produk'];?>.SPANDUK-<?=$rows['tanggal'];?>.25.5.2023_15.3-<?=$rows['fo'];?>.Kasir</small>
							</div>
						</div>
						<div class="row">
                            <div class="form-group col-md-6">
                                <label for="bahan_folder">BAHAN</label>
                                <input type="text" class="form-control" id="bahan_folder" name="bahan_folder" value="<?=$rows['bahan'];?>">
								<small class="form-text text-muted">TRX-00001-<?=$rows['ukuran'];?>.2x1m-<?=$rows['qty'];?>.101-<span class="text-danger font-weight-bold"><?=$rows['bahan'];?></span>.FLEXI CHINA 280Gr-<?=$rows['produk'];?>.SPANDUK-<?=$rows['tanggal'];?>.25.5.2023_15.3-<?=$rows['fo'];?>.Kasir</small>
							</div>
                            <div class="form-group col-md-6">
                                <label for="produk_folder">PRODUK</label>
                                <input type="text" class="form-control" id="produk_folder" name="produk_folder" value="<?=$rows['produk'];?>">
								<small class="form-text text-muted">TRX-00001-<?=$rows['ukuran'];?>.2x1m-<?=$rows['qty'];?>.101-B.FLEXI CHINA 280Gr-<span class="text-danger font-weight-bold"><?=$rows['produk'];?>.</span>SPANDUK-<?=$rows['tanggal'];?>.25.5.2023_15.3-<?=$rows['fo'];?>.Kasir</small>
							</div>
						</div>
						<div class="row">
                            <div class="form-group col-md-6">
                                <label for="tgl_folder">TANGGAL</label>
                                <input type="text" class="form-control" id="tgl_folder" name="tgl_folder" value="<?=$rows['tanggal'];?>">
								<small class="form-text text-muted">TRX-00001-<?=$rows['ukuran'];?>.2x1m-<?=$rows['qty'];?>.101-B.FLEXI CHINA 280Gr-<?=$rows['produk'];?>.SPANDUK-<span class="text-danger font-weight-bold"><?=$rows['tanggal'];?>.</span>25.5.2023_15.3-<?=$rows['fo'];?>.Kasir</small>
								
							</div>
							<div class="form-group col-md-6">
                                <label for="fo_folder">FO</label>
                                <input type="text" class="form-control" id="fo_folder" name="fo_folder" value="<?=$rows['fo'];?>">
								<small class="form-text text-muted">TRX-00001-<?=$rows['ukuran'];?>.2x1m-<?=$rows['qty'];?>.101-B.FLEXI CHINA 280Gr-<?=$rows['produk'];?>.SPANDUK-<?=$rows['tanggal'];?>.25.5.2023_15.3-<span class="text-danger font-weight-bold"><?=$rows['fo'];?>.</span>Kasir</small>
							</div>
						</div>
						<div class="input-group-append">
							<button type="submit" name="submit" class="btn btn-success" type="button">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
        <!--Row-->
	</div>
</div>

