<div class="als-tab__pane is-active" data-tab="template-editor">
	<textarea class="widefat" rows="20" id="als-post-content" name="post_content"><?= esc_textarea( get_post()->post_content ) ?></textarea>
</div>

<div class="als-tab__pane" data-tab="css-editor">
	<textarea class="widefat" rows="20" id="als-post-excerpt" name="post_excerpt"><?= esc_textarea( get_post()->post_excerpt ) ?></textarea>
</div>

<div class="als-tab__pane" data-tab="js-editor">
	<textarea class="widefat" rows="20" id="als-post-content-filtered" name="post_content_filtered"><?= esc_textarea( get_post()->post_content_filtered ) ?></textarea>
</div>