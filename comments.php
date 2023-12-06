<?php
	if ( post_password_required() ) {
		echo '<p class="nocomments">' . __( 'This post is password protected. Enter the password to view comments.', 'goblog' ) . '</p>';
		return;
	}
?>
	<?php if ( have_comments() ) : ?>
		<div id="comments" class="comments-area block block-single clearfix">
			<h3 class="comments-count section-heading uppercase"><span>
				<?php
				printf( _n( '1 Comment', '%s Comments', get_comments_number(), 'goblog' ), number_format_i18n( get_comments_number() ) );
				?>
			</span></h3>
			<?php
			if ( get_option( 'page_comments' ) ) {
				$comment_pages = paginate_comments_links( 'echo=0' );
				if ( $comment_pages ) {
					echo '<div class="commentnavi commentnavi-1 pagination">' . $comment_pages . '</div>';
				}
			}
			?>
			<ol class="commentlist clearfix">
			<?php
				wp_list_comments(
					array(
						'callback'    => 'bpxl_comment',
						'type'        => 'comment',
						'short_ping'  => true,
						'avatar_size' => 75,
					)
				);
			?>
			<?php
				wp_list_comments(
					array(
						'type'        => 'pingback',
						'short_ping'  => true,
						'avatar_size' => 75,
					)
				);
			?>
			</ol>
			<?php
			if ( get_option( 'page_comments' ) ) {
				$comment_pages = paginate_comments_links( 'echo=0' );
				if ( $comment_pages ) {
					echo '<div class="commentnavi pagination">' . $comment_pages . '</div>';
				}
			}
			?>
		</div><!-- #comments -->

	<?php else : // this is displayed if there are no comments so far.

		if ( 'open' == $post->comment_status ) :
			// If comments are open, but there are no comments.

	else : // comments are closed
		// If comments are closed.

	endif;
	endif;
	global $aria_req; $comments_args = array(
		'title_reply_before'   => '<h4 class="section-heading uppercase" id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h4>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => $fields = array(
			'author' =>
			'<p class="comment-form-author"><label for="author">' . esc_html__( 'Name ', 'goblog' ) .
			( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
			'<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name ', 'goblog' ) .
			( $req ? '(' . esc_html__( 'Required', 'goblog' ) . ')' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="19"' . $aria_req . ' /></p>',

			'email'  =>
			'<p class="comment-form-email"><label for="email">' . esc_html__( 'Email ', 'goblog' ) .
			( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .
			'<input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email ', 'goblog' ) .
			( $req ? '(' . esc_html__( 'Required', 'goblog' ) . ')' : '' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="19"' . $aria_req . ' /></p>',

			'url'    =>
			'<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'goblog' ) . '</label>' .
			'<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website ', 'goblog' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="19" /></p>',
		),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comments ', 'goblog' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_html__( 'Comment ', 'goblog' ) .
				( $req ? '(' . esc_html__( 'Required', 'goblog' ) . ')' : '' ) . '" cols="45" rows="8" aria-required="true"></textarea></p>',
		'label_submit'         => esc_html__( 'Submit ', 'goblog' ),
	);

	comment_form( $comments_args );
	?>