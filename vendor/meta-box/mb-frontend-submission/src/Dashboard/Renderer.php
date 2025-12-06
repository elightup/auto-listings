<?php
namespace MBFS\Dashboard;

use MBFS\Helper;
use WP_Query;
use MetaBox\Support\Arr;

class Renderer {
	private $query;
	private $edit_page_atts;
	private $localize_data = [];
	private $model;
	private $model_result_set = [];

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

		$atts = wp_parse_args( array_filter( $atts ), [
			// Edit page id.
			'edit_page'            => '',

			// Add new post button text
			'add_new'              => __( 'Add New', 'mb-frontend-submission' ),

			// Delete permanently.
			'force_delete'         => 'false',

			'object_type'          => 'post',
			'model_name'           => '',

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

		if ( $atts['object_type'] === 'post' ) {
			$this->query_posts();

			$show_welcome_message = Helper::convert_boolean( $atts['show_welcome_message'] );
			if ( $show_welcome_message === 'true' ) {
				$this->show_welcome_message();
			}

			$this->show_user_posts( $atts );
		} else {
			$model_name = $atts['model_name'];
			if ( empty( $model_name ) ) {
				return '<div class="rwmb-error">' . __( 'Model name is required', 'mb-frontend-submission' ) . '</div>';
			}

			if ( ! class_exists( \MetaBox\CustomTable\Model\Factory::class ) ) {
				// Translators: %s - model name.
				return '<div class="rwmb-error">' . sprintf( __( 'Model %s not found', 'mb-frontend-submission' ), $model_name ) . '</div>';
			}

			$model = \MetaBox\CustomTable\Model\Factory::get( $model_name );

			if ( ! $model ) {
				// Translators: %s - model name.
				return '<div class="rwmb-error">' . sprintf( __( 'Model %s not found', 'mb-frontend-submission' ), $model_name ) . '</div>';
			}

			$this->model = $model;
			$this->query_models();

			$show_welcome_message = Helper::convert_boolean( $atts['show_welcome_message'] );
			if ( $show_welcome_message === 'true' ) {
				$this->show_model_welcome_message();
			}

			$this->show_user_models( $atts );
		}

		return ob_get_clean();
	}

	private function query_models() {
		global $wpdb;

		$args = [];

		// @todo: add pagination
		$query       = "SELECT * FROM {$this->model->table} WHERE 1 = 1";
		$count_query = "SELECT COUNT(*) FROM {$this->model->table} WHERE 1 = 1";

		$results = $wpdb->get_results( $query );
		$count   = $wpdb->get_results( $count_query );

		$this->model_result_set = compact( 'count', 'results' );
	}

	private function query_posts() {
		$paged = max( 1, get_query_var( 'paged' ) );

		$args        = [
			'author'                 => get_current_user_id(),
			'post_type'              => $this->edit_page_atts['post_type'],
			'posts_per_page'         => get_option( 'posts_per_page' ),
			'paged'                  => $paged,
			'post_status'            => 'any',
			'fields'                 => 'ids',
			'no_found_rows'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];
		$args        = apply_filters( 'mbfs_dashboard_query_args', $args );
		$args        = apply_filters( 'rwmb_frontend_dashboard_query_args', $args );
		$this->query = new WP_Query( $args );
	}

	private function show_welcome_message() {
		$post_type = $this->edit_page_atts['post_type'];
		if ( empty( $post_type ) ) {
			$post_type = 'post';
		}

		$post_type_object = get_post_type_object( $post_type );
		$user             = wp_get_current_user();
		$query            = $this->query;

		// Translators: %s - user display name.
		$message = '<h3>' . esc_html( sprintf( __( 'Howdie, %s!', 'mb-frontend-submission' ), $user->display_name ) ) . '</h3>';
		// Translators: %1$d - number of posts, %2$s - post label name.
		$message .= '<p>' . esc_html( sprintf( __( 'You have %1$d %2$s.', 'mb-frontend-submission' ), $query->found_posts, strtolower( $post_type_object->labels->name ) ) ) . '</p>';
		$output   = apply_filters( 'mbfs_welcome_message', $message, $user, $query );
		$output   = apply_filters( 'rwmb_frontend_welcome_message', $message, $user, $query );
		echo $output;
	}
	private function show_model_welcome_message() {
		$user  = wp_get_current_user();
		$label = _n( $this->model->labels['singular_name'], $this->model->labels['menu_name'], $this->model_result_set['count'] );
		// Translators: %s - user display name.
		$message = '<h3>' . esc_html( sprintf( __( 'Howdie, %s!', 'mb-frontend-submission' ), $user->display_name ) ) . '</h3>';
		// Translators: %1$d - number of posts, %2$s - post label name.
		$message .= '<p>' . esc_html( sprintf( __( 'You have %1$d %2$s.', 'mb-frontend-submission' ), $this->model_result_set['count'], $label ) ) . '</p>';
		$output   = apply_filters( 'mbfs_welcome_message', $message, $user, $this->model_result_set );
		$output   = apply_filters( 'rwmb_frontend_welcome_message', $message, $user, $this->model_result_set );
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

	private function show_user_models( $atts ) {
		$this->enqueue();

		$add_new_button = '<a class="mbfs-add-new-post" href="' . esc_url( $this->edit_page_atts['url'] ) . '">' . esc_html( $atts['add_new'] ) . '</a>';
		$add_new_button = apply_filters( 'mbfs_dashboard_add_new_button', $add_new_button, $atts );
		echo $add_new_button;

		if ( $this->model_result_set['count'] === 0 ) {
			return;
		}

		$columns = $atts['columns'];
		?>
		<table class="mbfs-posts">
			<tr>
				<?php foreach ( Arr::from_csv( $columns ) as $column ) : ?>
					<th><?= esc_html( $column ); ?></th>
				<?php endforeach; ?>
				<th><?= esc_html( $atts['label_actions'] ); ?></th>
			</tr>

			<?php foreach ( $this->model_result_set['results'] as $model ) : ?>
				<tr>
					<?php foreach ( Arr::from_csv( $columns ) as $column ) : ?>
						<td><?= esc_html( $model->$column ?? '' ); ?></td>
					<?php endforeach; ?>
					<td align="center" class="mbfs-actions">
						<?php
						// Before edit action
						do_action( 'rwmb_frontend_before_edit_action', $model->ID );

						$edit_action = '<a href="' . esc_url( add_query_arg( 'rwmb_frontend_field_object_id', $model->ID, $this->edit_page_atts['url'] ) ) . '" title="' . esc_attr__( 'Edit', 'mb-frontend-submission' ) . '"><img src="' . MBFS_URL . 'assets/pencil.svg"></a>';
						// Filter the edit action
						$edit_action = apply_filters( 'rwmb_frontend_dashboard_edit_action', $edit_action, $model->ID );
						echo $edit_action;

						// Before delete action
						do_action( 'rwmb_frontend_before_delete_action', $model->ID );

						$delete_action = true;
						// Filter the delete action
						$delete_action = apply_filters( 'rwmb_frontend_dashboard_delete_action', $delete_action, $model->ID );
						if ( $delete_action ) {
							echo '<button class="rwmb-button--delete" data-id="' . $model->ID . '" data-object_type="model" data-model="' . $this->model->name . '"><img src="' . MBFS_URL . 'assets/trash.svg"></button>';
						}

						// End actions
						do_action( 'rwmb_frontend_end_actions', $model->ID );
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php
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
				<th><?= esc_html( $atts['label_actions'] ); ?></th>
			</tr>
			<?php
			while ( $this->query->have_posts() ) :
				$this->query->the_post();
				?>
				<tr>
					<?php if ( in_array( 'title', $columns, true ) ) : ?>
						<?php
						if ( $atts['title_link'] === 'edit' ) {
							$title_link = add_query_arg( 'rwmb_frontend_field_object_id', get_the_ID(), $this->edit_page_atts['url'] );
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
						<td align="center">
							<?php
								$status = esc_html( get_post_status_object( get_post_status() )->label );
								echo apply_filters( 'rwmb_frontend_dashboard_status', $status, get_the_ID() );
							?>
						</td>
					<?php endif; ?>

					<td align="center" class="mbfs-actions">
						<?php
						// Before edit action
						do_action( 'rwmb_frontend_before_edit_action', get_the_ID() );

						$edit_action = '<a href="' . esc_url( add_query_arg( 'rwmb_frontend_field_object_id', get_the_ID(), $this->edit_page_atts['url'] ) ) . '" title="' . esc_attr__( 'Edit', 'mb-frontend-submission' ) . '"><img src="' . MBFS_URL . 'assets/pencil.svg"></a>';
						// Filter the edit action
						$edit_action = apply_filters( 'rwmb_frontend_dashboard_edit_action', $edit_action, get_the_ID() );
						echo $edit_action;

						// Before delete action
						do_action( 'rwmb_frontend_before_delete_action', get_the_ID() );

						$delete_action = true;
						// Filter the delete action
						$delete_action = apply_filters( 'rwmb_frontend_dashboard_delete_action', $delete_action, get_the_ID() );
						if ( $delete_action ) {
							echo '<button class="rwmb-button--delete" data-id="' . get_the_ID() . '" data-force="' . $atts['force_delete'] . '"><img src="' . MBFS_URL . 'assets/trash.svg"></button>';
						}

						// End actions
						do_action( 'rwmb_frontend_end_actions', get_the_ID() );
						?>
					</td>
				</tr>
			<?php endwhile ?>
		</table>
		<?php
		$this->render_pagination();
		wp_reset_postdata();
	}

	private function render_pagination() {
		if ( $this->query->max_num_pages <= 1 ) {
			return;
		}

		$paged = max( 1, get_query_var( 'paged' ) );

		$args = [
			'base'      => get_pagenum_link( 1 ) . '%_%',
			'format'    => 'page/%#%/',
			'current'   => $paged,
			'total'     => $this->query->max_num_pages,
			'prev_text' => __( '&laquo; Previous', 'mb-frontend-submission' ),
			'next_text' => __( 'Next &raquo;', 'mb-frontend-submission' ),
			'type'      => 'list',
		];

		$pagination = paginate_links( $args );
		if ( $pagination ) {
			echo '<div class="mbfs-pagination">' . $pagination . '</div>';
		}
	}

	private function enqueue(): void {
		wp_enqueue_style( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.css', [], MBFS_VER );
		wp_enqueue_script( 'mbfs-dashboard', MBFS_URL . 'assets/dashboard.js', [ 'wp-api-fetch' ], MBFS_VER, true );

		wp_localize_script( 'mbfs-dashboard', 'mbFrontendForm', [
			'confirm_delete' => __( 'Are you sure to delete this record?', 'mb-frontend-submission' ),
		] );
	}
}
