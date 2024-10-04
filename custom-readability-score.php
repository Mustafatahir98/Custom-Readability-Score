<?php
/*
Plugin Name: Custom Readability Score
Plugin URI: http://personaldrivers.com/custom-readability-score
Description: This plugin calculates and displays readability score for posts and pages in the admin bar.
Version: 1.0
Author: Mustafa Tahir
Author URI: http://personaldrivers.com
*/

include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/Text.php');
include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/Maths.php');
include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/Pluralise.php');
include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/Resource.php');
include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/Syllables.php');
include_once(plugin_dir_path(__FILE__) . 'Text-Statistics-master/src/DaveChild/TextStatistics/TextStatistics.php');



function calculate_readability_score($content) {
    $textStatistics = new DaveChild\TextStatistics\TextStatistics;
    $fleschKincaidReadingEase = $textStatistics->fleschKincaidReadingEase($content);
    return round($fleschKincaidReadingEase, 2);
}
add_action('admin_bar_menu', 'add_readability_score_to_admin_bar', 100);

function add_readability_score_to_admin_bar($wp_admin_bar) {
    if (is_admin() || !is_single() && !is_page()) {
        return;
    }

    global $post;
    $score = calculate_readability_score($post->post_content);

    $args = array(
        'id'    => 'readability-score',
        'title' => 'Readability Score: ' . $score,
        'href'  => false
    );
    $wp_admin_bar->add_node($args);
}


?>