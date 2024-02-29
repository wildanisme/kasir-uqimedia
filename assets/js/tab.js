$(document).ready(function() {
	
    $(".tabs").click(function() {
        $(".tabs").removeClass("active");
        $(".tabs h6").removeClass("font-weight-bold");
        $(".tabs h6").addClass("text-muted");
        $(this).children("h6").removeClass("text-muted");
        $(this).children("h6").addClass("font-weight-bold");
        $(this).addClass("active");
        current_fs = $(".active");
        next_fs = $(this).attr("id");
		
        $("#hasil_cari").hide();
        $("#hasil_cari_order").hide();
        $("#hasil_cari_desain").hide();
        $("#detail_cetak").hide();
        /** @type {string} */
        next_fs = "#" + next_fs + "1";
        $("fieldset").removeClass("show");
        $(next_fs).addClass("show");
        current_fs.animate({}, {
            step : function() {
                current_fs.css({
                    "display" : "none",
                    "position" : "relative"
				});
                next_fs.css({
                    "display" : "block"
				});
			}
		});
        $("#tab01_").addClass("display-none");
        current_fs1 = $(".display-block");
        next_fs1 = $(this).attr("id");
        
        /** @type {string} */
        
        next_fs1 = "#" + next_fs1 + "_";
        $(current_fs1).addClass("display-none");
        
        $("#hasil_cari").hide();
        $(next_fs1).removeClass("display-none").addClass("display-block");
        
        let keyword_cari = $('#keyword_cari').val();
        let cari_order = $('#cari_order').val();
        let cari_desain = $('#cari_desain').val();
        
		console.log(next_fs1);
        //tab 1
        if(next_fs1 == '#tab01_')
        {
			$(".cari_invoice").prop("disabled", this.value == "" ? true : false);
            if(cari_order !='')
            {
                $('#keyword_cari').val($('#cari_order').val());
                $('#cari_desain, #cari_order').val('')
			}
            
            if(cari_desain !='')
            {
                $('#keyword_cari').val($('#cari_desain').val());
                $('#cari_desain, #cari_order').val('')
			}
            
            $('#keyword_cari').focus();
			
		}
        
        //tab 2
        if(next_fs1 == '#tab02_')
        {
            
            $(".cari_order").prop("disabled", this.value == "" ? true : false);
            if(keyword_cari !='')
            {
                $('#cari_order').val(keyword_cari);
                $('#keyword_cari, #cari_desain').val('')
                
			}
            
            if(cari_desain !='')
            {
				
                $('#cari_order').val(cari_desain);
                $('#keyword_cari, #cari_desain').val('')
			}
            
            $('#cari_order').focus();
			
		}  
        
        //tab 3
        if(next_fs1 == '#tab03_')
        {
			$(".cari_desain,.updateDesain,.cek_folder,.buka_folder,.cbtn").prop("disabled", this.value == "" ? true : false);
            if(keyword_cari !='')
            {
				
                $('#cari_desain').val(keyword_cari);
                $('#keyword_cari, #cari_order').val('')
			}
            
            if(cari_order !='')
            {
                $('#cari_desain').val(cari_order);
                $('#keyword_cari, #cari_order').val('')
			}
            
            $('#cari_desain').focus();
		}
        
	});
});