<footer class="social">
	<a href="mailto:<?= get_field( 'email', 'options' ) ?>?subject=<?= get_field( 'email_subject', 'options' ) ?>" class="email social-icon">
		<?= file_get_contents(get_template_directory_uri().'/assets/images/email.svg'); ?>
	</a>
	<a href="<?= get_field( 'facebook', 'options' ) ?>" target="_blank" class="facebook social-icon">
		<?= file_get_contents(get_template_directory_uri().'/assets/images/facebook.svg'); ?>
	</a>
	<a href="<?= get_field( 'twitter', 'options' ) ?>" target="_blank" class="twitter social-icon">
		<?= file_get_contents(get_template_directory_uri().'/assets/images/twitter.svg'); ?>
	</a>
	<a href="<?= get_field( 'instagram', 'options' ) ?>" target="_blank" class="instagram social-icon">
		<?= file_get_contents(get_template_directory_uri().'/assets/images/instagram.svg'); ?>
	</a>
</footer>