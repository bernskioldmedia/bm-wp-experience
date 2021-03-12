<?php
$label = apply_filters( 'bm_wpexp_environment_staging_public_label', __( 'Staging Environment', 'bm-wp-experience' ) );
?>

<div class="bm-staging-notice">
	<p><?php echo esc_html( $label ); ?></p>
</div>
<style>
	.bm-staging-notice {
		position: fixed;
		bottom: 0;
		left: 0;
		z-index: 800;
		background-image: linear-gradient(45deg, #e6c34e 25%, #000000 25%, #000000 50%, #e6c34e 50%, #e6c34e 75%, #000000 75%, #000000 100%);
		background-size: 56.57px 56.57px;
		width: 100%;
		padding: 0 2rem;
		text-align: center;
		border-top: 4px solid black;
	}

	.bm-staging-notice p {
		color: white;
		font-weight: bold;
		background-color: black;
		padding: 0.25rem 1.5rem;
		display: inline-block;
		margin: auto;
		font-size: 16px;
		text-transform: uppercase;
	}
</style>
