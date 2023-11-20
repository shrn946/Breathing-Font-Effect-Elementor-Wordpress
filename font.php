<?php
/*
Plugin Name: Breathing Font Effect Elementor
Description: This plugin offers a Font Breathing shortcode with the option to include a label.
Version: 1.0
Author: Hassan Naqvi


*/

// Counter for unique class names
$font_breathing_counter = 0;

// Register the plugin settings
function font_breathing_register_settings() {
    add_option('font_breathing_video_url', '');
    register_setting('font_breathing_options_group', 'font_breathing_video_url');
}

// Create the plugin menu
function font_breathing_menu() {
    add_menu_page('Breathing Font Effect Elementor', 'Font Breathing', 'manage_options', 'font-breathing-options', 'font_breathing_options_page');
}

// Enqueue scripts and styles for the Font Breathing plugin
function font_breathing_enqueue_scripts() {
    // Enqueue Font Breathing script
    wp_enqueue_script('font-breathing-script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'), null, true);

    // Enqueue Font Breathing stylesheet
    wp_enqueue_style('font-breathing-style', plugin_dir_url(__FILE__) . 'style.css');
}

// Hook to register settings, enqueue scripts and styles, and create menu
add_action('admin_init', 'font_breathing_register_settings');
add_action('wp_enqueue_scripts', 'font_breathing_enqueue_scripts');
add_action('admin_menu', 'font_breathing_menu');

// Display the plugin options page
function font_breathing_options_page() {
    ?>
    <div class="wrap">
        <h2>Font Breathing Plugin Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields('font_breathing_options_group'); ?>
            <?php do_settings_sections('font_breathing_options_group'); ?>
         

        <h2>How to Use</h2>
        <p>Use the following shortcode to apply the Font Breathing effect to your WordPress content; you can utilize it in the Elementor Editor. </p>
        <code>[font-breathing label="Light Your Night"]

</code>

        <h2>Video Tutorial</h2>
        <p>Watch the video tutorial below to learn more about using the Font Breathing plugin:</p>
        
        <iframe width="560" height="315" src="https://www.youtube.com/embed/VznIoEBio9c?si=luULdQ9WP_yed5YQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    
    </div>
    <?php
}

// Font Breathing Shortcode
function font_breathing_shortcode($atts) {
    global $font_breathing_counter;
    $font_breathing_counter++;

    $atts = shortcode_atts(
        array(
            'label' => 'Geist Sans', // Default label text
        ),
        $atts,
        'font-breathing'
    );

    // Generate a unique class based on the label text
    $unique_class = 'font-breathing-label-' . sanitize_title($atts['label']) . '-' . $font_breathing_counter;

    ob_start();
    ?>
    <style>
        @font-face {
            font-family: "Geist";
            src: url('<?php echo plugins_url('/font/GeistVF.woff2', __FILE__); ?>') format('woff2');
        }

        .font-con p {
            /* Your styles here */
            font-family: "Geist", sans-serif; /* Use the defined font-family */
        }
    </style>

    <div class="font-con">
<p class="label-<?php echo $font_breathing_counter; ?>" aria-label="<?php echo esc_attr($atts['label']); ?>">



            <?php
            $label_chars = str_split($atts['label']);
            foreach ($label_chars as $char) {
                echo '<span aria-hidden="true">' . esc_html($char) . '</span>';
            }
            ?>
        </p>
    </div>
    <?php
    return ob_get_clean();
}

// Register the Font Breathing shortcode
add_shortcode('font-breathing', 'font_breathing_shortcode');
?>
