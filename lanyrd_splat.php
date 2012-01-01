<?php
/*
Plugin Name: Lanyrd Splat Widget
Plugin URI: http://gingerbreaddesign.co.uk/wordpress/lanyrd-splat-widget/
Description: Simple Lanyrd Badge Splat Widget 
Author: Todd Halfpenny
Version: 0.0.1
Author URI: gingerbreaddesign.co.uk/todd
*/


/**
 * lanyrdSplat Class
 */
class lanyrdSplat extends WP_Widget {
    /** constructor */
    function lanyrdSplat() {
	$lanyrd_splat_widget_ops = array(
		'description' => 'Displays upcoming lanyrd events you\'re attending'
		);
        parent::WP_Widget( 'lanyrdSplat',  'Lanyrd Splat', $lanyrd_splat_widget_ops );
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', 'Events I\'m attending' );
	$lanyrd_user = esc_attr( $instance['lanyrd_user'] );
	$num_events = esc_attr( $instance['num_events'] );
	$lanyrd_template = esc_attr( $instance['lanyrd_template'] );
	$contents = '<div class="lanyrd-target-splat"><a href="http://lanyrd.com/profile/' . $lanyrd_user . '/" class="lanyrd-splat lanyrd-number-' . $num_events . ' lanyrd-context-future lanyrd-template-' . $lanyrd_template .'" rel="me"></a></div>';
	
	wp_enqueue_script( 'lanyrd_badge_script', 'http://cdn.lanyrd.net/badges/person-v1.min.js' );
        
	if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
	echo $before_widget;
	if ( $contents ) echo $before_title . $contents . $after_title;
	echo $after_widget;
	
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['lanyrd_user'] = strip_tags( $new_instance['lanyrd_user'] );
	$instance['num_events'] = strip_tags( $new_instance['num_events'] );
	$instance['lanyrd_template'] = strip_tags( $new_instance['lanyrd_template'] );
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
	$defaults = array(
		'title'                    => '',
		'lanyrd_user'        => '',
		'num_events'       => 0,
		'lanyrd_template' => 'standard'
		);
	$instance = wp_parse_args( (array) $instance, $defaults );
        $lanyrd_user = esc_attr( $instance['lanyrd_user'] );
	$num_events = esc_attr( $instance['num_events'] );
	$lanyrd_template = esc_attr( $instance['lanyrd_template'] );
        ?>
         <p>
          <label for="<?php echo $this->get_field_id( 'lanyrd_user' ); ?>"><?php _e('Lanyrd Username:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'lanyrd_user' ); ?>" name="<?php echo $this->get_field_name('lanyrd_user'); ?>" type="text" value="<?php echo $lanyrd_user; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id( 'num_events' ); ?>"><?php _e('Num of events to show:'); ?></label> 
	  <select id="<?php echo $this->get_field_id( 'num_events' ); ?>"  name ="<?php echo $this->get_field_name('num_events'); ?>">
	<?
	$num_arr = array( 1,2,3,4,5 );
	foreach ($num_arr as $i => $value) {
		echo '<option value="'. $value . '"';
		if ( $value == $num_events ) echo ' selected ';
		echo '>' . $value . '</option>';
	}
	?>
	</select>
	</p>
         <p>
          <label for="<?php echo $this->get_field_id( 'lanyrd_template' ); ?>"><?php _e('Template'); ?> <a href='http://lanyrd.com/services/badges/docs/#content-splat'>(more info)</a></label> 
	  <select id="<?php echo $this->get_field_id( 'lanyrd_template' ); ?>"  name ="<?php echo $this->get_field_name( 'lanyrd_template' ); ?>">
	<?
	$template_arr = array( 'compact', 'mini', 'standard', 'detailed' );
	foreach ($template_arr as $i => $template_value) {
		echo '<option value="'. $template_value . '"';
		if ( $template_value == $lanyrd_template ) echo ' selected ';
		echo '>' . $template_value . '</option>';
	}
	?>
	</select>
	</p>
        <?php 
    }

} // class lanyrdSplat


// register lanyrdSplat widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "lanyrdSplat" );' ) );

?>