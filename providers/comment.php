<?php
namespace Faker\Provider;

class Comment extends Base {
	public function __construct( $fakerpress ) {
		$this->generator  = $fakerpress->faker;
		$this->fakerpress = $fakerpress;

		$provider = new Html( $this->generator );
		$this->generator->addProvider( $provider );
	}

	public function comment_content( $comment_content = null, $max_chars = 200, $save = true ) {
		if ( $comment_content == null ){
			$comment_content = $this->generator->text( $max_chars );
			$comment_content = substr( $comment_content, 0, strlen( $comment_content ) - 1 );
		}

		if ( true === $save ){
			$this->fakerpress->args['comment_content'] = $comment_content;
		}

		return $comment_content;
	}

	public function user_id( $user_id = null, $save = true ) {
		if ( $user_id == null ){
			$args = array(
				'blog_id'      => $GLOBALS['blog_id'],
				'count_total'  => false,
				'fields'       => 'all',
			);

			$users = get_users( $args );

			if ( $users ){
				foreach ( $users as $user ){
					$users_id[] = $user->ID;
				}
			}

			if ( $users_id ){
				$user_id = $this->generator->randomElement( $users_id, 1 );
			}
		}

		if ( true === $save ){
			$this->fakerpress->args['user_id'] = $user_id;
		}

		return $user_id;
	}

	public function comment_author( $comment_author = null, $save = true ) {
		if ( $comment_author == null ){
			$author_obj     = get_userdata( $this->fakerpress->args['user_id'] );
			$comment_author = $author_obj->user_login;
		}

		if ( true === $save ){
			$this->fakerpress->args['comment_author'] = $comment_author;
		}

		return $comment_author;
	}

	public function comment_approved( $comment_approved = 1, $save = true ) {
		if ( true === $save ){
			$this->fakerpress->args['comment_approved'] = $comment_approved;
		}

		return $comment_approved;
	}

	public function comment_post_id( $comment_post_ID = null, $save = true ) {
		if ( $comment_post_ID == null ){
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'suppress_filters' => true,
			);

			$posts = get_posts( $args );

			if ( $posts ){
				foreach ( $posts as $post ){
					$post_id[] = $post->ID;
				}
			}

			if ( $post_id ){
				$comment_post_ID = $this->generator->randomElement( $post_id, 1 );
			}
		}

		if ( true === $save ){
			$this->fakerpress->args['comment_post_ID'] = $comment_post_ID;
		}

		return $comment_post_ID;
	}

	public function comment_author_email( $author_email = null, $max_chars = 200, $save = true ) {
		if ( $author_email == null ){
			$author_email = $this->generator->safeEmail;
			$author_email = substr( $author_email, 0, strlen( $author_email ) - 1 );
		}

		if ( true === $save ){
			$this->fakerpress->args['comment_author_email'] = $author_email;
		}

		return $author_email;
	}

	public function comment_author_url( $author_url = null, $max_chars = 200, $save = true ) {
		if ( $author_url == null ){
			$author_url = $this->generator->url;
			$author_url = substr( $author_url, 0, strlen( $author_url ) - 1 );
		}

		if ( true === $save ){
			$this->fakerpress->args['comment_author_url'] = $author_url;
		}

		return $author_url;
	}
}