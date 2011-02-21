<?php
/*
	Plugin Name: WP-3D-TWITTER-WALL
	Plugin URI: http://flashapplications.de/?p=423
	Description: Flash based AS3 3D Twitter Wall shows you the Tweets of an Twitter Search Result
	Version: 2.0
	Author: Jörg Sontag
	Author URI: http://www.flashapplications.de
	
	Copyright 2010, Jörg Sontag Flashapplications

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// check for WP context
if ( !defined('ABSPATH') ){ die(); }

//initially set the options
function wp_3dwall_install () {
	
    $newoptions = get_option('wp3dwall_options');
	$newoptions['width'] = '800';
	$newoptions['height'] = '600';
	$newoptions['media'] = 'Picture Path';
	$newoptions['tcolor'] = 'ffffff';
	$newoptions['tcolor2'] = '333333';
	$newoptions['bgcolor'] = '0097AA';
	$newoptions['trans'] = 'false';
	$newoptions['rsspath'] = 'Flash';
   
	add_option('wp3dwall_options', $newoptions);
	
	// widget options
	$widgetoptions = get_option('wp3dwall_widget');
	$newoptions['width'] = '800';
	$newoptions['height'] = '600';
	$newoptions['media'] = 'Picture Path';
	$newoptions['tcolor'] = '333333';
	$newoptions['tcolor2'] = '333333';
	$newoptions['bgcolor'] = 'ffffff';
	$newoptions['trans'] = 'false';
	$newoptions['rsspath'] = 'Flash';
   

	add_option('wp3dwall_widget', $newoptions);
}

// add the admin page
function wp_3dwall_add_pages() {
	add_options_page('WP 3D Twitter Wall', 'WP 3D Twitter Wall', 8, __FILE__, 'wp_3dtwitterwall_options');
}

// replace tag in content with tag cloud (non-shortcode version for WP 2.3.x)
function wp_3dwall_init($content){
	if( strpos($content, '[WP-3DWALL]') === false ){
		return $content;
	} else {
		$code = wp_3dwall_createflashcode(false);
		$content = str_replace( '[WP-3DWALL]', $code, $content );
		return $content;
	}
}

// template function
function wp_3dwall_insert( $atts=NULL ){
	echo wp_3dwall_createflashcode( false, $atts );
}

// shortcode function
function wp_3dwall_shortcode( $atts=NULL ){
	return wp_3dwall_createflashcode( false, $atts );
}

// piece together the flash code
function wp_3dwall_createflashcode( $widget=false, $atts=NULL ){
	// get the options
	if( $widget == true ){
		$options = get_option('wp3dwall_widget');
		$soname = "widget_so";
		$divname = "wp3dwallwidgetcontent";
		// get compatibility mode variable from the main options
		$mainoptions = get_option('wp3dwall_options');
	} else if( $atts != NULL ){
		$options = shortcode_atts( get_option('wp3dwall_options'), $atts );
		$soname = "shortcode_so";
		$divname = "wp3dwallcontent";
	} else {
		$options = get_option('wp3dwall_options');
		$soname = "so";
		$divname = "wp3dwallcontent";
	}

	// get some paths
	if( function_exists('plugins_url') ){ 
		// 2.6 or better
		$movie = plugins_url('3d-twitter-wall/T3Dwall.swf');
		$path = plugins_url('3d-twitter-wall/');
	} else {
		// pre 2.6
		$movie = get_bloginfo('wpurl') . "/wp-content/plugins/3d-twitter-wall/T3Dwall.swf";
		$path = get_bloginfo('wpurl')."/wp-content/plugins/3d-twitter-wall/";
	}
	// add random seeds to so name and movie url to avoid collisions and force reloading (needed for IE)
	$soname .= rand(0,9999999);
	$movie .= '?r=' . rand(0,9999999);
	$divname .= rand(0,9999999);
	// write flash tag
	if( $options['compmode']!='true' ){
		$flashtag = '<!-- SWFObject embed by Geoff Stearns geoff@deconcept.com http://blog.deconcept.com/swfobject/ -->';	
		$flashtag .= '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';
		$flashtag .= '<div id="'.$divname.'">';
	
		$flashtag .= '</p><p>WP 3D-Twitter-Wall by <a href="http://flashapplications.de/">Joerg Sontag Flashapplications</a> requires <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> 10 or better.</p></div>';
		$flashtag .= '<script type="text/javascript">';
		$flashtag .= 'var '.$soname.' = new SWFObject("'.$movie.'", "3dwall", "'.$options['width'].'", "'.$options['height'].'", "10", "#'.$options['bgcolor'].'");';
		if( $options['trans'] == 'true' ){
			$flashtag .= $soname.'.addParam("wmode", "transparent");';
			
		}
		$flashtag .= $soname.'.addParam("allowFullScreen", "true");';
        $flashtag .= $soname.'.addVariable("serverpath", "'.$path.'");';
		$flashtag .= $soname.'.addVariable("color", "0x'.$options['tcolor'].'");';
        $flashtag .= $soname.'.addVariable("media", "'.$options['media'].'");';
		$flashtag .= $soname.'.addVariable("tcolor", "0x' . ($options['tcolor2'] == "" ? $options['tcolor'] : $options['tcolor2']) . '");';
		$flashtag .= $soname.'.addVariable("rsspath", "'.$options['rsspath'].'");';
		$flashtag .= $soname.'.write("'.$divname.'");';
		$flashtag .= '</script>';
	} else {
		$flashtag = '<object type="application/x-shockwave-flash" data="'.$movie.'" width="'.$options['width'].'" height="'.$options['height'].'">';
		$flashtag .= '<param name="movie" value="'.$movie.'" />';
		$flashtag .= '<param name="bgcolor" value="#'.$options['bgcolor'].'" />';
		$flashtag .= '<param name="allowFullScreen" value="true" />';
		$flashtag .= '<param name="AllowScriptAccess" value="always" />';
		if( $options['trans'] == 'true' ){
			$flashtag .= '<param name="wmode" value="transparent" />';
			
		}
		$flashtag .= '<param name="flashvars" value="';
                $flashtag .= 'serverpath='.$path;
                $flashtag .= 'media='.$delay;
		$flashtag .= 'color=0x'.$options['tcolor'];
		$flashtag .= '&amp;tcolor=0x'.$options['tcolor2'];
		$flashtag .= '&amp;rsspath='.$options['rsspath'];
		$flashtag .= '" />';
		// alternate content
		$flashtag .= '</p><p>WP 3D-Twitter-Wall by <a href="http://flashapplications.de/">Joerg Sontag Flashapplications</a> requires <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> 10 or better.</p></div>';
		$flashtag .= '</object>';
	}
	return $flashtag;
}

// options page
function wp_3dtwitterwall_options() {	
	$options = $newoptions = get_option('wp3dwall_options');
	// if submitted, process results
	if ( $_POST["wp3dwall_submit"] ) {
	
		$newoptions['width'] = strip_tags(stripslashes($_POST["width"]));
		$newoptions['height'] = strip_tags(stripslashes($_POST["height"]));
		$newoptions['tcolor'] = strip_tags(stripslashes($_POST["tcolor"]));
		$newoptions['tcolor2'] = strip_tags(stripslashes($_POST["tcolor2"]));
	    $newoptions['bgcolor'] = strip_tags(stripslashes($_POST["bgcolor"]));
        $newoptions['trans'] = strip_tags(stripslashes($_POST["trans"]));
		$newoptions['rsspath'] = strip_tags(stripslashes($_POST["rsspath"]));
        $newoptions['media'] = strip_tags(stripslashes($_POST["media"]));
		
	}
	// any changes? save!
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('wp3dwall_options', $options);
	}
	// options form
	echo '<form method="post">';
	echo "<div class=\"wrap\"><h2>Display options</h2>";
	echo '<table class="form-table">';
	// width
	echo '<tr valign="top"><th scope="row">SWF Width (min. 520)</th>';
	echo '<td><input type="text" name="width" value="'.$options['width'].'" size="8"></input><br /></td></tr>';
	// height
	echo '<tr valign="top"><th scope="row">SWF Height (min. 550)</th>';
	echo '<td><input type="text" name="height" value="'.$options['height'].'" size="8"></input><br /></td></tr>';

	// text color
	echo '<tr valign="top"><th scope="row">Color of the 3DCube</th>';
	echo '<td><input type="text" name="tcolor" value="'.$options['tcolor'].'" size="8"></input> Text Color: <input type="text" name="tcolor2" value="'.$options['tcolor2'].'" size="8"></input> 
	<br />These should be 6 character hex color values without the # prefix (000000 for black, ffffff for white)</td></tr>';
	// background color
	echo '<tr valign="top"><th scope="row">Background color</th>';
	echo '<td><input type="text" name="bgcolor" value="'.$options['bgcolor'].'" size="8"></input><br />6 character hex color value</td></tr>';
	// transparent
	echo '<tr valign="top"><th scope="row">Use transparent Mode</th>';
	echo '<td><input type="checkbox" name="trans" value="true"';
	if( $options['trans'] == "true" ){ echo ' checked="checked"'; }
	echo '></input><br />Switches on Flash\'s wmode-transparent setting</td></tr>';
	// RSS Path
	echo '<tr valign="top"><th scope="row">Your Wall Hash Tag (example:Flash)</th>';
	echo '<td><input type="text" name="rsspath" value="'.$options['rsspath'].'" size="200"></input><br /></td></tr>';
    echo '<tr valign="top"><th scope="row">Background Picture URL</th>';
    echo '<td><input type="text" name="media" value="'.$options['media'].'" size="200"></input><br /></td></tr>';
	echo '<input type="hidden" name="wp3dwall_submit" value="true"></input>';
	echo '</table>';
	echo '<p class="submit"><input type="submit" value="Update Options &raquo;"></input></p>';
	echo "</div>";
	echo '</form>';
	
}

//uninstall all options
function wp_3dwall_uninstall () {
	delete_option('3dwall_options');
	delete_option('3dwall_widget');
}


// widget
function widget_init_wp_3dwall_widget() {
	// Check for required functions
	if (!function_exists('register_sidebar_widget'))
		return;

	function wp_3dwall_widget($args){
	    extract($args);
		$options = get_option('wp3dwall_widget');
		?>
	        <?php echo $before_widget; ?>
			<?php if( !empty($options['title']) ): ?>
				<?php echo $before_title . $options['title'] . $after_title; ?>
			<?php endif; ?>
			<?php
				if( !stristr( $_SERVER['PHP_SELF'], 'widgets.php' ) ){
					echo wp_3dwall_createflashcode(true);
				}
			?>
	        <?php echo $after_widget; ?>
		<?php
	}
	
	function wp_3dwall_widget_control() {
		$options = $newoptions = get_option('wp3dwall_widget');
		if ( $_POST["wp3dwall_widget_submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["wp3dwall_widget_title"]));
			$newoptions['width'] = strip_tags(stripslashes($_POST["wp3dwall_widget_width"]));
			$newoptions['height'] = strip_tags(stripslashes($_POST["wp3dwall_widget_height"]));
			$newoptions['tcolor'] = strip_tags(stripslashes($_POST["wp3dwall_widget_tcolor"]));
			$newoptions['tcolor2'] = strip_tags(stripslashes($_POST["wp3dwall_widget_tcolor2"]));
			$newoptions['bgcolor'] = strip_tags(stripslashes($_POST["wp3dwall_widget_bgcolor"]));
            $newoptions['trans'] = strip_tags(stripslashes($_POST["wp3dwall_widget_trans"]));
            $newoptions['rsspath'] = strip_tags(stripslashes($_POST["wp3dwall_widget_rsspath"]));
            $newoptions['media'] = strip_tags(stripslashes($_POST["wp3dwall_widget_media"]));
		
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('wp3dwall_widget', $options);
		}
		$title = attribute_escape($options['title']);
		$width = attribute_escape($options['width']);
		$height = attribute_escape($options['height']);
		$tcolor = attribute_escape($options['tcolor']);
		$tcolor2 = attribute_escape($options['tcolor2']);
		$bgcolor = attribute_escape($options['bgcolor']);
	        $trans = attribute_escape($options['trans']);
		$rsspath = attribute_escape($options['rsspath']);
                $delay = attribute_escape($options['media']);
		?>
			<p><label for="wp3dwall_widget_title"><?php _e('Title:'); ?> <input class="widefat" id="wp3dwall_widget_title" name="wp3dwall_widget_title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="wp3dwall_widget_width"><?php _e('SWF width (min 520):'); ?> <input class="widefat" id="wp3dwall_widget_width" name="wp3dwall_widget_width" type="text" value="<?php echo $width; ?>" /></label></p>
	<p><label for="wp3dwall_widget_height"><?php _e('SWF height (min 550):'); ?> <input class="widefat" id="wp3dwall_widget_height" name="wp3dwall_widget_height" type="text" value="<?php echo $height; ?>" /></label></p>

    <p><label for="wp3dwall_widget_rsspath"><?php _e('Wall Hash Tag:'); ?> <input class="widefat" id="wp3dwall_widget_rsspath" name="wp3dwall_widget_rsspath" type="text" value="<?php echo $rsspath; ?>" /></label></p>

	<p><label for="wp3dwall_widget_cubedelay"><?php _e('Background Picture URL:'); ?> <input class="widefat" id="wp3dwall_widget_media" name="wp3dwall_widget_media" type="text" value="<?php echo $delay; ?>" /></label></p>
		
			<p><label for="wp3dwall_widget_tcolor"><?php _e('Cube Color:'); ?> <input class="widefat" id="wp3dwall_widget_tcolor" name="wp3dwall_widget_tcolor" type="text" value="<?php echo $tcolor; ?>" /></label></p>
			<p><label for="wp3dwall_widget_tcolor2"><?php _e('Text Color:'); ?> <input class="widefat" id="wp3dwall_widget_tcolor2" name="wp3dwall_widget_tcolor2" type="text" value="<?php echo $tcolor2; ?>" /></label></p>
			<p><label for="wp3dwall_widget_bgcolor"><?php _e('Background Color:'); ?> <input class="widefat" id="wp3dwall_widget_bgcolor" name="wp3dwall_widget_bgcolor" type="text" value="<?php echo $bgcolor; ?>" /></label></p>
			<p><label for="wp3dwall_widget_trans"><input class="checkbox" id="wp3dwall_widget_trans" name="wp3dwall_widget_trans" type="checkbox" value="true" <?php if( $trans == "true" ){ echo ' checked="checked"'; } ?> > Background Transparency</label></p>
			<input type="hidden" id="wp3dwall_widget_submit" name="wp3dwall_widget_submit" value="1" />
		<?php
	}
	
	register_sidebar_widget( "WP-3D-Twitter-Wall", wp_3dwall_widget );
	register_widget_control( "WP-3D-Twitter-Wall", "wp_3dwall_widget_control" );
}

// Delay plugin execution until sidebar is loaded
add_action('widgets_init', 'widget_init_wp_3dwall_widget');

// add the actions
add_action('admin_menu', 'wp_3dwall_add_pages');
register_activation_hook( __FILE__, 'wp_3dwall_install' );
register_deactivation_hook( __FILE__, 'wp_3dwall_uninstall' );
if( function_exists('add_shortcode') ){
	add_shortcode('wp-3dwall', 'wp_3dwall_shortcode');
	add_shortcode('WP-3DWALL', 'wp_3dwall_shortcode');
} else {
	add_filter('the_content','wp_3dwall_init');
}

?>