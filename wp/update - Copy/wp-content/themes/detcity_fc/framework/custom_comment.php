<?php
function atp_custom_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; $homeurl = get_template_directory_uri(); ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_wrap">
		<div class="comment-author">
			<?php echo get_avatar($comment,$size='40',$default=$default = $homeurl . '/images/default_avatar_visitor.gif' ); ?>
			<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link()) ?>
			<div class="comment-meta"> <?php echo get_comment_date(); ?> at <?php comment_time('g:i a'); ?>
			<br />
			<?php edit_comment_link(__('Edit', 'victoria_front'),'  ','') ?>
			</div>
		</div>
		<div class="single_comment">
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="moderation"><em><?php _e('Your comment is awaiting moderation.', 'victoria_front') ?></em></div>
			<?php endif; ?>
			<?php comment_text() ?>
			<span class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</span> 
		</div>
		<div class="clear"></div>
	</div>
<?php } ?>