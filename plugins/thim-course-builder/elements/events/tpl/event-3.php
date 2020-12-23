<?php
$number_events = !empty( $params['number_events'] ) ? $params['number_events'] : 1;

$args = array(
    'post_type'      => 'tp_event',
    'posts_per_page' => $number_events,
    'order'          => $params['order'] == 'asc' ? 'asc' : 'desc',
);
switch ( $params['status_events'] ) {
    case 'upcoming':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'upcoming',
                'compare' => '=',
            ),
        );
        break;
    case 'happening':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'happening',
                'compare' => '=',
            ),
        );
        break;
    case 'expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => 'expired',
                'compare' => '=',
            ),
        );
        break;
    case 'not-expired':
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening' ),
                'compare' => 'IN',
            ),
        );
        break;
    default:
        $args['meta_query'] = array(
            array(
                'key'     => 'tp_event_status',
                'value'   => array( 'upcoming', 'happening', 'expired' ),
                'compare' => 'IN',
            ),
        );
}


switch ( $params['orderby'] ) {
    case 'time' :
        $args['orderby']  = 'meta_value';
        $args['meta_key'] = 'tp_event_date_end';
        break;
    case 'recent' :
        $params['orderby'] = 'post_date';
        break;
    case 'title' :
        $params['orderby'] = 'post_title';
        break;
    case 'popular' :
        $params['orderby'] = 'comment_count';
        break;
    default : //random
        $params['orderby'] = 'rand';
}


if ( $params['cat_events'] ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'tp_event_category',
            'field'    => 'slug',
            'terms'    => array( $params['cat_events'] ),
        ),
    );
}

$events = new WP_Query( $args );

$params['query'] = $events;
?>
<div class="row thim-sc-events owl-carousel owl-theme events-layer-3 <?php echo esc_attr( $params['el_class'] ); ?>" data-cols="3">
	<?php if ( $params['query']->have_posts() ) : ?>
		<?php while ( $params['query']->have_posts() ) : $params['query']->the_post(); ?>
			<div class="events">
				<div class="events-before">
					<div class="thumbnail">
						<a class="img_thumbnail" href="<?php echo esc_url( get_permalink() ); ?>">
							<?php thim_thumbnail( get_the_ID(), '345x510' ); ?>
						</a>
					</div>
					<div class="content">
						<div class="date">
							<div class="date-start"><?php echo( wpems_event_end( 'd' ) ); ?></div>
							<div class="month-start"><?php echo( wpems_event_end( 'M' ) ); ?></div>
						</div>
						<div class="content-inner">
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="time-location">
								<span class="time">
									<i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
								</span>
								<?php if ( wpems_event_location() ) { ?>
									<span class="location">
										<i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
									</span>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="events-after">
					<div class="content">
						<div class="content-inner">
							<h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="time-location">
								<span class="time">
									<i class="ion-android-alarm-clock"></i> <?php echo( wpems_event_start( 'g:i a' ) ); ?> - <?php echo( wpems_event_end( 'g:i a' ) ); ?>
								</span>
								<?php if ( wpems_event_location() ) { ?>
									<span class="location">
										<i class="ion-ios-location"></i> <?php echo( wpems_event_location() ); ?>
									</span>
								<?php } ?>
							</div>
                            <a href="<?php the_permalink(); ?>"><p class="description">
								<?php echo wp_trim_words( get_the_content(), 35 ); ?>
							</p></a>
							<div class="author">
								<a href="<?php echo esc_url( get_author_posts_url( $params['query']->post->post_author ) ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
								</a>
								<div class="author-contain">
									<span class="jobTitle"><?php esc_html_e( 'Host', 'course-builder' ); ?></span>
									<span class="name">
											<a href="<?php echo esc_url( get_author_posts_url( $params['query']->post->post_author ) ); ?>">
												<?php echo get_the_author();?>
											</a>
										</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'course-builder' ); ?></p>
	<?php endif; ?>
</div>