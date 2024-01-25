<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Educenter
 * @subpackage SparkEducation
 *
 */

?>

	</div><!-- #content -->

	<?php

		do_action( 'educenter_footer_before');

			/**
			 * @see  educenter_footer_widget_area() - 10
			*/
			remove_action( 'educenter_footer_widget', 'educenter_footer_widget_area', 10 );


			/**
			 * @see  sparkeducation_footer_widget_area() - 9
			*/
			do_action( 'sparkeducation_footer_widget');

	    	/**
	    	 * Button Footer Area
	    	   * @see  educenter_copyright() - 5
	    	*/
	    	do_action( 'educenter_button_footer'); 
	    
	    do_action( 'educenter_footer_after');

	?><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>