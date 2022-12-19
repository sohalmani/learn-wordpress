<?php

function custom_search_api() {
    register_rest_route('university/v1', 'search', array(
        'method' => WP_REST_Server::READABLE,
        'callback' => 'fetch_search_api_result',
    ));
}

function fetch_search_api_result($data) {
   $professor = new WP_Query(array(
       'posts_per_page' => '-1',
       'post_type' => 'professor',
       's' => $data['term']
   ));

   $professor_results = array();

   while ($professor->have_posts()) {
       $professor->the_post();
       array_push($professor_results, array(
           'title' => get_the_title(),
           'permalink' => get_the_permalink(),
       ));
   }
   return $professor_results;
}

add_action('rest_api_init', 'custom_search_api');