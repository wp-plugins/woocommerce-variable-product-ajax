<?php
/*
Plugin Name: Woocommerce Variable Product Ajax  
Plugin URI:http://webdesignjc.com/
Description: Add to cart functionality Ajax in Woocommerce for Variable Product
Author: Julio Cesar Llavilla CCama
Version: 1.00
Author URI:http://webdesignjc.com/
*/ 
add_action('wp_head','jc_wo_addImages');
add_action('admin_enqueue_scripts','jc_wo_addImages');
add_action( 'wp_enqueue_scripts', 'jc_variation_grid' );
add_action( 'wp_enqueue_scripts', 'jc_overlay' );
//add_action('wp_head','imagesvariation');
function jc_variation_grid() {     
	wp_enqueue_script( 'jcvariation', plugins_url( '/js/jc_variation.js', __FILE__ ),array( 'jquery' ) );
	wp_enqueue_script( 'jcspinner', plugins_url( '/js/jquery.fs.stepper.min.js', __FILE__ ),array( 'jquery' ) );
	wp_enqueue_style('stylevariation', plugins_url( '/css/jc_variation.css', __FILE__ ));
}
function jc_overlay() {     
	wp_enqueue_script( 'jcoverlay', plugins_url( '/js/overlay.js', __FILE__ ),array( 'jquery' ) );
	wp_enqueue_style('styleoverlay', plugins_url( '/css/jc_overlay.css', __FILE__ ));
}
?>
<?php 
require_once dirname(__FILE__).'/inc/grid.php'; 
/*
function imagesvariation(){
	echo '<script type="text/javascript"> var jc_loading ="'.plugins_url( "/img/loading.gif", __FILE__ ).'";	var jc_close ="'.plugins_url( "/img/close.png", __FILE__ ).'"; 	var jc_success ="'.plugins_url( "/img/success.png", __FILE__ ).'";</script>'; 
}
*/
function jc_wo_addImages(){ ?>
<input id = "jc_loading" type="hidden" value="<?php echo plugins_url( '/img/loading.gif', __FILE__ ); ?>">
<input id = "jc_success" type="hidden" value="<?php echo plugins_url( '/img/success.png', __FILE__ ); ?>">
<input id = "jc_close" type="hidden" value="<?php echo plugins_url( '/img/close.png', __FILE__ ); ?>">
<?php }
