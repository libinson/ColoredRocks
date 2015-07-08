<?php

define('CROPTIONS_THEME', 'colored_rocks');

// themes options
$colored_rocks_options = array();
// themes params
$colored_rocks_params = array();

require_once(get_template_directory().'/include/_params.php');
require_once(get_template_directory().'/include/admin.php');

if (!isset( $content_width)) $content_width = 860;


add_action('after_setup_theme', 'colored_rocks_setup');
if (! function_exists('colored_rocks_setup')){

    function colored_rocks_setup() {
        
        // load theme options
        colored_rocks_load_options();

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support('automatic-feed-links');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menu('primary', __('Primary Menu', 'colored_rocks'));

        // Add support for Featured Images
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(200, 100, true);
        add_image_size('large-feature', 500, 375, true); // Used for large feature (header) images
        

        // set the good content width
        if (colored_rocks_get_option('sidebar') != 'no'){
            global $content_width;
            $content_width = 560;
        }

        // Add Shortcodes
        if (colored_rocks_get_option('sc') != 'no'){
            require_once(get_template_directory().'/include/shortcode.php');
            // Enable Shortcodes in excerpts and widgets
            add_filter('widget_text', 'do_shortcode');
            add_filter('the_excerpt', 'do_shortcode');
            add_filter('get_the_excerpt', 'do_shortcode');
        }
 
        if (is_admin()){
            add_action('init', 'colored_rocks_init_theme_options');
            add_action('admin_menu', 'colored_rocks_theme_menu');
            add_action('admin_menu', 'colored_rocks_admin_load');
            add_action('admin_menu', 'colored_rocks_admin_resources');
        
            if (is_admin() && isset($_GET['activated'])) {
                colored_rocks_init_default_themes_options(true);
            }
        } else {
            add_action('wp_enqueue_scripts', 'colored_rocks_load_js');
            add_action('wp_head', 'colored_rocks_wp_head');
            add_action('wp_footer', 'colored_rocks_wp_footer');
        }

    }
} 

// colored_rocks_setup

function colored_rocks_load_options() {
    
    global $colored_rocks_options;
    
    if (count($colored_rocks_options) == 0){
        // load theme options
        $colored_rocks_options = get_option('colored_rocks_theme_options', false);
        if (!is_array($colored_rocks_options) || (is_array($colored_rocks_options) && count($colored_rocks_options) == 0)) {
            colored_rocks_init_default_themes_options();
        }
    }

}

function colored_rocks_get_option($key, $default=false) {

    global $colored_rocks_options;

    $ret = $default;
    if (is_array($colored_rocks_options) && array_key_exists($key, $colored_rocks_options)){
        $ret = $colored_rocks_options[$key];
    }

    return $ret; 
}

function colored_rocks_add_option($key, $value) {
    return colored_rocks_update_option($key, $value);
}

function colored_rocks_update_option($key, $value) {
    global $colored_rocks_options;
    if (is_array($colored_rocks_options)){
        $colored_rocks_options[$key] = $value;
        return true;
    }
    return false;
}

function colored_rocks_delete_option($key) {
    global $colored_rocks_options;
    if (is_array($colored_rocks_options) && array_key_exists($key, $colored_rocks_options)){
        unset($colored_rocks_options[$key]);
        return  true;
    }
    return false;
}




/**
 * Add Static Javascript And CSS Library
 */
function colored_rocks_load_js(){
    // Enqueue Javascript
    if(!is_admin()) {
        wp_enqueue_script('jquery');
        if (file_exists(get_template_directory()."/js/libs/modernizr-2.0.6.min.js")) {
            wp_enqueue_script('jc-one-modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.0.6.min.js', array('jquery'));
        }
        if (file_exists(get_template_directory()."/js/plugins.js")) {
            wp_enqueue_script('jc-one-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery', 'jc-one-modernizr'));
        }
        if (file_exists(get_template_directory()."/js/script.js")) {
            wp_enqueue_script('jc-one-script', get_template_directory_uri() . '/js/script.js', array('jquery', 'jc-one-modernizr'));
        }
        if (file_exists(get_template_directory()."/styles/".colored_rocks_get_option('stylesheet'))) {
            wp_enqueue_style('jc-one-custom-style', get_template_directory_uri()."/styles/".colored_rocks_get_option('stylesheet'));
        }
    }
}

/**
 * Add Custom Javascript And CSS in head
 */
function colored_rocks_wp_head(){

    $css = colored_rocks_get_option('css');
    $js = colored_rocks_get_option('js');
    
    $out = '';
    if ($css != '') $out .= '<style type="text/css">'."\n".$css."\n".'</style>'."\n";
    if ($js != '') $out .= '<script type="text/javascript">'."\n".'/* <![CDATA[ */'."\n".$js."\n".'/* ]]> */'."\n</script>\n";

    echo $out;
}


/**
 * Add Custom Javascript in footer
 */
function colored_rocks_wp_footer(){
?>
<!--[if lt IE 7 ]>
    <script src="https://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
<?php
}


/**
 * Register sidebar
 */
function colored_rocks_register_sidebar() {

    if (colored_rocks_get_option('sidebar') != 'no'){
        register_sidebar(array(
            'name' => __('Main Sidebar', 'colored_rocks'),
            'id' => 'primary',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
       ));
    }
    
    if (colored_rocks_get_option('footer_sidebar') != 'no'){
        register_sidebar(array(
            'name' => __('Footer Sidebar 1', 'colored_rocks'),
            'id' => 'footer_1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
       ));

        register_sidebar(array(
            'name' => __('Footer Sidebar 2', 'colored_rocks'),
            'id' => 'footer_2',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
       ));

        register_sidebar(array(
            'name' => __('Footer Sidebar 3', 'colored_rocks'),
            'id' => 'footer_3',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
       ));

    }
}
add_action('widgets_init', 'colored_rocks_register_sidebar');


/**
 * Test if a sidebar is activated
 *
 * 4 sidebars can be used in the theme, in 2 locations : 1 in sidebar / 3 in footer
 * Test if the sidebars are activated for a single post/page or is empty
 *
 * @param string $context the location : sidebar or footer
 * @return boolean if there is a sidebar to display
 */
function colored_rocks_has_sidebar($context) {
    
    global $post;
    
    if (is_page() || is_single()) {
        $sidebar = get_post_meta($post->ID, '_sidebar', true);
        if (isset($sidebar) && $sidebar == "0")
            return false;
    }
    
    if ($context == 'primary') return (colored_rocks_get_option('sidebar') == 'yes' && is_active_sidebar('primary'));
    if ($context == 'footer') 
        return (colored_rocks_get_option('footer_sidebar') == 'yes' && 
            (is_active_sidebar('footer_1')
            || is_active_sidebar('footer_2')
            || is_active_sidebar('footer_3')));
    
    return false;
}



/**
 * Display social icons in the footer.
 *
 */
function colored_rocks_get_social($before='<ul class="social-bar clearfix">', $after='</ul>') {
    
    $out = '';
    $socials = array (
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'myspace' => 'MySpace',
        'flickr' => 'Flickr',
        'skype' => 'Skype',
        'youtube' => 'Youtube',
        'vimeo' => 'Vimeo',
        'dailymotion' => 'Daily Motion'
    );    
    foreach ($socials as $sid => $sname) {
        $temp = colored_rocks_get_option($sid);
        if (isset($temp) && trim($temp) != ''){
            $out .= '<li class="social-'.$sid.'"><a href="'.esc_url($temp).'" target="_blank">'.$sname.'</a></li>';            
        }
    }
    
    if ($out != ''){
        $out = $before.$out.$after;
    }
    
    return $out;
}



        
/**
 * Sets the post excerpt length to 50 words.
 *
 */
function colored_rocks_excerpt_length($length) {
    return 50;
}
add_filter('excerpt_length', 'colored_rocks_excerpt_length');

function colored_rocks_get_the_excerpt($length=100, $end=' ...') {
    $out = get_the_excerpt();
    if (strlen($out) > $length)
        $out = substr($out, 0, $length).$end;
        
    return $out;
}



/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function colored_rocks_page_menu_args($args) {
    $args['show_home'] = true;
    return $args;
}
add_filter('wp_page_menu_args', 'colored_rocks_page_menu_args');


/**
 * Display navigation to next/previous pages when applicable
 */
function colored_rocks_content_nav($nav_id, $context='loop') {
    global $wp_query;
    
    if ($context == 'loop'){
        if ($wp_query->max_num_pages > 1) { ?>
        <nav id="<?php echo $nav_id; ?>" class="clearfix">
            <div class="nav-previous"><?php previous_posts_link(__('<span class="meta-nav">&larr;</span> Newer posts', 'colored_rocks')); ?></div>
            <div class="nav-next"><?php next_posts_link(__('Older posts <span class="meta-nav">&rarr;</span>', 'colored_rocks')); ?></div>
        </nav>
        <?php }
    } else {
        ?>
        <nav id="<?php echo $nav_id; ?>" class="clearfix">
            <div class="nav-previous"><?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span> %title', 'colored_rocks')); ?></div>
            <div class="nav-next"><?php next_post_link('%link', __('%title <span class="meta-nav">&rarr;</span>', 'colored_rocks')); ?></div>
        </nav>
        <?php 
    }
    
}


/**
 * Display A non results block in an empty categorie, tag, search, ...
 */
function colored_rocks_no_results($message = '') {
    
    if ($message == '')
        $message = __('Apologies, but no results were found. Perhaps searching will help find a related post.', 'colored_rocks');
    ?>
    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e('Nothing Found', 'colored_rocks'); ?></h1>
        </header><!-- .entry-header -->
        <div class="entry-content">
            <p><?php echo $message; ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
    <?php
}


if (! function_exists('colored_rocks_comment')) {
    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own colored_rocks_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
    function colored_rocks_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <div class="post pingback">
            <p><?php _e('Pingback:', 'colored_rocks'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'colored_rocks'), '<span class="edit-link">', '</span>'); ?></p>
        <?php
                break;
            default :
        ?>
        <div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <?php
                $avatar_size = 64;
                if ($depth != 1)
                    $avatar_size = 32;
                ?>
                <div class="comment-avatar-<?php echo $avatar_size; ?>">
                <?php
                echo get_avatar($comment, $avatar_size);
                ?>
                </div>
                <div class="comment-body">
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                                /* translators: 1: comment author, 2: date and time */
                                printf(__('%1$s <span class="datetime">&mdash; %2$s</span>', 'colored_rocks'),
                                    sprintf('<span class="fn">%s</span>', get_comment_author_link()),
                                    sprintf('<time pubdate datetime="%2$s">%3$s</time>',
                                        esc_url(get_comment_link($comment->comment_ID)),
                                        get_comment_time('c'),
                                        /* translators: 1: date, 2: time */
                                        sprintf(__('%1$s at %2$s', 'colored_rocks'), get_comment_date(), get_comment_time())
                                   )
                               );
                            ?>

                            <?php edit_comment_link(__('Edit', 'colored_rocks'), '<span class="edit-link">', '</span>'); ?>
                        </div><!-- .comment-author .vcard -->
                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'colored_rocks'); ?></em>
                        <?php endif; ?>
                    </div>

                    <div class="comment-content"><?php comment_text(); ?></div>

                    <div class="reply">
                        <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply <span>&darr;</span>', 'colored_rocks'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                    </div><!-- .reply -->
                </div>
            </article><!-- #comment-## -->

        <?php
                break;
        endswitch;
    }
} // ends check for colored_rocks_comment()


//All links for images default to none
	update_option('image_default_link_type','none');
	
//Add user ID column
add_filter('manage_users_columns', 'pippin_add_user_id_column');
function pippin_add_user_id_column($columns) {
    $columns['user_id'] = 'User ID';
    return $columns;
}
 
add_action('manage_users_custom_column',  'pippin_show_user_id_column_content', 10, 3);
function pippin_show_user_id_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
	if ( 'user_id' == $column_name )
		return $user_id;
}


/************* Profile edits *************/

// remove personal options block
if(is_admin()){
  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  add_action( 'personal_options', 'prefix_hide_personal_options' );
}
function prefix_hide_personal_options() {

?>
	<script type="text/javascript">
	  jQuery(document).ready(function( $ ){
		$("#your-profile .form-table:first, #your-profile h3:first").remove();
		$("#nickname,#display_name").parent().parent().remove();
		// hide the website
		$(".form-table:eq(1) tr:eq(1)").hide();
		
	  });
	</script>
<?php
}

/************* Remove the Bio and other usless fields *************/

	if (! function_exists('remove_plain_bio') ){
		function remove_plain_bio($buffer) {
			$titles = array('#<h3>About Yourself</h3>#','#<h3>About the user</h3>#');
			$buffer=preg_replace($titles,'<h3>Password</h3>',$buffer,1);
			$biotable='#<h3>Password</h3>.+?<table.+?/tr>#s';
			$buffer=preg_replace($biotable,'<h3>Password</h3> <table class="form-table">',$buffer,1);
			return $buffer;
		}

    function profile_admin_buffer_start() { ob_start("remove_plain_bio"); }

    function profile_admin_buffer_end() { ob_end_flush(); }
}
add_action('admin_head', 'profile_admin_buffer_start');
add_action('admin_footer', 'profile_admin_buffer_end');

/************* Remove Contact Method in Profile *************/

add_filter( 'user_contactmethods', 'update_contact_methods',10,1);

	function update_contact_methods( $contactmethods ) {

	unset($contactmethods['aim']);  
	unset($contactmethods['jabber']);  
	unset($contactmethods['yim']);  


	return $contactmethods;
	}

/*************Disable admin bar*************/

//add_filter('show_admin_bar', '__return_false');
	
/****************Remove WP junks***************/

function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

/*************Custom admin footer*************/

function remove_footer_admin () {
    echo "Design and Development by Dreamdare Production";
} 

add_filter('admin_footer_text', 'remove_footer_admin');

/*****************Change "Post" to "Essays" Globally***************/
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Essays';
	$submenu['edit.php'][5][0] = 'Essays';
	$submenu['edit.php'][10][0] = 'Add New Essays';
	$submenu['edit.php'][16][0] = 'Add New Essays Tag';
	echo '';
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Essays';
	$labels->singular_name = 'Essays';
	$labels->add_new = 'Add New Essays';
	$labels->add_new_item = 'Add New Essays';
	$labels->edit_item = 'Edit Essays';
	$labels->new_item = 'Essays';
	$labels->view_item = 'View Essays';
	$labels->search_items = 'Search Essays';
	$labels->not_found = 'No Essays found';
	$labels->not_found_in_trash = 'No Essays found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );
	
/*************Custom login style*************/

function change_login_css() {
  echo '<style type="text/css">
    h1 a {
      background-image: url('.get_template_directory_uri().'/images/login-logo.png) !important;
	  height: 68px !important;
	  background-size: 500px 68px!important;
    }
	.login h1 a {
	width:500px!important;
	}
	.login #login a {
      color: #298CBA !important;
	  text-shadow: none !important;
    }
    .login #login a:hover, .login #login a:focus {
      color: orange !important;
    }
	#login {
	width: 500px!important;
	padding: 53px 0 0!important;
	}
	.login form .input, .login input[type="text"] {
	font-size: 20px!important;
	}
	#login .cimy_uef_input_27, .cimy_uef_picture {
	font-size: 20px!important;
	width: 97%;
	line-height: 25px!important;
	}
    #loginform label {
      color: #EEE!important;
    }
    #loginform input:focus {
      border: 1px solid #669999!important;
    }
	.login form {
	background: url('.get_template_directory_uri().'/images/maroon-trans-bg.png) repeat!important;
	}
	#login form p {
	color: #EEE!important;
	clear: both!important;
	}
	.login p {
	color: #333!important;
	}
	.login label {
	color: #eee!important;
	}
	body.login {
	background: url('.get_template_directory_uri().'/images/rock.jpg) repeat!important;
	background-size: 100%!important;
	color: #EEE!important;
	}
	div.updated, .login .message {
	color:#333!important;
	}
	html, .wp-dialog {
	background: url('.get_template_directory_uri().'/images/rock.jpg) repeat!important;
	}
	div.error, .login #login_error {
	color: #333!important;
	}
  </style>';
}

add_action('login_head','change_login_css');


/* Add new roll for clients*/ 
$judges_role = add_role('judge', 'Judge', array(
    'read' => true, // True allows that capability
    'edit_posts' => false,
    'delete_posts' => false, // Use false to explicitly deny
));

/**************change role names **************/

function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['subscriber']['name'] = 'Student';
    $wp_roles->role_names['subscriber'] = 'Student';           
}
add_action('init', 'change_role_name');

// remove roles
/*$wp_roles = new WP_Roles();
$wp_roles->remove_role("author");*/


/************** Redirect admins to the dashboard and other users elsewhere **************/

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
function my_login_redirect( $redirect_to, $request, $user ) {
    // Is there a user?
    if ( is_array( $user->roles ) ) {
        // Is it an administrator?
        if ( in_array( 'administrator', $user->roles ) )
            return home_url( '/wp-admin/' );
        else
            return home_url('/submit-your-essay/');
            // return get_permalink( 83 );
    }
}


// register judge specific sidebar
        register_sidebar(array(
            'name' => __('Judges sidebar', 'colored_rocks'),
            'id' => 'judges_sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
       ));
	   
//Disable admin bar for non admins
// show admin bar only for admins
if (!current_user_can('manage_options')) {
	add_filter('show_admin_bar', '__return_false');
}

/* changes the "Register For This Site" text on the Wordpress login screen (wp-login.php) */
	function ik_change_login_message($message) 
	{
		// change messages that contain 'Register' 
		if (strpos($message, 'Register') !== FALSE) {
			$newMessage = 'Register here to enter the Colored Rocks Competition';
			return '<p class="message register">' . $newMessage . '</p>';
		}
		else {
			return $message;
		}
	}
 
	// add our new function to the login_message hook
	add_action('login_message', 'ik_change_login_message');

add_action('publish_post', 'send_admin_email');
function send_admin_email($post_id)
{
    $to = 'info@coloredrocks.org';
    $subject = 'A new essay has been entered';
    $message = "The new essay submitted will be available at ".get_permalink($post_id);
    wp_mail($to, $subject, $message );
}