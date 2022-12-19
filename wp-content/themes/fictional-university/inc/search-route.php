<?php

function custom_search_api() {
    register_rest_route('university/v1', 'search', array(
        'method' => WP_REST_Server::READABLE,
        'callback' => 'fetch_search_api_result',
    ));
}

function fetch_search_api_result($data) {
   $all_posts = new WP_Query(array(
       'posts_per_page' => '-1',
       'post_type' => array('post', 'page', 'professor', 'event', 'program'),
       's' => sanitize_text_field($data['term']),
   ));

   $final_results = array(
       'general_info' => array(),
       'events' => array(),
       'professors' => array(),
       'programs' => array(),
   );

   while ($all_posts->have_posts()) {
       $all_posts->the_post();

       switch (get_post_type()) {
           case 'post':
               array_push($final_results['general_info'], array(
                   'title' => get_the_title(),
                   'permalink' => get_the_permalink(),
               ));
               break;

           case 'page':
               array_push($final_results['general_info'], array(
                   'title' => get_the_title(),
                   'permalink' => get_the_permalink(),
               ));
               break;

           case 'event':
               array_push($final_results['events'], array(
                   'title' => get_the_title(),
                   'permalink' => get_the_permalink(),
               ));
               break;

           case 'professor':
               array_push($final_results['professors'], array(
                   'title' => get_the_title(),
                   'permalink' => get_the_permalink(),
               ));
               break;

           case 'program':
               array_push($final_results['programs'], array(
                   'title' => get_the_title(),
                   'permalink' => get_the_permalink(),
               ));
               break;

           default:
               break;
       }
   }

   return $final_results;
}

add_action('rest_api_init', 'custom_search_api');