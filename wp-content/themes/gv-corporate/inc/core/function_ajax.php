<?php

/** GV Main Object */
function ajax_main_init(){  

    wp_register_script('ajax-main-script', get_template_directory_uri() . '/js/main.js', array('jquery') ); 

    wp_enqueue_script('ajax-main-script');

    wp_localize_script( 'ajax-main-script', 'Gv_Main_Object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('ajax-main-nonce'),
    ));

    add_action('wp_ajax_ajxloadproject', 'get_project_data');
	add_action('wp_ajax_nopriv_ajxloadproject', 'get_project_data');

	add_action('wp_ajax_ajaxloadpost', 'get_post_loading');
	add_action('wp_ajax_nopriv_ajaxloadpost', 'get_post_loading');
}
add_action('init', 'ajax_main_init');

/**
 * Get Project Data
 */
function get_project_data(){
	check_ajax_referer( 'ajax-main-nonce', 'security' );

	$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
	$new_offset = $offset + 12;

	$query = new WP_Query(array(
		'post_type' => 'project',
		'posts_per_page' => 12,
		'offset' => $offset,
		'orderby' => 'DESC',
	));

	$count = $query->post_count;
	$html = '';

	if($query->have_posts()) :
	while($query->have_posts()) : $query->the_post();
		$lpp_id = get_the_ID();
		$lpp_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
		$curLang = pll_current_language();
		switch ($curLang) {
			case 'en':
				$btn_more = 'See details';
				break;
			case 'ja':
				$btn_more = '詳細を見る';
				break;
			default:
				$btn_more = 'Xem chi tiết';
				break;
		}
		$html .= '<div class="col-md-4 col-lg-4 col-sm-6 project-item">';
		$html .= '<div class="project_inner">';
		$html .= '<div class="thumb">';
		$html .= '<a href="'. get_the_permalink($lpp_id) .'" title="'. get_the_title($lpp_id) .'">';
		$html .= '<img src="'. $lpp_thumb .'"/>';
		$html .= '</a></div>';
		$html .= '<div class="info">';
		$html .= '<h3 class="name">';
		$html .= '<a href="'. get_the_permalink($lpp_id) .'" title="'. get_the_title($lpp_id) .'">';
		$html .= get_the_title($lpp_id) .'</a></h3>';
		$html .= '<div class="desc">'. get_excerpt_custom(140) .'</div>';
		$html .= '<div class="more-x">';
		$html .= '<a href="'. get_the_permalink($lpp_id) .'">'. $btn_more .'<span><i></i></span></a>';
		$html .= '</div></div></div>';
		$html .= '</div>';
	endwhile; wp_reset_query();
	endif;

	if($count < 12){
		$status = false;
	}else{
		$status = true;
	}

	echo json_encode(
        array(
            'offset' => $new_offset,
            'result' => $html,
            'status' =>  $status,
        )
    );
	die();
}

/**
 * Get Post Loading
 */
function get_post_loading(){
	check_ajax_referer( 'ajax-main-nonce', 'security' );

	$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;
	$new_offset = $offset + 12;

	$query = new WP_Query(array(
		'post_type' => 'post',
		'posts_per_page' => 12,
		'offset' => $offset,
		'orderby' => 'DESC',
	));

	$count = $query->post_count;
	$html = '';

	if($query->have_posts()) :
	while($query->have_posts()) : $query->the_post();
		$lpp_id = get_the_ID();
		$lpp_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
		$curLang = pll_current_language();
		switch ($curLang) {
			case 'en':
				$lpp_date = get_the_date('d/m/Y, H:i');
				$btn_more = 'See details';
				$exp_desc = get_excerpt_word(33);
				break;
			case 'ja':
				$lpp_date = get_the_date('d/m/Y, H:i');
				$btn_more = 'さらに詳しく';
				$exp_desc = get_excerpt_word(75);
				break;
			default:
				$lpp_date = get_the_date('d/m/Y, H:i');
				$btn_more = 'Xem chi tiết';
				$exp_desc = get_excerpt_word(33);
				break;
		}
		$html .= '<article class="col-sm-12 col-12 col-md-6 col-lg-6 blog-item">';
		$html .= '<div class="blog_inner">';
		$html .= '<div class="thumb">';
		$html .= '<a href="'. get_the_permalink($lpp_id) .'" title="'. get_the_title($lpp_id) .'">';
		$html .= '<img src="'. $lpp_thumb .'"/>';
		$html .= '</a></div>';
		$html .= '<div class="info">';
		$html .= '<div class="date"><i></i>'. $lpp_date .'</div>';
		$html .= '<h3><a href="'. get_the_permalink($lpp_id) .'" title="'. get_the_title($lpp_id) .'">';
		$html .= get_the_title($lpp_id) .'</a></h3>';
		$html .= '<div class="desc">'. $exp_desc .'</div>';
		$html .= '</div></div>';
		$html .= '</article>';
	endwhile; wp_reset_query();
	endif;

	if($count < 12){
		$status = false;
	}else{
		$status = true;
	}

	echo json_encode(
        array(
            'offset' => $new_offset,
            'result' => $html,
            'status' =>  $status,
        )
    );
	die();
}