<?php

function fetch_search_api_result($data)
{
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
                    'postType' => get_post_type(),
                    'author_name' => get_the_author(),
                ));
                break;

            case 'page':
                array_push($final_results['general_info'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'postType' => get_post_type(),
                ));
                break;

            case 'event':
                $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 15);

                array_push($final_results['events'], array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'description' => $description,
                    'permalink' => get_the_permalink(),
                    'month' => get_date(get_field('event_date'), 'M'),
                    'day' => get_date(get_field('event_date'), 'd'),
                ));
                break;

            case 'professor':
                array_push($final_results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professor-landscape'),
                ));
                break;

            case 'program':
                array_push($final_results['programs'], array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                ));
                break;

            default:
                break;
        }
    }

    if ($final_results['programs']) {
        $relationship_meta_query = array('relation' => 'OR');

        foreach ($final_results['programs'] as $program) {
            array_push($relationship_meta_query, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $program['id'] . '"',
            ));
        }

        $related_professors_and_events = new Wp_Query(array(
            'posts_per_page' => -1,
            'post_type' => array('professor', 'event'),
            'meta_query' => $relationship_meta_query,
        ));

        while ($related_professors_and_events->have_posts()) {
            $related_professors_and_events->the_post();

            if (get_post_type() === 'professor') {
                array_push($final_results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professor-landscape'),
                ));
            }

            if (get_post_type() === 'event') {
                $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 15);

                array_push($final_results['events'], array(
                    'title' => get_the_title(),
                    'description' => $description,
                    'permalink' => get_the_permalink(),
                    'month' => get_date(get_field('event_date'), 'M'),
                    'day' => get_date(get_field('event_date'), 'd'),
                ));
            }
        }

        $final_results['professors'] = array_values(array_unique($final_results['professors'], SORT_REGULAR));
        $final_results['events'] = array_values(array_unique($final_results['events'], SORT_REGULAR));
    }

    return $final_results;
}

function custom_search_api()
{
    register_rest_route('university/v1', 'search', array(
        'method' => WP_REST_Server::READABLE,
        'callback' => 'fetch_search_api_result',
    ));
}

add_action('rest_api_init', 'custom_search_api');