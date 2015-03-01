<?php 
add_action( 'add_theme_support', 'woocommerce_variable_add_to_cart' );
add_action( 'add_theme_support', 'find_valid_variations' );
function woocommerce_variable_add_to_cart(){
    global $product, $post;
    $variations = find_valid_variations();
    // Check if the special 'price_grid' meta is set, if it is, load the default template:
    if ( get_post_meta($post->ID, 'price_grid', true) ) {
        // Enqueue variation scripts
        wp_enqueue_script( 'wc-add-to-cart-variation' );
        // Load the template
        wc_get_template( 'single-product/add-to-cart/variable.php', array(
            'available_variations'  => $product->get_available_variations(),
            'attributes'            => $product->get_variation_attributes(),
            'selected_attributes'   => $product->get_variation_default_attributes()
            ) );
        return;
    }
    // Cool, lets do our own template!
    ?>
    <table class="variations variations-grid" cellspacing="0">
        <tbody>
            <?php
            foreach ($variations as $key => $value) {
                if( !$value['variation_is_visible'] ) continue;
                ?>
                <tr>
                    <td>
                        <?php foreach($value['attributes'] as $key => $val ) {
                            $val = str_replace(array('-','_'), ' ', $val);
                            printf( '<span class="attr attr-%s">%s</span>', $key, ucwords($val) );
                        } ?>
                    </td>
                    <?php 
                    if ($value['price_html']) {
                        echo"<td>";
                        echo $value['price_html'];
                        echo"</td>";
                    }
                    ?>
                    <td>
                    
<?php if( $value['is_in_stock'] ) { ?>
<form class="cart" action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" method="post" enctype='multipart/form-data'>
    <?php woocommerce_quantity_input(); ?>
    <?php
    if(!empty($value['attributes'])){
        foreach ($value['attributes'] as $attr_key => $attr_value) {
            ?>
            <input type="hidden" name="<?php echo $attr_key?>" value="<?php echo $attr_value?>">
            <?php
        }
    }
    ?>
    <button type="submit" class="single_add_to_cart_button btn btn-primary"><span class="glyphicon glyphicon-tag"></span> Add to cart</button>
    <input type="hidden" name="variation_id" value="<?php echo $value['variation_id']?>" />
    <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $post->ID ); ?>" />
</form>
<?php } else { ?>
<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
<?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php
}
function find_valid_variations() {
    global $product;
    $variations = $product->get_available_variations();
    $attributes = $product->get_attributes();
    $new_variants = array();
    foreach( $variations as $variation ) {
         $valid = true;
         foreach( $attributes as $slug => $args ) {
            if( array_key_exists("attribute_$slug", $variation['attributes']) && !empty($variation['attributes']["attribute_$slug"]) ) {
            } else {
                $valid = false; 
                foreach( explode( '|', $attributes[$slug]['value']) as $attribute ) {
                    $attribute = trim( $attribute );
                    $new_variant = $variation;
                    $new_variant['attributes']["attribute_$slug"] = $attribute;
                    $new_variants[] = $new_variant;
                }
            }
        }
        if( $valid )
            $new_variants[] = $variation;
    }
    return $new_variants;
}
 ?>