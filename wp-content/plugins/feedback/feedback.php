<?php

/**
 * @package feedback-plugin
 */

/* 
    Plugin Name: feedback
    Plugin URI: http://hamzagassai.me/plugin
    Description: My first plugin
    Version: 1.0.0
    Author: gassai hamza
    Author URI: https://github.com/ghamza-dev
    License: GPLv2 or later
    Text Domain: feedback-plugin

 */

global $message;

defined('ABSPATH') or die('Permission denied!');

class feedBackPlugin
{
    function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));
        add_shortcode('feedback-form', array($this, 'load_shortcode'));
    }

    function activate()
    {
        //generated a CPT
        $this->custom_post_type();

        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    function custom_post_type()
    {
        $arr = array(
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'capability' => 'manage_options',
            'labels' => array(
                'name' => 'feedback',
                'singular_name' => 'Feedback form',
            ),
            'menu_icon' => 'dashicons-feedback',
        );
        register_post_type('feedBackPlugin', $arr);
    }

    public function load_assets()
    {
        wp_enqueue_style(
            'feedBackPlugin',
            plugin_dir_url(__FILE__) . 'css/style.css',
            array(),
            1,
            'all'
        );
        wp_enqueue_script(
            'cosmic-plugin',
            plugin_dir_url(__FILE__) . 'js/script.js',
            array(),
            1,
            'all'
        );
    }

    public function sendFeedBack()
    {
        global $wpdb;

        $name = $_POST['name'];
        $rating = $_POST['rating'];
        $review = $_POST['Review'];
        $id = $_POST['id'];
        $wpdb->insert('wp_ffeedback', array('Name' => $name, 'Rating' => $rating, 'Review' => $review, 'post_id' => $id));
        echo " <script> Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
          ) </script>";

        header('refresh:0', 'Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function load_shortcode()
    {
        require_once 'form.php';
    }
}

if (class_exists('feedBackPlugin')) {
    $feedBackPlugin = new feedBackPlugin();
}

//activation
register_activation_hook(__FILE__, array($feedBackPlugin, 'activate'));
//deactivation
register_deactivation_hook(__FILE__, array($feedBackPlugin, 'deactivate'));


if (isset($_POST['submit'])) {
    $feedBackPlugin->sendFeedBack();
}
