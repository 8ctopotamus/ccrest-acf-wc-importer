<?php

// routes
add_action( 'admin_post_nopriv_ccrest_importer', 'ccrest_importer' );
add_action( 'admin_post_ccrest_importer', 'ccrest_importer' );
function ccrest_importer() {
  include( plugin_dir_path( __DIR__ ) . 'inc/router.php' );
}

// Admin Toolbar buttons
add_action('admin_bar_menu', 'add_ccrest_item', 100);
function add_ccrest_item( $admin_bar ){
  global $pagenow;
	$admin_bar->add_menu( array( 'id' => 'ccrest-import', 'title' => 'Import Cedarcrest Data', 'href' => '#' ) );
}

// Admin Toolbar buttons events
add_action( 'admin_footer', 'ccrest_custom_toolbar_actions' );
function ccrest_custom_toolbar_actions() { ?>
  <script type="text/javascript">
		jQuery("li#wp-admin-bar-ccrest-import .ab-item").on('click', function() {
			const confirmation = confirm('You are about to overwrite all CedarCrest Woocommerce data.');
			$btn = jQuery(this);
      $btn.text('Importing... please be patient 😁')
			jQuery.post(
				'<?php echo esc_url( admin_url('admin-post.php') ); ?>',
				{ 
					action: 'ccrest_importer',
					do: 'upload_cedarcrest_data',
				},
				function(response) {
					const res = JSON.parse(response)
					console.log(res)
					if (res.success === true) {
            $btn.text('Cedarcrest data imported 👍')
					} else {
            $btn.text('Import Cedarcrest Data')
						console.error(res)
						alert('Plow import failed :(')
					}
				},
			);
		});
  </script>
<?php }