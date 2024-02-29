<?php if($tools==1){ ?>
    <script type="module">
        
        import devtools from '<?=base_url(); ?>assets/vendor/devtools-detect/index.js';
        if(devtools.isOpen){
            window.location.href = base_url+ "404";
        }
        window.addEventListener('devtoolschange', event => {
            if(event.detail.isOpen){
                window.location.href = base_url+ "404";
            }
        });
        
    </script>
<?php } ?>
