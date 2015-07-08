<?php 

function colored_rocks_admin_load() {

	if (array_key_exists('page', $_REQUEST) && 'colored_rocks_options' == $_REQUEST['page']) {
        add_action('admin_head', 'colored_rocks_admin_options_head');
        wp_enqueue_script('jc-scripts', get_template_directory_uri() . '/include/admin.js', array('jquery'), '1.0.0', true);
    } else {
        add_action('admin_head', 'colored_rocks_admin_head');    
    }
    
}



function colored_rocks_admin_resources(){
    
}

function colored_rocks_admin_options_head() { 
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/include/admin.css" />
    <script type="text/javascript" language="javascript">
    jQuery(document).ready(function(){
        jQuery('#colored_rocks_tab_menu>li:first').addClass('active');
        jQuery('#colored_rocks_tab').tabify();
    });
    </script>
    <?php        
}
function colored_rocks_admin_head() { 
    ?>
    <script type="text/javascript" language="javascript">
    jQuery(document).ready(function(){
        var $shortcodeTrigger = jQuery('#add_colored_rocks_shortcodes');
        if ($shortcodeTrigger.length != 0)
            tb_position();
    });
    </script>
    <?php        
}


function colored_rocks_theme_menu() {
	add_theme_page('Colored Rocks Theme Options', 'Website Options', 'edit_theme_options', 'colored_rocks_options', 'colored_rocks_options_page');
}

function colored_rocks_options_page() {
	
	global $colored_rocks_params;
    $colored_rocks_message = "";
        
    $tab = (isset($_REQUEST['tab'])) ? intval($_REQUEST['tab']) : 1;
	$errors = array();
	
    // we have submited the page -> save
	if ('colored_rocks_options' == $_REQUEST['page']) {
	    if (isset($_REQUEST['action']) && ('update' == $_REQUEST['action'])) {
	        $errors = colored_rocks_options_page_save($colored_rocks_params);
	        if (count($errors) == 0){
	            wp_redirect("themes.php?page=colored_rocks_options&message=1&tab=" . $tab);
            } else {
                $colored_rocks_message = __("Options saved with errors", 'colored_rocks');
            }
	    }
	    else {
            if (isset($_REQUEST['message']))
	            $colored_rocks_message = __("Options saved", 'colored_rocks');
	    } 
	}    
	
	
	echo '<div class="wrap">';

	if ($colored_rocks_message != ""){
	    echo '<div class="updated fade below-h2" style="background-color: rgb(255, 251, 204);"><p>'.$colored_rocks_message.'</p>';
	    if (count($errors) == 0){
	        echo '<ul>';
	        foreach ($errors as $key => $error) {
    	        echo '<li>' . $error . '</li>';    
	        }
	    echo '</ul>';
	    }
	    echo '</div>';
	}
	
	//echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" onsubmit="return false;" enctype="multipart/form-data">';
	echo '<form action="themes.php?page=colored_rocks_options&noheader=true" method="post" enctype="multipart/form-data">';
	echo wp_nonce_field('update-options','nonce');

	$fields = '';
	$start_table = false;
	$debug = '';
	$embedded = '';
	
	// pour le menu
	$tab_menu = "\n".'<div id="colored_rocks_tab">';
	$tab_menu .= "\n".'<div id="colored_rocks_tab_header"><h2>'.__('Website Options', 'colored_rocks').'</h2></div>';
	$tab_menu .= "\n".'<ul id="colored_rocks_tab_menu">';
	$tab_index = 1;
	
	foreach ($colored_rocks_params as $key => $option) {
	    if ($option['type'] == "set"){
	        $active_tab = ($tab_index == $tab) ? ' class="active"' : '';
	        $tab_menu .= '<li '.$active_tab.'><a href="#colored_rocks_tab_'.$option['id'].'">'.$option['name'].'</a></li>';        
	        
	        $tab_index++;
	    }
	}
	$tab_menu .= "</ul><!-- #colored_rocks_tab -->\n<div id='colored_rocks_tab_content'>";
	echo $tab_menu;
	foreach ($colored_rocks_params as $key => $option){
		$out = "";
		$current = "";
		if (array_key_exists('id', $option)){
            $id = $option['id'];
            $current = colored_rocks_get_option($id); 
		}else{
		     $id = "ui";   
		}
		$debug .= $id . "=" . $current . "<br />";
		switch ( $option['type'] ) {
			case 'set':
				// $out = "<h3>".$option['name']."</h3>";
				$out = '';
				if ($option['help'] != ''){
				    $out .= "<p>".$option['help']."</p>";
				}
				break;
			case 'text':
				$out = "<input type='text' id='".esc_attr($id)."' name='".esc_attr($id)."' value='".esc_attr($current)."' {{ style }} />";
				break;
			case 'textarea':
				$out = "<textarea id='".esc_attr($id)."' name='".esc_attr($id)."' {{ style }} >".esc_textarea($current)."</textarea>";
				break;
			case 'select':
				$out = "<select id='".esc_attr($id)."' name='".esc_attr($id)."' {{ style }} >";
				foreach ($option['choices'] as $key => $choice) {
					$out .= "<option value='".esc_attr($choice["value"])."' ".selected($choice["value"], $current, false)." >".$choice["name"]."</option>";
				}	
				$out .= "</select>";
				break;
			case 'radio':
				$out = "";
				foreach ($option['choices'] as $key => $choice) {
					$out .= "<input name='".esc_attr($id)."' type='radio' value='".esc_attr($choice["value"])."' ".checked($choice["value"], $current, false)." > ".$choice["name"]."<br />" ;
				}	
				break;
			case 'checkbox':
				$out = "";
				foreach ($option['choices'] as $key => $choice) {
					if ($out != "") $out .= "<br />";
					$out .= "<input name='".esc_attr($id)."' type='checkbox' value='".esc_attr($choice["value"])."' ".checked($choice["value"], $current, false)." > ".$choice["name"];
				}
				break;
			case 'upload':
				$out .= colored_rocks_get_upload_field($option);
				break;
		}		
		
		// on remplace les params
		if (array_key_exists('options', $option)){
		    foreach ($option['options'] as $key => $param) {
		        $out = str_replace( '{{ '.$key.' }}', $param, $out);
            }	
        }
		// on nettoie les params non utilisés
		$out = str_replace( '/\{\{ [\w\-_]+ \}\}/', "", $out);
		
		
		if ($option['type']=="set"){
		    if ($start_table) {
		        if ($embedded == '') echo '</table>';
	            echo '</div>'."\n";
            }
		    echo '<div id="colored_rocks_tab_'.$option['id'].'" class="colored_rocks_tab_content">';
		    echo $out;
			$embedded = (isset($option['embedded']) && $option['embedded'] != '')
				    ? $option['embedded'] : '';
			if ($embedded == '')
			    echo '<table class="form-table">';
		    else{
		        require_once($embedded.'.php');
	        }
		    $start_table = true;
		} else {
			if ($fields != '') $fields .= ',';
			$fields .= $id;
			// $out = $option['type'];
		
			echo '<tr valign="top">';
			echo '<th scope="row">'.$option['name'].'</th>';
			echo '<td>'.$out;
			if (isset($option['help'])){
				echo '<br/><span class="description">'.$option['help'].'</span>';
			}
			echo '</td></tr>';
		}
	}
	
	if ($start_table){
		echo "</table></div>\n";
	}	
	echo "</div><!-- #colored_rocks_tab_content -->\n";
	echo '<div id="colored_rocks_tab_footer"><input type="hidden" name="action" value="update" />';
	echo '<input type="hidden" name="page_options" value="'.$fields.'" />';
	// echo '<div>' . $debug . '<div/>';
	echo '<input type="submit" class="button-primary" value="'.__('Save Changes', 'colored_rocks').'" />';
	echo "</div><!-- #colored_rocks_tab_footer -->\n</div><!-- #colored_rocks_tab -->\n</form>";
	echo '</div>';
}


function colored_rocks_get_upload_field($option){

        
    $id = $option['id'];
    
    $temp = __("upload file : ", 'colored_rocks');
    $temp .= '<input type="file" name="file_'.$id.'" /><br />';
    $temp .= __("or the url : ", 'colored_rocks');
        
    $file = colored_rocks_get_option($id);
    if (empty($file)) {
        $temp .= '<input class="upload-input-text" name="'.esc_attr($id).'" value=""/>';
    } else {
        $temp .= '<input class="upload-input-text" name="'.esc_attr($id).'" value="'.esc_attr($file).'"/><br />';
        $temp .= '<a href="'. esc_attr($file) . '" target="_blank">';
        $temp .= '<img src="'.esc_attr($file).'" width="200" height="200" alt="" />';
        $temp .= '</a>'; 
    }
    
    return $temp;
}

/**
* Save the options
*/
function colored_rocks_options_page_save($options){
    
    if ( empty($_POST) || !wp_verify_nonce($_POST['nonce'],'update-options') ){
		print 'Sorry, your nonce did not verify.';
   		exit;
	}
    
    global $colored_rocks_options;

    $save_errors = array();
    
    foreach ($options as $key => $option) {    
        if (array_key_exists('id', $option)){
            $id = $option['id'];
            switch ($option['type']) {
                case 'set': 
                    break;
                case 'text':
                case 'textarea':
                    if (isset($_REQUEST[$id])){
	                    $val = stripslashes($_REQUEST[$id]);
	                    colored_rocks_update_option($id, $val);
	                } else {
	                	colored_rocks_delete_option($id);
	                }
                    break;
                case 'select':
                case 'checkbox':
                case 'radio':
                    // TODO multi-value
                    if (isset($_REQUEST[$id])){
                        colored_rocks_update_option($id, $_REQUEST[ $id ]);
                    } else {
                        colored_rocks_delete_option($id);
                    }
                    break;
                case 'upload':
                    if (!empty($_FILES['file_'.$id]['name'])){         
                        $overrides = array('test_form' => false);
                        $file = wp_handle_upload($_FILES['file_' . $id], $overrides);
                        if (isset($file['error']))
                            $save_errors[] = $file['error'];
                        else
                            colored_rocks_update_option($id , $file['url']);
                    }elseif (isset($_REQUEST[$id])){
                        colored_rocks_update_option($id , $_REQUEST[$id]);
                    }
                    break;
            }
        }
    }
    
    update_option('colored_rocks_theme_options', $colored_rocks_options);

    return $save_errors;
} 

/*
* Initialize themes options with default values. 
*/
function colored_rocks_init_default_themes_options($force=false){
	
    global $colored_rocks_params;
    global $colored_rocks_options;
    colored_rocks_init_theme_options();
    
    if ($force) {
    	$colored_rocks_options = array();
    	delete_option('colored_rocks_theme_options');
    }
    foreach ($colored_rocks_params as $key => $option) {
		if (array_key_exists('id', $option)){
		    if ($option['type'] != 'set'){
                $id = $option['id'];
                $default = $option['default'];
                colored_rocks_update_option($id, $default);
            }
        }
		// $current = get_option($id); 
		// $debug .= $id . "=" . $current . "<br />";
	}
	update_option('colored_rocks_theme_options', $colored_rocks_options);

}

function colored_rocks_under_contruction(){
    $html = colored_rocks_get_option('uc_custom_html');
    echo html_entity_decode($html, ENT_QUOTES);
    die();
}

/*============================================================================
 Adding meta "page options" to Page/Post
============================================================================*/

add_action( 'add_meta_boxes', 'colored_rocks_page_options_add_meta_box' );
function colored_rocks_page_options_add_meta_box(){
    add_meta_box("page_options_meta_box", __('Page Options', 'colored_rocks'), "colored_rocks_page_options_meta_box", 'page', "normal", "low");
    add_meta_box("page_options_meta_box", __('Page Options', 'colored_rocks'), "colored_rocks_page_options_meta_box", 'post', "normal", "low");

}
function colored_rocks_page_options_meta_box(){
    
    global $post;
    
    wp_nonce_field(plugin_basename( __FILE__ ), 'colored_rocks_nonce');

    $sidebar = get_post_meta($post->ID, "_sidebar", true);
    if (!isset($sidebar)) $sidebar = "1";
    ?>
    <p>
        <label><strong><?php echo __('Display the sidebar', 'colored_rocks'); ?></strong> :</label><br />
        <select name="_sidebar" style="width: 98%;">
            <option value="0" <?php if ($sidebar == "0") echo 'selected="selected"'; ?> ><?php _e('No', 'colored_rocks'); ?></option>
            <option value="1" <?php if ($sidebar != "0") echo 'selected="selected"'; ?> ><?php _e('Yes', 'colored_rocks'); ?></option>
        </select>
    </p>
    <?php
}

add_action('save_post', 'colored_rocks_page_options_save_details');
function colored_rocks_page_options_save_details($post_id){
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    if (!wp_verify_nonce($_POST['colored_rocks_nonce'], plugin_basename(__FILE__))) return $post_id;

    if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) return $post_id;
	} else {
		if (!current_user_can('edit_post', $post_id)) return $post_id;
	}
    
    $fields = array(
        '_sidebar', 
    );
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {  
            $data = $_POST[$field];
            update_post_meta($post_id, $field, $data);
        }
    }
        
}

