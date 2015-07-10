<?php 

if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name' => '側邊欄',
		'id' => 'sidebar',
		'description' => '顯示於每個網頁的右方。',
		'before_widget' => '<section id="%1$s" class="sidebar-right">',
		'after_widget' => '</section>',
		'before_title' => '<h1 class="sidebar-title">',
		'after_title' => '</h1>'
	));
}


register_nav_menus(
	array(
		'primary-menu' => __( '主選單' )
	)
);

function wp_pagenavi() {
	global $wp_query;
	$max = $wp_query->max_num_pages;
	if ( !$current = get_query_var('paged') ) $current = 1;
	$args['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
	$args['total'] = $max;
	$args['current'] = $current;
	$args['prev_text'] = '<';
	$args['next_text'] = '>';
	if ( $max > 1 ){ $pages = '<div class="wp-pagenavi"><span class="pages">共 ' . $max . ' 頁</span>';
		echo $pages . paginate_links($args) . '</div>';}
}


if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name' => '側邊欄',
		'id' => 'sidebar',
		'description' => '顯示於每個網頁的右方。',
		'before_widget' => '<section id="%1$s" class="sidebar-right">',
		'after_widget' => '</section>',
		'before_title' => '<h1 class="sidebar-title">',
		'after_title' => '</h1>'
	));
}


function displaycomments($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
?>
<li class="comment-list-box">
	<div class="comment-author">
		<?php echo get_avatar( $comment, 40 ); ?>
	</div>
	<div class="comment-fn">
		<?php printf(__('<span class="fn">%s</span>'), get_comment_author_link()) ?>
	</div>
	<div class="comment-meta">
		<?php printf(__('%1$s @ %2$s'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link() ?>
	</div>
	<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-approved">你的迴響正在審核中。</em>
	<?php endif;?>
	<?php comment_text() ?>
	<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
<?php }


function breadcrumb_init(){
	global $post;
?>
	<ul class="breadcrumb">
		<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<a href="<?php bloginfo('url');?>" itemprop="url" title="<?php bloginfo('name');?>">
			<span itemprop="title"><?php bloginfo('name');?></span></a> 
		</li>
		<?php
		if( is_single() ) {
			foreach ( get_the_category() as $category) {
				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
				echo '<span class="divider">›</span> <a href="' . get_category_link($category -> term_id) . '" itemprop="url" title=' . $category -> cat_name . '> <span itemprop="title">' . $category -> cat_name . '</span> </a>';
				echo '</li>';
			}
		} else { ?>
		<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="active">
			<span class="divider">›</span> 
			<span itemprop="title">
			<?php
			if ( is_category() ) {
				echo single_cat_title();
			} elseif ( is_tag() ) {
				echo single_tag_title( '', true);
			} elseif ( is_day() ) {
				the_time( get_option('date_format') );
			} elseif ( is_month() ) {
				the_time( 'F, Y' );
			} elseif ( is_year() ) {
				the_time( 'Y' );
			} elseif ( is_page() ) {
				the_title();
			} ?></span>
		</li>
		<?php } ?>
	</ul>
<?php
}

function add_user_porfile( $contactmethods ) {
	$contactmethods['google'] = 'Google+ 個人網址';
	$contactmethods['facebook'] = 'Facebook 個人網址';
	$contactmethods['description_url'] = '個人介紹頁';
	return $contactmethods;
}
add_filter('user_contactmethods','add_user_porfile',10,1);


function article_author(){
	global $post;
?>
	<section class="article-author">
		<div class="author-avatar"><?php echo get_avatar( get_the_author_meta('ID'), 100);?></div>
		<div class="author-text">
			<h3 class="author-name"><?php the_author();?></h3>	
			<p class="author-description"><?php the_author_meta('description');?></p>
			<div class="author-social">
				<?php if ( get_the_author_meta( 'google' ) ): ?>
					<a href="<?php the_author_meta('google');?>?rel=author" title="我的 Google+">Google+</a>
				<?php endif; if ( get_the_author_meta( 'facebook' ) ): ?>
					 | <a href="<?php the_author_meta('facebook');?>" title="我的 Facebook">Facebook</a>
				<?php endif; if ( get_the_author_meta( 'description_url' ) ): ?>
					 | <a href="<?php the_author_meta('description_url');?>" title="<?php the_author();?> 個人介紹">個人介紹</a><?php endif;?>
			</div>				
		</div>
	</section>
<?php
}

if ( function_exists( 'add_theme_support'  ) ) {
    add_theme_support( 'post-thumbnails' );
}

function get_feature_image(){
	global $post, $posts;
	$first_img = '';
	if (has_post_thumbnail()){
		$first_img  = wp_get_attachment_url( get_post_thumbnail_id() );
	} else {
		ob_start();
		ob_end_clean();
		$output = preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $post->post_content, $matches);
		$first_img = $matches[1];
	}
	return $first_img;
}

function insert_fb_in_head() {
	global $post;
	if ( is_home() ) {
		echo '<meta property="fb:admins" content="管理員的 Facebook 帳號 ID" />';
		echo "\n";
        echo '<meta property="fb:app_id" content="網站 Facebook APP 的 ID" />';
		echo "\n";
        echo '<meta property="og:type" content="website"/>';
		echo "\n";
        echo '<meta property="og:title" content="' . get_bloginfo('name') . '"/>';
		echo "\n";
        echo '<meta property="og:description" content="' . get_bloginfo('description'). '"/>';
		echo "\n";
        echo '<meta property="og:url" content="' . get_bloginfo('url'). '"/>';
		echo "\n";
        echo '<meta property="og:site_name" content="'. get_bloginfo('name'). '"/>';
		echo "\n";
		echo '<meta property="og:locale" content="zh_tw">';
		echo "\n";
	}
	if ( !is_singular() ) return;
	$post_excerpt =  ( $post->post_excerpt ) ? $post->post_excerpt : trim( str_replace( "\r\n", ' ', strip_tags( $post->post_content ) ) );
	$description = mb_substr( $post_excerpt, 0, 160, 'UTF-8' );
	$description .= ( mb_strlen( $post_excerpt, 'UTF-8' ) > 160 ) ? '…' : '';
        echo "\n";
		echo '<meta property="fb:admins" content="管理員的 Facebook 帳號 ID" />';
		echo "\n";
        echo '<meta property="fb:app_id" content="網站 Facebook APP 的 ID" />';
		echo "\n";
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
		echo "\n";
        echo '<meta property="og:description" content="' . $description . '"/>';
		echo "\n";
        echo '<meta property="og:type" content="article"/>';
		echo "\n";
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
		echo "\n";
        echo '<meta property="og:site_name" content="' . get_bloginfo('name'). '"/>';
		echo "\n";
		echo '<meta property="og:image" content="'.$img.'" />' ;
		echo "\n";
		echo '<link rel="image_src" type="image/jpeg" href="'.get_feature_image().'" />' ;
		echo "\n";
		echo '<meta property="og:locale" content="zh_tw">';
		echo "\n";
}
add_action( 'wp_head', 'insert_fb_in_head', 10 );

register_sidebar(array(
	'name' => 'footerfield1',
	'id' => 'footer-1',
	'description' => 'First footer widget area',
	'before_widget' => '<div id="footer-widget1″>',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));
register_sidebar(array(
	'name' => 'footerfield2',
	'id' => 'footer-2',
	'description' => 'Second footer widget area',
	'before_widget' => '<div id="footer-widget2″>',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));
register_sidebar(array(
	'name' => 'footerfield3',
	'id' => 'footer-3',
	'description' => 'Third footer widget area',
	'before_widget' => '<div id="footer-widget3″>',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

function wps_change_role_name() {
  global $wp_roles;
  if ( ! isset( $wp_roles ) )
   $wp_roles = new WP_Roles();
  $wp_roles->roles['longcare']['name'] = '長照單位';
  $wp_roles->role_names['longcare'] = '長照單位';
  
   $wp_roles->roles['guest']['name'] = '一般使用者';
  $wp_roles->role_names['guest'] = '一般使用者';
}
add_action('init', 'wps_change_role_name');


// Add Password, Repeat Password and Are You Human fields to WordPress registration form
// http://wp.me/p1Ehkq-gn

add_action( 'register_form', 'ts_show_extra_register_fields' );
function ts_show_extra_register_fields(){
?>
	<p>
		<label for="password">Password<br/>
		<input id="password" class="input" type="password" tabindex="30" size="25" value="" name="password" />
		</label>
	</p>
	<p>
		<label for="repeat_password">Repeat password<br/>
		<input id="repeat_password" class="input" type="password" tabindex="40" size="25" value="" name="repeat_password" />
		</label>
	</p>
<?php
}

// Check the form for errors
add_action( 'register_post', 'ts_check_extra_register_fields', 10, 3 );
function ts_check_extra_register_fields($login, $email, $errors) {
	if ( $_POST['password'] !== $_POST['repeat_password'] ) {
		$errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
	}
	if ( strlen( $_POST['password'] ) < 8 ) {
		$errors->add( 'password_too_short', "<strong>ERROR</strong>: Passwords must be at least eight characters long" );
	}
}
?>

<?php
// Storing WordPress user-selected password into database on registration
// http://wp.me/p1Ehkq-gn

add_action( 'user_register', 'ts_register_extra_fields', 100 );
function ts_register_extra_fields( $user_id ){
	$userdata = array();

	$userdata['ID'] = $user_id;
	if ( $_POST['password'] !== '' ) {
		$userdata['user_pass'] = $_POST['password'];
	}
	$new_user_id = wp_update_user( $userdata );
}
?>

<?php
// Editing WordPress registration confirmation message
// http://wp.me/p1Ehkq-gn

add_filter( 'gettext', 'ts_edit_password_email_text' );
function ts_edit_password_email_text ( $text ) {
	if ( $text == 'A password will be e-mailed to you.' ) {
		$text = 'If you leave password fields empty one will be generated for you. Password must be at least eight characters long.';
	}
	return $text;
}

add_action( 'wp_ajax_my_ajax_action', 'ajax_action_stuff' ); // 針對已登入的使用者
add_action( 'wp_ajax_nopriv_my_ajax_action', 'ajax_action_stuff' ); // 針對未登入的使用者
function ajax_action_stuff() {
	$post_id = $_POST['post_id']; // 從ajax POST的請求取得的參數資料
	echo $post_id; // 單純的印出來，如此前端就會收到
	die(); // 一定要加這行，才會完整的處理ajax請求
}


function add_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
	wp_enqueue_script( 'jquery' );
}
 
add_action('wp_enqueue_scripts', 'add_scripts');

?>