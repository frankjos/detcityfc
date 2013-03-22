<?php
/**
 * @package WordPress
 * @subpackage Victoria
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.','victoria_front');?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->

	<?php if ( have_comments() ) : ?>
	<div id="comments"><!--start:comments -->
		<h3 id="comments-title"><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'victoria_front' ),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );?>
		</h3>

		<ol class="commentlist">
			<?php wp_list_comments('type=comment&callback=atp_custom_comment'); ?>
		</ol>
	</div>
	<!--end:comments -->
			
	<!--start:navigation -->
	<div class="pagination">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<!--end:navigation -->

	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
	<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>	

	<!-- If comments are closed. -->
		
	<?php endif; ?>
	<?php endif; ?>
	
	<?php if ('open' == $post->comment_status) : ?>
	
	<!--start:repond -->
	<div id="respond">
		<div class="cancel-comment-reply">
			<small><?php cancel_comment_reply_link(); ?></small>
		</div>
		
		<h3><?php comment_form_title( __('Leave a Reply','victoria_front'), __('Leave a Reply to %s','victoria_front') ); ?></h3>

		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
		<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment','victoria_front'),wp_login_url( get_permalink() )); ?></p>
	
		</div><!-- not logged in users-->
		<?php else : ?>
				
		<!--start:form -->
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( $user_ID ) : ?>
			<p><?php printf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','victoria_front'), admin_url( 'profile.php' ), $user_identity, wp_logout_url( get_permalink()  ) )?></p>
			<?php else : ?>
			<p>  
				<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><?php _e('Name','victoria_front');  if ($req) echo " *"; ?></label>
			</p>
			<p>
				<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><?php _e('Mail','victoria_front');  if ($req) echo " *"; ?></label>
			</p>
			<p>
				<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><?php _e('Website','victoria_front');  if ($req) echo " *"; ?></label>
			</p>

			<?php endif; ?>

			<p>
				<textarea name="comment" id="comment" cols="10" rows="10" tabindex="4"></textarea>
			</p>

			<div class="indent">
				<p><a class="button small" href="#" onclick="jQuery('#commentform').submit();return false;"><span><?php _e('Post Comment','victoria_front');?></span></a></p>
				<p><span><strong>XHTML:</strong> <?php _e('You can use these tags','victoria_front');?>: <?php echo allowed_tags(); ?></span></p>
				<?php comment_id_fields(); ?>
				<?php do_action('comment_form', $post->ID); ?>
			</div>
		</form>
		<!--end:form -->
	</div>
	<!--end:repond-->
	<?php endif; // If registration required and not logged in ?>
	<?php endif; // if you delete this the sky will fall on your head ?>