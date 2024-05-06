<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  

add_action( 'wp_enqueue_scripts', 'shoredigital_style' );
				function shoredigital_style() {
					wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
					wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
				}

/**
 * Your code goes below.
 */

 function careers_cards_shortcode() {
    ob_start();
    include( get_stylesheet_directory() . '/shortcodes/careers/careers-cards.php' );
    return ob_get_clean();
}
add_shortcode('careers_cards', 'careers_cards_shortcode');


// [sd_posts post_type="byrons_service"]
function sd_posts_shortcode( $atts ) { 
	$post_type = $atts['post_type'];
	$taxonomy = $atts['tax'];

	if ($post_type == 'byrons_service'){
	

		// Get selected service
		$services = get_the_terms( get_the_ID() , 'by_member_services' );
		$selected_service = $services[0]->name;

		// WP Query arguments
		$posts_args = array(
			'post_type'=> $post_type,
			'order'    => 'DESC',
			'posts_per_page' => '-1', // show unlimited posts
			'post_status' => array('publish')
		);
		$posts_query = new WP_Query( $posts_args ); ?>

		<div class="sd-posts-container">
		<?php
			while ( $posts_query->have_posts() ){ 
				$posts_query->the_post();
				$service_name = get_the_title();
				$service_content = get_field('team_service_summary');
				$service_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				$service_icon = get_field('service_icon');
				$service_link = get_the_permalink();

				// Show the selected service if the service name matches with the team member selected service
				if( $selected_service ==  $service_name ) {?>
					<div class="sd-posts-item">
						<div class="sd-posts-col">
							<div class="">
								<div class="sd-post-image"><img src="<?= $service_image ?>"></div>
							</div>
						</div>
						<div class="sd-posts-col">
							<div class="sd-post-name">SERVICE: <?= $service_name ?></div>
							<div class="sd-podt-content"><?= $service_content ?></div>
							<a href="<?= $service_link ?>">Find Out More</a>
						</div>
					</div>
		<?php
				}
			}
			wp_reset_query(); ?>
		</div>
<?php
	} elseif ($post_type == 'by-blog-box'){

		$member_name = get_the_title();

		// WP Query arguments
		$posts_args = array(
			'post_type'=> $post_type,
			'order'    => 'DESC',
			'posts_per_page' => '-1', // show unlimited posts
			'post_status' => array('publish'),
			'tax_query' => array(
				array(
					'taxonomy'      => 'by_member_association',
					'terms'         => $member_name,
					'field'         => 'name',
					'operator'      => 'IN'
				)
			)
		);
		$posts_query = new WP_Query( $posts_args ); ?>

		<div class="sd-blog-container">
		<?php
			if ( $posts_query->found_posts > 0 ){
				while ( $posts_query->have_posts() ){ 
					$posts_query->the_post();
					$post_name = get_the_title();
					$post_date = get_the_date();
					//$post_author = get_the_author();
					$post_content = get_the_excerpt();
					$post_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
					$post_icon = get_field('service_icon');
					$post_link = get_the_permalink();

					$members = get_the_terms( get_the_ID() , 'by_member_association' );

					$selected_member_taxonomy = $members[0]->taxonomy;
					$selected_member_id = $members[0]->term_id;
					$selected_member = $members[0]->name;
					$selected_member_image = get_field('member_image', $selected_member_taxonomy . '_' .$selected_member_id );

					?>
						<div class="sd-blog-item">
							<div class="sd-blog-col">
								<div class="sd-blog-image"><a href="<?= $post_link ?>"><img src="<?= $post_image ?>" alt="<?= $post_name?>"></a></div>
							</div>
							<div class="sd-blog-col">
								<div class="sd-blog-date"><?= $post_date ?></div>
							</div>
							<div class="sd-blog-col">
								<div class="sd-blog-name"><?= $post_name ?></div>
							</div>
							<div class="sd-blog-col">
<!-- 								<div class="sd-blog-author"><img src="< $selected_member_image ?>" alt="< $member_name ?>"> Author: < $selected_member ?></div> -->
								<div class="sd-blog-author"><img src="/wp-content/plugins/sd-custom-codes/assets/img/auth-icon.jpg" alt="<?= $member_name ?>"> Author: <?= $selected_member ?></div>
							</div>
							<div class="sd-blog-col">
								<div class="sd-blog-excerpt">
									<?= $post_content ?>
								</div>
							</div>
							<div class="sd-blog-col">
								<div class="sd-blog-link"><a href="<?= $post_link ?>">Read More <i class="fa fa-long-arrow-right fa-2x" style="position: relative; top: 4px; left: 15px;" aria-hidden="true"></i></a></div>
							</div>
						</div>
			<?php
				}
				wp_reset_query();
		} } else {
    // Check if the post type is 'by-blog-box' and replace 'No Articles Available' with 'Byrons News'
    if ($post_type == 'by-blog-box') {
        $byrons_news_args = array(
            'post_type' => $post_type,
            'order' => 'DESC',
            'posts_per_page' => '-1', // show unlimited posts
            'post_status' => array('publish'),
            'tax_query' => array(
                array(
                    'taxonomy' => 'by_member_association',
                    'terms' => 'Byrons', // Filter by the term 'Byrons'
                    'field' => 'name',
                    'operator' => 'IN'
                )
            )
        );
        $byrons_news_query = new WP_Query($byrons_news_args);

        if ($byrons_news_query->found_posts > 0) {
            while ($byrons_news_query->have_posts()) {
                $byrons_news_query->the_post();
                // Display Byrons News posts here
            }
            wp_reset_query();
        } else {
            // If no Byrons News posts found, display the message
            echo "<p>Byrons News</p>";
        }
    } else {
        // For other post types, display the default message
        echo "<p>No articles available.</p>";
    }
}
?>

		</div>

<?php

	} elseif ($post_type == 'team_member' && $taxonomy == 'by_member_services'){
		// Get selected service
		$contact_selected_service = get_the_title();

		// WP Query arguments
		$posts_args = array(
			'post_type'=> $post_type,
			'order'    => 'DESC',
			'posts_per_page' => '-1', // show unlimited posts
			'post_status' => array('publish'),
			'tax_query' => array(
				array(
					'taxonomy'      => $taxonomy,
					'terms'         => $contact_selected_service,
					'field'         => 'name',
					'operator'      => 'IN'
				)
			)
		);
		$posts_query = new WP_Query( $posts_args ); 
		/*echo "<pre>";
		print_r($posts_query);
		echo "</pre>";*/
		?>
		<div class="sd-service-container">
		<?php
		if ( $posts_query->found_posts > 0 ){
			while ( $posts_query->have_posts() ){ 
				$posts_query->the_post();
				$contact_name = get_the_title();
				$contact_position = get_field('advisor_position');
				$contact_discussion = get_field('advisor_discussion');
				$contact_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				$contact_link = get_the_permalink();
				?>
						<div class="sd-service-item">
							<div class="sd-service-img-col">
								<div class="sd-service-image"><img src="<?= $contact_image ?>" alt="<?= $contact_name?>"></div>
							</div>
							<div class="sd-service-col">
								<div class="sd-service-name"><?= $contact_name ?></div>
								<div class="sd-service-position"><?= $contact_position ?></div>
								<div class="sd-service-discussion"><?= $contact_discussion ?></div>
								<div class="sd-service-link"><a href="<?= $contact_link ?>">Learn More <i class="fa fa-long-arrow-right fa-2x By_learnmore_pointer" aria-hidden="true"></i></a></div>
							</div>
						</div>
		<?php
				
			}
			wp_reset_query(); ?>
		</div>
		<?php


			} ?>
<?php
	} elseif ($post_type == 'team_member' && $taxonomy == 'by_member_industries'){
		// Get selected service
		$contact_selected_service = get_the_title();

		// WP Query arguments
		$posts_args = array(
			'post_type'=> $post_type,
			'order'    => 'DESC',
			'posts_per_page' => '-1', // show unlimited posts
			'post_status' => array('publish'),
			'tax_query' => array(
				array(
					'taxonomy'      => $taxonomy,
					'terms'         => $contact_selected_service,
					'field'         => 'name',
					'operator'      => 'IN'
				)
			)
		);
		$posts_query = new WP_Query( $posts_args ); 
		/*echo "<pre>";
		print_r($posts_query);
		echo "</pre>";*/
		?>
		<div class="sd-industry-container">
		<?php
		if ( $posts_query->found_posts > 0 ){
			while ( $posts_query->have_posts() ){ 
				$posts_query->the_post();
				$contact_name = get_the_title();
				$contact_position = get_field('advisor_position');
				$contact_discussion = get_field('advisor_discussion');
				$contact_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
				$contact_link = get_the_permalink();
				?>
						<div class="sd-industry-item">
							<div class="sd-industry-img-col">
								<div class="sd-industry-image"><img src="<?= $contact_image ?>" alt="<?= $contact_name?>"></div>
							</div>
							<div class="sd-industry-col">
								<div class="sd-industry-name"><?= $contact_name ?></div>
								<div class="sd-industry-position"><?= $contact_position ?></div>
								<div class="sd-industry-discussion"><?= $contact_discussion ?></div>
								<div class="sd-industry-link"><a href="<?= $contact_link ?>">Learn More <i class="fa fa-long-arrow-right fa-2x By_learnmore_pointer" aria-hidden="true"></i></a></div>
							</div>
						</div>
		<?php
				
			}
			wp_reset_query(); ?>
		</div>
		<?php


			} 
	}
}
add_shortcode( 'sd_posts', 'sd_posts_shortcode' );

