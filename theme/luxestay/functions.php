<?php
if(!defined('ABSPATH'))exit;
add_action('after_setup_theme',function(){add_theme_support('title-tag');add_theme_support('post-thumbnails');});
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('luxestay',get_stylesheet_uri(),array(),'1.0.0');wp_enqueue_script('luxestay',get_template_directory_uri().'/app.js',array(),'1.0.0',true);});
add_action('wp_head',function(){if(!has_site_icon())echo '<link rel="icon" type="image/svg+xml" href="'.esc_url(get_template_directory_uri().'/favicon.svg').'">';});
function luxe_asset($name){return esc_url(get_template_directory_uri().'/'.$name);}
function luxe_rooms(){return array(array('Garden Deluxe','A restful retreat with a king bed and a private garden outlook.',180,2,'room1.webp'),array('Horizon Suite','A spacious suite with panoramic views and an intimate lounge.',320,3,'room2.webp'),array('Private Residence','A refined retreat for families and groups, with generous living space.',550,5,'room3.webp'));}
add_action('init',function(){register_post_type('luxe_room',array('label'=>'Rooms and suites','public'=>true,'show_in_rest'=>true,'supports'=>array('title','editor','thumbnail'),'menu_icon'=>'dashicons-building'));});
add_action('after_switch_theme',function(){if(get_option('luxe_seeded'))return;foreach(luxe_rooms() as $r){$id=wp_insert_post(array('post_type'=>'luxe_room','post_title'=>$r[0],'post_content'=>$r[1],'post_status'=>'publish'),true);if(!is_wp_error($id)){update_post_meta($id,'luxe_rate',$r[2]);update_post_meta($id,'luxe_capacity',$r[3]);update_post_meta($id,'luxe_photo',$r[4]);}}update_option('luxe_seeded',1);flush_rewrite_rules();});
