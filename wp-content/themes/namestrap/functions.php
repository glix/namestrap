<?php 
	function namestrap_setup(){
		register_nav_menus(
		    array('primary'=>_('Primary Menu'))
		);
    }
    /* add post-thumbnails*/
    if ( function_exists( 'add_theme_support' ) ) 
    	add_theme_support( 'post-thumbnails');
    
    if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'category-thumb', 200 ); 
    }
    /*register_sidebar widgets*/
    if ( function_exists('register_sidebars') ) {
		register_sidebar(array('name'=>'Sidebar 1',));
        register_sidebar(array('name'=>'Footer Column 1',));
        register_sidebar(array('name'=>'Footer Column 2',));
        register_sidebar(array('name'=>'Footer Column 3',));
        register_sidebar(array('name'=>'Footer Column 4',));
        register_sidebar(array('name'=>'Left Sidebar'));
    }
    add_action( 'init', 'namestrap_setup' );

    add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
    function title_like_posts_where( $where, &$wp_query ) {
        global $wpdb;
        if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( like_escape( $post_title_like ) ) . '%\'';
        }
        return $where;
    }

    add_filter( 'posts_where', 'title_charaters_count_where', 10, 2 );
    function title_charaters_count_where( $where, &$wp_query ) {
        global $wpdb;
        if ( $post_title_charaters = $wp_query->get( 'post_title_charaters' ) ) {
            $where .= ' AND CHAR_LENGTH(' . $wpdb->posts . '.post_title) <='. esc_sql(like_escape($post_title_charaters));
        }
        return $where;
    }

    function filter_domains(){
        if(!empty($_POST)){
            $curpage = get_query_var('paged') ? get_query_var('paged') : 1;
            if(isset($_POST['paged']) && !empty($_POST['paged'])){
                $paged = $_POST['paged'];
            }
            $args = array(
                'post_type' => 'domain',
                'paged' => $paged,
                'posts_per_page' => PAGINATION_LIMIT,
            );
            $search_args = array();
            if(isset($_POST['s']) && !empty($_POST['s'])){
                $args['post_title_like'] = $_POST['s'];  
            }

            if(isset($_POST['category']) && !empty($_POST['category'])){
                    $arg = array('tax_query' => array(
                        array(
                            'taxonomy' => 'domain-category',
                            'field' => 'term_id',
                            'terms' => $_POST['category']
                        )
                    ));
                    $args = array_merge($args,$arg);
            }
            if(isset($_POST['dLength']) && !empty($_POST['dLength']) && $_POST['dLength'] != 1){
                    // $arg = array('tax_query' => array(
                    //     array(
                    //         'taxonomy' => 'domains-cat',
                    //         'field' => 'slug',
                    //         'terms' => $_POST['dLength'].'-letter'
                    //     )
                    // ));
                    $args['post_title_charaters'] = $_POST['dLength'];
                    //$args = array_merge($args,$arg);
                }

            if(isset($_POST['minRange']) && isset($_POST['maxRange']) && !empty($_POST['minRange']) && !empty($_POST['maxRange'])){
                if($_POST['minRange'] == 100){
                    $arg = array('meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                               'key' => 'price',
                               'value' => '',
                            ),
                            array(
                               'key' => 'price',
                               'value' => $_POST['minRange'],
                               'compare' => '>=',
                            ),
                        ),
                        array(
                           'key' => 'price',
                           'value' => $_POST['maxRange'],
                           'compare' => '<=',
                        )
                    ));    
                }else{
                    $arg = array('meta_query' => array(
                        'relation' => 'AND',
                        array(
                           'key' => 'price',
                           'value' => $_POST['minRange'],
                           'compare' => '>=',
                        ),
                        array(
                           'key' => 'price',
                           'value' => $_POST['maxRange'],
                           'compare' => '<=',
                        )
                    ));
                }     
                
                $args = array_merge($args,$arg);
            }

            if(isset($_POST['sortby']) && !empty($_POST['sortby'])){
                $order_arg = array();
                switch ($_POST['sortby']) {
                    case 'titleAsc':
                        $order_arg['orderby'] = 'title';
                        $order_arg['order'] = 'ASC';
                        break;

                    case 'titleDesc':
                        $order_arg['orderby'] = 'title';
                        $order_arg['order'] = 'DESC';
                        break;

                    case 'dateAsc':
                        $order_arg['orderby'] = 'date';
                        $order_arg['order'] = 'ASC';
                        break;
                    
                    case 'priceDesc':
                        $order_arg['orderby'] = 'meta_value';
                        $order_arg['meta_key'] = 'price';
                        $order_arg['order'] = 'DESC';
                        break;

                    case 'priceAsc':
                        $order_arg['orderby'] = 'meta_value';
                        $order_arg['meta_key'] = 'price';
                        $order_arg['order'] = 'ASC';
                        break;

                    default:
                        $order_arg['orderby'] = 'date';
                        $order_arg['order'] = 'DESC';
                        break;
                }
                $args = array_merge($args,$order_arg);
            }

            $wp_query = new WP_Query($args);
            $page = get_page_by_path('inquire-about-a-domain');
            $enquiry_page = $page->ID;
            $ret = "";
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $price = get_post_meta(get_the_ID(),'price',true);
                $term_list = wp_get_post_terms(get_the_ID(), 'domaintype', array("fields" => "ids"));
                $ret .= '<div class="col-xs-4">';
                $ret .= '<div class="domain-section">';
                $ret .= '<article>';
                $ret .= '<h3>'.strtolower(get_the_title()).'</h3>';
                $ret .= '<div class="btn_section">';
                $ret .= '<div class="left-section">';
                $buyButton = "Buy now"; if(!empty($price)) { $buyButton = "Buy now at $".$price; }
                $ret .= '<a class="btn btn-default btn-xs custom-btn-style" href="#">'.$buyButton.'</a>';
                $ret .= '</div>';
                $ret .= '<div class="right-section">';
                $ret .= '<a href="'.home_url().'?page_id='.$enquiry_page.'&d='.get_the_ID().'" class="btn btn-default btn-xs custom-btn-style">Submit offer</a>';
                $ret .= '</div></div></article></div></div>';
            endwhile;

            $pagedUrl = home_url().'?paged=';
            $ret .= '<div class="col-xs-12 text-right pagination_wrapper no-padding">';
            $ret .= '<div id="wp_pagination" class="ajax_pagination">';
            $prev_num = ($curpage-1 > 0 ? $curpage-1 : 1);
            $ret .= '<a class="previous page button" data-page="'.$prev_num.'" href="'.$pagedUrl.($prev_num).'">&lsaquo;</a> ';
            for($i=1;$i<=$wp_query->max_num_pages;$i++)
            {
                $ret .= '<a class="'.($active = ($i == $paged) ? 'active ' : '').'page button" data-page="'.$i.'" href="'.$pagedUrl.($i).'">'.$i.'</a> ';
            }
            $next_num = ($curpage+1 <= $wp_query->max_num_pages ? $curpage+1 : $wp_query->max_num_pages);
            $ret .= '<a class="next page button" data-page="'.$next_num.'" href="'.$pagedUrl.($next_num).'">&rsaquo;</a> ';
            $ret .= '</div>';
            $ret .= '</div>';
            die($ret);
        }
    }

    add_action( 'wp_ajax_filter_domains', 'filter_domains' );
    add_action( 'wp_ajax_nopriv_filter_domains', 'filter_domains' );


?>