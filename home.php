<?php
	$theme_url = $Enthusiast->theme_information[ 'ThemeURL' ];
	get_header();
?>

	<div class="home-top-full-width regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Top Full Width Content Area' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-top-left regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Top Left' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-top-middle regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Top Middle' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-top-right regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Top Right' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-middle-full-width regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Middle Full Width Content Area' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-bottom-left regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Bottom Left' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-bottom-middle regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Bottom Middle' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-bottom-right regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Home Bottom Right' ) ): ?>
		<?php endif; ?>
	</div>
	<div class="home-bottom-full-width regionalautos-theme">
		<?php if( ! dynamic_sidebar( 'Bottom Full Width Content Area' ) ): ?>
		<?php endif; ?>
	</div>

<?php
	get_footer();
?>
