<?php
/*
Plugin Name: WPKeyMe
Plugin URI: https://bitbucket.org/excion/wpkeyme/
Description: This plugin allows you to require the passing of a key value via the GET method: ?key=[string]. Specify the key in a  custom value called "key" with the [string].
Version: 0.2.1
Author: Aubrey Portwood of Excion
Author URI: http://excion.co
License: GPL
*/

/*  Copyright 2013  Excion Corporation  (email : aubrey@excion.co)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('template_redirect','wpkeyme');

function wpkeyme(){
	if(!is_user_logged_in()){
		global $post;
		$post_key = get_post_meta($post->ID, 'key', true);
	
		if($post_key){
			if(isset($_GET['key']) && $_GET['key']==$post_key){
				//do nothing
			}else{
				wp_die(__("<span style='text-align:center;display:block'><strong>WPKeyMe</strong>: Sorry, but you do not have permission to access this page. </span>"));
			}
		}
		
	}
}

add_action('init','wpkeyme_genkey');

function wpkeyme_genkey(){
	if(isset($_GET['wpkeyme'])){
		echo substr(md5(microtime()),rand(0,26),25);
		exit;
	}
}

add_action('add_meta_boxes','wpkeyme_meta_boxes');

function wpkeyme_meta_boxes(){
	$post_types = get_post_types();
	foreach($post_types as $post_type){
		add_meta_box(
			'wpkeyme',
			__('WPKeyMe: Secret Access Key','wpkeyme'),
			'wpkeyme_meta_box',
			$post_type
		);
	}
}

function wpkeyme_meta_box($post){
	wp_nonce_field( plugin_basename(__FILE__), 'wpkeyme_nonce');
	$current_key = get_post_meta($post->ID,'key',true);

	?>
	<p>
		<label for="wpkeyme_value">
			Secret Key: <input type="text" name="wpkeyme_value" id="wpkeyme_value" value="<?php echo esc_attr( $current_key ); ?>" style="width: 75%; margin-right: 10px;margin-left:5px;">
		</label>
		<input class="button" type="button" value="Generate Key" rel="165" onclick="jQuery('#wpkeyme_value').val(wpkeyme_randomkey());">
	</p>
	<p style="color: #aaa">
		If you want to limit access to this content, supply a secret string of characters above. Leave <em>empty</em> for public access.
	</p>

	<p style="border-top:1px solid #aaa;padding-top:10px;">
		<a href="<?php echo wpkeyme_link_key(get_permalink($post),$current_key) ?>" id="wpkeyme_current_url" style="width: 80%;overflow: hidden;display: block;height: 20px;float:right">
			<?php if($current_key!=''):
				echo wpkeyme_link_key(get_permalink($post),$current_key);
			else: ?>
				<?php the_permalink($post); ?>
			<?php endif; ?>
		</a>
		Access URL: 
	</p>
	<script>
		//thanks to: http://stackoverflow.com/a/1349426/1436129
		function wpkeyme_randomkey(){
		    var text = "";
		    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		    for( var i=0; i < 20; i++ )
		        text += possible.charAt(Math.floor(Math.random() * possible.length));
		    return text;
		}
	</script>
	<?php
}

function wpkeyme_link_key($link,$current_key){
	if(strstr($link,'?p=')){
		return $link . "&key=$current_key";
	}else{
		return $link . "?key=$current_key";
	}
}

add_action('save_post','wpkeyme_save');

function wpkeyme_save($post_id){
	if(
		!current_user_can('edit_post',$post_id)
		|| !current_user_can('edit_page',$post_id)
	){
		return;
	}

	if(
		!isset($_POST['wpkeyme_nonce']) 
		|| !wp_verify_nonce( $_POST['wpkeyme_nonce'], plugin_basename(__FILE__))
	){
		return;
	}

	$key_value = sanitize_text_field($_POST['wpkeyme_value']);

	if($key_value!=''){
		update_post_meta($post_id,'key', $key_value);
	}else{
		delete_post_meta( $post_id,'key');
	}
	

}

?>