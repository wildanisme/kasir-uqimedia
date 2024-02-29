<?php 
	
	
	function _storage()
    {
        return base_url("uploads/whatsapp/");
	}	
	
	function uploadimg($par = [])
    {
        $ci = &get_instance();
        $config['upload_path'] = $par['path'];
        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $ci->load->library('upload', $config);
        $ci->upload->initialize($config);
        
        if (!empty($_FILES["$par[name]"]['name'])) {
            if ($ci->upload->do_upload("$par[name]")) {
                $img = $ci->upload->data();
                if ($par['compress'] == true) {
                    //Compress Image
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = "$par[path]" . $img['file_name'];
                    $config['create_thumb'] = FALSE;
                    $config['maintain_ratio'] = FALSE;
                    $config['quality'] = FALSE;
                    $config['width'] = $par['width'];
                    $config['height'] = $par['height'];
                    $config['new_image'] = "$par[path]" . $img['file_name'];
                    $ci->load->library('image_lib', $config);
                    $ci->image_lib->resize();
				}
                
                $image = $img['file_name'];
                return array('result' => 'success', 'nama_file' => $image, 'error' => '');
                } else {
                return array('result' => 'error', 'file' => '', 'error' => $ci->upload->display_errors());
			}
            } else {
            return array('result' => 'noimg');
		}
	}
    function _assets($url = '')
    {
        if ($url) {
            return base_url("assets/$url");
            } else {
            return base_url("assets");
		}
	}
    
    function _alert()
    {
        $ci = &get_instance();
        if ($ci->session->flashdata('success')) {
            return '<div class="alert alert-success alert-style-light" role="alert">' . $ci->session->flashdata('success') . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>';
            } else if ($ci->session->flashdata('warning')) {
            return '<div class="alert alert-warning alert-style-light" role="alert">' . $ci->session->flashdata('warning') . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>';
            } else if ($ci->session->flashdata('error')) {
            return '<div class="alert alert-danger alert-style-light" role="alert">' . $ci->session->flashdata('error') . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button></div>';
		}
	}   
