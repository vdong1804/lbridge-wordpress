<?php

if( !class_exists( 'MyAPI' ) ) {
    class MyAPI {
        function __construct() {
            add_action( 'rest_api_init', [$this, 'init'] );
        }
        function init() {
            register_rest_route( 'api-wp/v1', '/posts', [
                'methods' => 'GET',
                'callback' => [$this, 'get_lists'],
                'permission_callback' => '__return_true',
            ] );
            
        }
        // Get recent projects

        

        function get_lists( $request ) {
            $number = 10;

            if(count($request->get_params()) > 0){
                if($request->get_params('title') && $request->get_params('paged')){
                    $posts =  get_posts( [
                        'post_type' => 'post',
                        's' => isset($_REQUEST['title']) ? $_REQUEST['title'] : '',
                        'posts_per_page' => $number,
                        'paged' => isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1
                    ] );
                }elseif($request->get_params('title')){
                    $posts =  get_posts( [
                        'post_type' => 'post',
                        's' => isset($_REQUEST['title']) ? $_REQUEST['title'] : '',
                        'posts_per_page' => $number,
                    ] );
                }elseif($request->get_params('paged')){
                    $posts =  get_posts( [
                        'post_type' => 'post',
                        'posts_per_page' => $number,
                        'orderby' => 'DESC',
                        'paged' => isset($_REQUEST['paged']) ? $_REQUEST['paged'] : 1
                    ] );
                }else{
                    $posts =  get_posts( [
                        'post_type' => 'post',
                        'posts_per_page' =>  $number,
                        'orderby' => 'DESC',
                    ] );
                }
            }else{
                $posts =  get_posts( [
                    'post_type' => 'post',
                    'posts_per_page' =>  $number,
                    'orderby' => 'DESC',
                ] );
            }

            $data = array();
            if($posts){
                foreach( $posts as $pst ) {
                    $data[] = array(
                        'title' => get_the_title($pst->ID),
                        'date' => get_the_date('d/m/Y', $pst->ID),
                        'thumb' => get_the_post_thumbnail_url($pst->ID),
                        'link' => get_the_permalink($pst->ID)
                    );
                }
            }
            return $data;
        }
    }
    new MyAPI();
}

/**
 * Get Post Related
 */
function get_news_related($id, $taxonomy, $number){
    $terms = get_the_terms($id, $taxonomy, 'string');
    $term_ids = wp_list_pluck($terms, 'term_id');

    $query = new WP_Query(array(
        'post_type' => 'post',
        'tax_query' => array( array(
            'taxonomy' => $taxonomy,
            'field' => 'id',
            'terms' => $term_ids,
            'operator' => 'IN'
        )),
        'posts_per_page' => $number,
        'ignore_sticky_posts' => 1,
        'orderby' => 'DESC',
        'post__not_in' => array($id)
    ));
    return $query;
}

