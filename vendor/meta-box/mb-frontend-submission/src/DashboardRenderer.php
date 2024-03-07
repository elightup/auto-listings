<?php
namespace MBFS;

use MBFS\Helper;
use WP_Query;
use MetaBox\Support\Arr;

class DashboardRenderer {
	private $query;
	private $edit_page_atts;
	private $localize_data = [];

	public function render( $atts ) {
		if ( ! is_user_logged_in() ) {
			return esc_html__( 'Please login to view the dashboard.', 'mb-frontend-submission' );
		}

		$edit_page_id         = (int) $atts['edit_page'];
		$this->edit_page_atts = $this->get_edit_page_attrs( $edit_page_id );
		if ( empty( $this->edit_page_atts ) ) {
			// Translators: %d - page ID.
			return '<div class="rwmb-error">' . sprintf( __( 'Something is wrong with the edit page with ID #%d. Please check again', 'mb-frontend-submission' ), $edit_page_id ) . '</div>';
		}

		$atts = wp_parse_args( $atts, [
			// Edit page id.
			'edit_page'            => '',

			// Add new post button text
			'add_new'              => __( 'Add New', 'mb-frontend-submission' ),

			// Delete permanently.
			'force_delete'         => 'false',

			// Columns to display.
			'columns'              => 'title,date,status',

			// Column header labels.
			'label_title'          => __( 'Title', 'mb-frontend-submission' ),
			'label_date'           => __( 'Date', 'mb-frontend-submission' ),
			'label_status'         => __( 'Status', 'mb-frontend-submission' ),
			'label_actions'        => __( 'Actions', 'mb-frontend-submission' ),

			// Link action for post title (view|edit).
			'title_link'           => '',

			// Flag to hide/show welcome message.
			'show_welcome_message' => 'true',
		] );

		// Allow users to overwrite id and post type.
		Arr::change_key( $atts, 'meta_box_id', 'id' );
		Arr::change_key( $atts, 'group_ids', 'id' );
		if ( ! empty( $atts['id'] ) ) {
			$this->edit_page_atts['id'] = $atts['id'];
		}
		if ( ! empty( $atts['post_type'] ) ) {
			$this->edit_page_atts['post_type'] = $atts['post_type'];
		}

		ob_start();
		$this->query_posts();

		$show_welcome_message = Helper::convert_boolean( $atts['show_welcome_message'] );
		if ( $show_welcome_message === 'true' ) {
			$this->show_welcome_message();
		}

		$this->show_user_posts( $atts );

		return ob_get_clean();
	}

	private function query_posts() {
		$args        = [
			'author'                 => get_current_user_id(),
			'post_type'              => $this->edit_page_atts['post_type'],
			'posts_per_page'         => -1,
			'post_status'            => 'any',
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];
		$args        = apply_filters( 'mbfs_dashboard_query_args', $args );
		$args        = apply_filters( 'rwmb_frontend_dashboard_query_args', $args );
		$this->query = new WP_Query( $args );
	}

	private function show_welcome_message() {
		$post_type        = $this->edit_page_atts['post_type'];
		$post_type_object = get_post_type_object( $post_type );
		$user             = wp_get_current_user();
		$query            = $this->query;

		// Translators: %s - user display name.
		$message = '<h3>' . esc_html( sprintf( __( 'Howdie, %s!', 'mb-frontend-submission' ), $user->display_name ) ) . '</h3>';
		// Translators: %1$d - number of posts, %2$s - post label name.
		$message .= '<p>' . esc_html( sprintf( __( 'You have %1$d %2$s.', 'mb-frontend-submission' ), $query->post_count, strtolower( $post_type_object->labels->name ) ) ) . '</p>';
		$output   = apply_filters( 'mbfs_welcome_message', $message, $user, $query );
		$output   = apply_filters( 'rwmb_frontend_welcome_message', $message, $user, $query );
		echo $output;
	}

	private function get_edit_page_attrs( int $edit_page_id ): array {
		$attributes = $this->get_edit_page_attrs_from_shortcode( $edit_page_id );
		$attributes = apply_filters( 'rwmb_frontend_dashboard_edit_page_atts', $attributes, $edit_page_id );
		$attributes = Helper::parse_attributes( $attributes );

		$attributes['url'] = get_permalink( $edit_page_id );

		return $attributes;
	}

	private function get_edit_page_attrs_from_shortcode( int $edit_page_id ): array {
		$edit_page = get_post( $edit_page_id );
		$pattern   = get_shortcode_regex( [ 'mb_frontend_form' ] );
		$content   = Helper::get_post_content( $edit_page );

		if ( ! preg_match_all( '/' . $pattern . '/s', $content, $matches ) || empty( $matches[2] ) || ! in_array( 'mb_frontend_form', $matches[2], true ) ) {
			return [];
		}

		$key = array_search( 'mb_frontend_form', $matches[2], true );

		return shortcode_parse_atts( $matches[3][ $key ] );
	}

	private function show_user_posts( $atts ) {
		$this->enqueue();
		$add_new_button = '<a class="mbfs-add-new-post" href="' . esc_url( $this->edit_page_atts['url'] ) . '">' . esc_html( $atts['add_new'] ) . '</a>';
		$add_new_button = apply_filters( 'mbfs_dashboard_add_new_button', $add_new_button, $atts );
		echo $add_new_button;
		if ( ! $this->query->have_posts() ) {
			return;
		}
		?>
		<table class="mbfs-posts">
			<tr>
				<?php
				$columns = Arr::from_csv( $atts['columns'] );
				if ( in_array( 'title', $columns, true ) ) {
					echo '<th>', esc_html( $atts['label_title'] ), '</th>';
				}
				if ( in_array( 'date', $columns, true ) ) {
					echo '<th>', esc_html( $atts['label_date'] ), '</th>';
				}
				if ( in_array( 'status', $columns, true ) ) {
					echo '<th>', esc_html( $atts['label_status'] ), '</th>';
				}
				?>
				<th><?= esc_html( $atts['label_actions'] ) ?></th>
			</tr>
			<?php
			while ( $this->query->have_posts() ) :
				$this->query->the_post();
				?>
				<tr>
					<?php if ( in_array( 'title', $columns, true ) ) : ?>
						<?php
						if ( $atts['title_link'] === 'edit' ) {
							$title_link = add_query_arg( 'rwmb_frontend_field_post_id', get_the_ID(), $this->edit_page_atts['url'] );
						} else {
							$title_link = get_the_permalink();
						}
						$title = '<a href="' . esc_url( $title_link ) . '">' . get_the_title() . '</a>';
						// filter the title links
						$title = apply_filters( 'mbfs_dashboard_post_title', $title, get_the_ID() );
						$title = apply_filters( 'rwmb_frontend_dashboard_post_title', $title, get_the_ID() );
						?>
						<td><?php echo $title; ?></td>
					<?php endif; ?>

					<?php if ( in_array( 'date', $columns, true ) ) : ?>
						<td align="center"><?php the_time( get_option( 'date_format' ) ) ?></td>
					<?php endif; ?>

					<?php if ( in_array( 'status', $columns, true ) ) : ?>
						<td align="center"><?= esc_html( get_post_status_object( get_post_status() )->label ) ?></td>
					<?php endif; ?>

					<td align="center" class="mbfs-actions">
						<?php
						// Before edit action
						do_action( 'rwmb_frontend_before_edit_action', get_the_ID() );

						$edit_action = '<a href="' . esc_url( add_query_arg( 'rwmb_frontend_field_post_id', get_the_ID(), $this->edit_page_atts['url'] ) ) . '" title="' . esc_attr__( 'Edit', 'mb-frontend-submission' ) . '"><img src="' . MBFS_URL . 'assets/pencil.svg"></a>';
						// Filter the edit action
						$edit_action = apply_filters( 'rwmb_frontend_dashboard_edit_action', $edit_action, get_the_ID() );
						echo $edit_action;

						// Before delete action
						do_action( 'rwmb_frontend_before_delete_action', get_the_ID() );

						$delete_action = true;
						// Filter the delete action
						$delete_action = apply_filters( 'rwmb_frontend_dashboard_delete_action', $delete_action, get_the_ID() );
						if ( $delete_action ) {
							echo do_shortcode( '[mb_frontend_form id="' . $this->edit_page_atts['id'] . '" post_id="' . get_the_ID() . '" ajax="true" allow_delete="true" force_delete="' . $atts['force_delete'] . '" only_delete="true" delete_button="<img src=\'' . MBFS_URL . 'assets/trash.svg\'>"]' );
						}

						// End actions
						do_action( 'rwmb_frontend_end_actions', get_the_ID() );
						?>
					</td>
				</tr>
			<?php endwhile ?>
		</table>
		<?php
		wp_reset_postdata();
	}

	private function enqueue() {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', '', MBFS_VER );
		wp_enqueue_script( 'mbfs', MBFS_URL . 'assets/frontend-submission.js', array( 'jquery' ), MBFS_VER, true );

		$this->localize_data = array_merge( $this->localize_data, [
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'ajax_nonce' ),
			'confirm_delete' => __( 'Are you sure to delete this post?', 'mb-frontend-submission' ),
		] );
		wp_localize_script( 'mbfs', 'mbFrontendForm', $this->localize_data );
	}
}
