<?php
/**
 * Novelty Shoe functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Novelty_Shoe
 */

if ( ! function_exists( 'novelty_shoe_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function novelty_shoe_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Novelty Shoe, use a find and replace
		 * to change 'novelty-shoe' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'novelty-shoe', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'novelty-shoe' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'novelty_shoe_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'novelty_shoe_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function novelty_shoe_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'novelty_shoe_content_width', 640 );
}
add_action( 'after_setup_theme', 'novelty_shoe_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function novelty_shoe_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'novelty-shoe' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'novelty-shoe' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'novelty_shoe_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function novelty_shoe_scripts() {
	wp_enqueue_style( 'novelty-shoe-style', get_stylesheet_uri() );
	wp_enqueue_style( 'novelty-shoe-app', get_template_directory_uri() . "/css/app-styles.css", array('novelty-shoe-style'));

	wp_enqueue_script( 'novelty-shoe-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'novelty-shoe-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script('novelty-shoe-app', get_template_directory_uri() . '/js/app.js', array('jquery'));
	$app_data = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'ajax_nonce' => wp_create_nonce('public_nonce'),
	);
	wp_localize_script('novelty-shoe-app', 'novelty', $app_data);


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'novelty_shoe_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function novelty_shoe(){
	
	ob_start(); ?>

		<div class="aim-header light-blue-background">
			<img src="<?php echo get_template_directory_uri();?>/img/guy.png">
			<h3>Sign On</h3>
		</div>
		<div id="aim-body">
			<div class="aim-login">
				<div id="login-graphic" class="blue-background">
					<img src="<?php echo get_template_directory_uri(); ?>/img/guy-aol.png">
				</div>
	
				<hr>
				
				<div id="aim-content" class="bottom-section">
					<form method="POST">
						
						<div>
							<label for="username" class="blue italic bold">ScreenName</label><br />
							<input type="text" name="username" id="username" />
						</div>
		
						<div>
							<label for="password">Password</label>
							<input type="password" name="password" id="password" disabled />
						</div>
						<a href="#" class="modal-trigger" data-modalType="help" data-content="The funniest word in the english language." data-title="Password Hint" data-type="info">Forgot Password?</a>
						<div class="checkboxes flex space-between">
							<div class="save-password">
								<input type="checkbox" checked="checked"><label for="save-password" >Save password</label>
							</div>
							<div class="auto-login">
								<input type="checkbox"><label for="auto-login">Auto-login</label>
							</div>
						</div>
	
						<div class="buttons flex space-between">
							<div class="flex">
								<div class="modal-trigger" data-type="info" data-content="<p>You know the drill:</p><ol><li>Get Older</li><li>Solve Puzzles</li><li>Have Fun</li></ol><p style='font-style:italic'>Note: assume the first letter of each line (not word) is capitalized.</p>" data-title="Help">
									<img src="<?php echo get_template_directory_uri();?>/img/help-icon.png">
									<p><span class="underline">H</span>elp</p>
								</div>
								<div style="margin-left:20px;">
									<img src="<?php echo get_template_directory_uri();?>/img/half-setup.png">
									<p>S<span class="underline">e</span>tup</p>
								</div>
							</div>
							<div>
								<img src="<?php echo get_template_directory_uri();?>/img/empty-guy.png " id="sign-on-image" data-root="<?php echo get_template_directory_uri(); ?>/img/">
								<p class="bold"><span class="underline">S</span>ign On</p>
							</div>
						</div>
					</form>
					<p class="center" id="version">Version: 4.8.19</p>
				</div>
			</div>
		</div>

		<div class="templates">

			<div id="modal-template" class="modal template">
				<div class="aim-header light-blue-background">
					<h3>Alert</h3>
				</div>
				<div class="flex modal-content align-center">
					<div class="modal-image">
						<img src="/wp-content/themes/noveltyshoe/img/help.png">
					</div>
					<div class="modal-text">
						
					</div>
				</div>
				<div>
					<button class="alert-button">OK</button>
				</div>
			</div>

			<div class="buddy-list">
				<ul class="tabs flex">
					<li class="active-tab" data-target="online">Online</li>
					<li data-target="offline">Offline</li>
				</ul>
				<div class="buddies">
					<div class="online list active">
						<ul class="categories">
							<li>
								<span class="drilldown">&#9658;</span>Buddies (1/93)
								<ul class="buddy-list-members"><li data-user='docdion'>docdion (away)</li></ul>
							</li>
						</ul>
					</div>
					<div class="offline list">
						<ul>
							<li>Seriously? Go talk to the people online.</li>
						</ul>
					</div>
				</div>
			</div>

			<div id="chat-window" class="chat-window">
				<div class="aim-header light-blue-background">
					<h3></h3>
				</div>
				<div class="chat-contents">
					<div class="chat-screen">
						
					</div>
					<div class="tools">
						tools...
					</div>
					<textarea class="send-message" disabled="disabled"></textarea>
					<div class="chat-buttons flex space-between">
						<div class="flex justify-center" style="flex-grow:9999">
							<img src="<?php echo get_template_directory_uri(); ?>/img/i-info.png" style="height:40px;">
						</div>
						<div class="flex justify-center aim-send" style="width:75px;border-left: 1px solid #999;">
							<img src="<?php echo get_template_directory_uri();?>/img/send.png">
						</div>
					</div>
				</div>
			</div>

		</div>

	<?php $response = ob_get_clean();
	
	return $response;
}

add_shortcode('novelty-shoe', 'novelty_shoe');

function novelty_feed(){
	$discussion = get_posts(array('numberposts' => -1, 'post_type' => 'discussion', 'order' => 'ASC'));
	$response = array();
	foreach($discussion as $message){
		$sender = get_post_meta( $message->ID, 'wpcf-sender', TRUE);
		$seen = get_post_meta( $message->ID, 'wpcf-seen', TRUE);
		$response[$seen][] = array( 
			'message' => $message->post_content,
			'sender' => get_post_meta( $message->ID, 'wpcf-sender', TRUE),
			'clue' => get_post_meta( $message->ID, 'wpcf-has-clue', TRUE),
			'answer' => get_post_meta( $message->ID, 'wpcf-answer', TRUE),
			'seen' => get_post_meta( $message->ID, 'wpcf-seen', TRUE),
			'delay' => get_post_meta( $message->ID, 'wpcf-delay', TRUE ),
			'post' => $message->ID,
		);
	}
	$response = json_encode($response);
	echo $response;
	die();
}

add_action('wp_ajax_novelty_feed', 'novelty_feed');
add_action('wp_ajax_nopriv_novelty_feed', 'novelty_feed');

function novelty_update_seen(){
	$post_id = $_POST['post'];
	$response = update_post_meta( $post_id, 'wpcf-seen', 1 );
	echo $response;
	die();
}

add_action('wp_ajax_novelty_update_seen', 'novelty_update_seen');
add_action('wp_ajax_nopriv_novelty_update_seen', 'novelty_update_seen');

function novelty_reset_seen() {
	$discussion = get_posts(array('numberposts' => -1, 'post_type' => 'discussion', 'order' => 'ASC'));
	$results = array();
	foreach($discussion as $v){
		$results[] = update_post_meta($v->ID, 'wpcf-seen', 0);
	}
	$response = json_encode( $results );
	echo $response;
	die(); 
}

add_action('wp_ajax_novelty_reset_seen', 'novelty_reset_seen');
add_action('wp_ajax_nopriv_novelty_reset_seen', 'novelty_reset_seen');
