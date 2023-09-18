<?php
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Home_Testimonials extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Testimonials widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'eshop-home-testimonials';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Testimonials widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Eshop home testimonials', 'elementor-widget-developments' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Testimonials widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-testimonial';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Testimonials widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Testimonials widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'testimonial', 'url', 'link' );
	}

	/**
	 * Get widget styles dependencies.
	 *
	 * Retrieve the list of style the testimonial widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget styles
	 */
	public function get_style_depends() {
		return array( 'owl-carousel-min', 'owl-carousel-theme-default', 'home-testimonial' );
	}

	/**
	 * Get widget scripts dependencies.
	 *
	 * Retrieve the list of scripts the testimonial widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget styles
	 */
	public function get_script_depends() {
		return array( 'owl-carousel-scripts' );
	}

	/**
	 * Register Testimonials widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'elementor-widget-developments' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'testimonial_header_text',
			array(
				'label'       => esc_html__( 'Main title', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => esc_html__( 'What our Customers and  Employees say', 'elementor-widget-developments' ),
			)
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'testimonial_image',
			array(
				'label'   => esc_html__( 'Choose image', 'elementor-widget-developments' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					Utils::get_placeholder_image_src(),
				),
			),
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			)
		);

		$repeater->add_control(
			'company_name',
			array(
				'label'       => esc_html__( 'Company Name', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'company_position',
			array(
				'label'       => esc_html__( 'Company Position', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'company_message',
			array(
				'label'       => esc_html__( 'Message', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonials', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_Controls(),
				'default'     => array(
					array(
						'company_name'     => __( 'Name', 'elementor-widget-developments' ),
						'company_position' => __( 'Position', 'elementor-widget-developments' ),
						'company_message'  => __( 'message', 'elementor-widget-developments' ),
					),
				),
				'title_field' => '{{{ company_name }}}',
			),
		);

		$this->end_controls_section();

	}

	/**
	 * Render Testimonials widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		extract( $this->get_settings_for_display() ); //phpcs:ignore
		?>
		<div class="eshop_home_testimonial_carousel">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 eshop_home_testimonial_carousel_top text-center ">
						<?php if ( isset( $testimonial_header_text ) && ! empty( $testimonial_header_text ) ) : ?>
							<h2><?php echo esc_html( $testimonial_header_text ); ?></h2>
						<?php endif; ?>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12 ">
						<div class="eshop_home_testimonial__Owl_carousel owl-carousel owl-theme text-white ">
							<?php foreach ( $testimonials as $testimonial ) : ?>
								<div class="item">
									<div class="eshop_testimonial__bg bg-info ">
										<?php if ( ! empty( $testimonial['company_message'] ) ) : ?>
											<?php
											$product_details = $testimonial['company_message'];
											$text_limit      = 180;
											if ( strlen( $product_details ) > $text_limit ) {
												$product_content = substr( $product_details, 0, $text_limit );
												echo sprintf( '<p>%s</p>', $product_content );//phpcs:ignore
											} else {
												echo sprintf( '<p>%s</p>', $product_details );//phpcs:ignore
											}
											?>
										<?php endif; ?>
										<div class="eshop_testimonial_height"></div>
										<div class="eshop_testimonial__details d-flex align-items-center">
											<div class="eshop_testimonial__left">
												<?php
												if ( ! empty( $testimonial['testimonial_image']['url'] ) ) :
													$W_H_attr = ( ! empty( $testimonial['image_custom_dimension'] ) ) ? 'width="' . $testimonial['image_custom_dimension']['width'] . '" height="' . $testimonial['image_custom_dimension']['height'] . '"' : '';//phpcs:ignore
													?>
													<img src="<?php echo esc_url( $testimonial['testimonial_image']['url'] ); ?>" <?php echo $W_H_attr; //phpcs:ignore ?> alt="product link"
														 class="img-fluid <?php echo $testimonial['image_size']; //phpcs:ignore ?>">
												<?php endif; ?>
											</div>
											<div class="eshop_testimonial__right">
												<?php if ( ! empty( $testimonial['company_name'] ) ) : ?>
													<span><?php echo esc_html( $testimonial['company_name'] ); ?></span>
												<?php endif; ?>
												<?php if ( ! empty( $testimonial['company_position'] ) ) : ?>
													<small><?php echo esc_html( $testimonial['company_position'] ); ?></small>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			/* Start aarenet carousel */
			jQuery(document).ready(function($) {
				var image_url = '<?php echo elementor_widget_development()->plugin_url(); //phpcs:ignore ?>';
				var owl = jQuery(".eshop_home_testimonial__Owl_carousel");
				owl.children().each(function (index) {
					jQuery(this).attr("data-position", index); // NB: .attr() instead of .data()
				});
				owl.owlCarousel({
					center: true,
					loop: true,
					dots: false,
					nav: true,
					mouseDrag: false,
					autoplayHoverPause: true,
					autoplay: true,
					animateIn: "fadeIn",
					margin: 4,
					navText: [
						"<img src='" + image_url + "/assets/images/left__Arrow.png'>",
						"<img src='" + image_url + "/assets/images/right__Arrow.png'>",
					],
					responsive: {
						0: {
							items: 1,
							nav: false,
							margin: 6,
							animateIn: false,
						},
						992: {
							items: 3,
						},
					},
				});
				jQuery(document).on("click", ".owl-item>.item", function () {
					let speed = 300;
					owl.trigger("to.owl.carousel", [jQuery(this).data("position"), speed]);
				});

			});
			/* End aarenet carousel */
		</script>

		<?php

	}

	protected function content_template() {
		?>
		<div class="eshop_home_testimonial_carousel">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 eshop_home_testimonial_carousel_top text-center ">
						<h2>{{{ settings.testimonial_header_text}}}</h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="eshop_home_testimonial__Owl_carousel owl-carousel owl-theme text-white ">
							<# if(settings.testimonials ){ #>
							<# _.each(settings.testimonials, function( item, index ) { #>
							<div class="item">
								<div class="eshop_testimonial__bg bg-info">
									<# if( item.company_message ){ #>
										<p>{{{ item.company_message }}}</p>
									<# } #>
								<div class="eshop_testimonial_height"></div>
								<div class="eshop_testimonial__details d-flex align-items-center">
									<div class="eshop_testimonial__left">
										<img src="{{{ item.testimonial_image.url}}}" alt="testimonial-image" width="{{{item.image_custom_dimension.width}}}" height="{{{item.image_custom_dimension.height}}}" class="img-fluid {{{item.image_size}}}">
									</div>
									<div class="eshop_testimonial__right">
										<# if( item.company_name ){#>
											<span>{{{ item.company_name }}}</span>
										<# } #>
										<# if( item.company_position ){#>
										<span>{{{ item.company_position }}}</span>
										<# } #>
									</div>
								</div>
                                </div>
							</div>
							<# });
								}
							#>
						</div>
					</div>
				</div>
			</div>
		</div>
        <script>
            /* Start aarenet carousel */
            jQuery(document).ready(function($) {
                var image_url = '<?php echo elementor_widget_development()->plugin_url(); //phpcs:ignore ?>';
                var owl = jQuery(".eshop_home_testimonial__Owl_carousel");
                owl.children().each(function (index) {
                    jQuery(this).attr("data-position", index); // NB: .attr() instead of .data()
                });
                owl.owlCarousel({
                    center: true,
                    loop: true,
                    dots: false,
                    nav: true,
                    mouseDrag: false,
                    autoplayHoverPause: true,
                    autoplay: true,
                    animateIn: "fadeIn",
                    margin: 4,
                    navText: [
                        "<img src='" + image_url + "/assets/images/left__Arrow.png'>",
                        "<img src='" + image_url + "/assets/images/right__Arrow.png'>",
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            nav: false,
                            margin: 6,
                            animateIn: false,
                        },
                        992: {
                            items: 3,
                        },
                    },
                });
                jQuery(document).on("click", ".owl-item>.item", function () {
                    let speed = 300;
                    owl.trigger("to.owl.carousel", [jQuery(this).data("position"), speed]);
                });

            });
            /* End aarenet carousel */
        </script>
		<?php
	}


}
