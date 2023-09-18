<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_base;
use Elementor\Repeater;
class Custom_Sliders extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Sliders widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'eshop-custom-sliders';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Sliders widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Eshop custom sliders', 'elementor-widget-developments' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Sliders widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slider-3d';
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
	 * Retrieve the list of categories the Sliders widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Get widget styles dependencies.
	 *
	 * Retrieve the list of style the slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget styles
	*/
	public function get_style_depends() {
		return array( 'owl-carousel-min', 'owl-carousel-theme-default', 'custom-slider' );
	}

	/**
	 * Get widget scripts dependencies.
	 *
	 * Retrieve the list of scripts the slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget styles
	 */
	public function get_script_depends() {
		return array( 'owl-carousel-scripts' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Sliders widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'sliders', 'url', 'link' );
	}
	/**
	 * Register Sliders widget controls.
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

		$repeater = new Repeater();
		$repeater->add_control(
			'slider_image',
			array(
				'label'   => esc_html__( 'Choose image', 'elementor-widget-developments' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					\Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'slider_image',
				'default'   => 'medium',
				'separator' => 'none',
			)
		);

		$repeater->add_control(
			'caption',
			array(
				'label'       => esc_html__( 'Image Caption', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			)
		);

		$this->add_control(
			'sliders',
			array(
				'label'       => esc_html__( 'Sliders', 'elementor-widget-developments' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'caption' => __( 'Caption', 'elementor-widget-developments' ),
					),
				),
				'title_field' => '{{{ caption }}}',
			),
		);

		$this->end_controls_section();
	}

	/**
	 * Render Sliders widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		extract( $this->get_settings_for_display() );
		$image_url = elementor_widget_development()->plugin_url();
		?>
		<div class="eshop__image__gallery__area">
			<div class="container-fluid ">
				<div class="row">
					<div class="col-md-12 ">
						<?php
						$galleryCarouselClass = count( $sliders ) > 2 ? ' eshop__gallery__slider owl-carousel owl-theme' : ' eshop__gallery__images';
						?>
						<div class="eshop__gallery__carousel<?php echo $galleryCarouselClass; ?>">
							<?php
							$i = 0;
							foreach ( $sliders as $slide ) :
								$i++;
								?>
								<div class="item">
									<div class="eshop__gallery_photo" >
										<?php
										if ( isset( $slide['slider_image']['url'] ) && ! empty( $slide['slider_image']['url'] ) ) :
											$W_H_attr = ( ! empty( $slide['image_custom_dimension'] ) ) ? 'width="' . $slide['image_custom_dimension']['width'] . '" height="' . $slide['image_custom_dimension']['height'] . '"' : '';
											?>
											<img photo_data="<?php echo $slide['slider_image']['url']; ?>"  src="<?php echo $slide['slider_image']['url']; ?>" <?php echo $W_H_attr; ?> alt="" onclick="openModal(); currentSlide(<?php echo $i; ?>)" class="img-fluid eshop-gallery-photo <?php echo $slide['image_size']; ?>">
										<?php endif; ?>
										<?php if ( isset( $slide['caption'] ) && ! empty( $slide['caption'] ) ) : ?>
											<p><?php echo $slide['caption']; ?></p>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="eshopModal" class="eshop__gallery__popup__area">
			<div class="eshop__gallery__popup_main">
				<div class="eshop__gallery__popup_crose">
					<img src="<?php echo $image_url; ?>/assets/images/shop_mobile_cross_icon.png" onclick="closeModal()" alt="">
				</div>
				<div class="eshop-gallery-modal-content">
					<?php foreach ( $sliders as $slide ) : ?>
						<div class="eshop__gallery__popup_img">
							<?php
							if ( isset( $slide['slider_image']['url'] ) && ! empty( $slide['slider_image']['url'] ) ) :
								$W_H_attr = ( ! empty( $slide['image_custom_dimension'] ) ) ? 'width="' . $slide['image_custom_dimension']['width'] . '" height="' . $slide['image_custom_dimension']['height'] . '"' : '';
								?>
								<img src="<?php echo $slide['slider_image']['url']; ?>" <?php echo $W_H_attr; ?> alt="" >
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php if ( count( $sliders ) > 1 ) { ?>
						<a class="prev" onclick="plusSlides(-1)"><img src="<?php echo $image_url; ?>/assets/images/left-arrow.png" alt=""></a>
						<a class="next" onclick="plusSlides(1)"><img src="<?php echo $image_url; ?>/assets/images/right-arrow.png" alt=""></a>
					<?php } ?>
				</div>
			</div>
		</div>

		<script>
			/* Start eshop gallery carousel */
			jQuery(document).ready(function($) {
                var image_url = '<?php echo elementor_widget_development()->plugin_url(); //phpcs:ignore ?>';
				jQuery(".eshop__gallery__slider").on("dragged.owl.carousel translated.owl.carousel initialized.owl.carousel", function(e) {
					jQuery(".center").prev().addClass("left-of-center");
					jQuery(".center").next().addClass("right-of-center");
				});

				jQuery(".eshop__gallery__slider").on("drag.owl.carousel", function(e) {
					jQuery(".left-of-center").removeClass("left-of-center");
					jQuery(".right-of-center").removeClass("right-of-center");
				});
				jQuery(".eshop__gallery__slider").owlCarousel({
					loop: true,
					margin: 4,
					center: true,
					autoplay: true,
					nav: true,
					dots:false,
					mouseDrag: false,
					autoplayTimeout:8000,
					autoplayHoverPause:true,
					smartSpeed: 600,
					navText: ["<img src='"+image_url+"/assets/images/left__Arrow.png'>", "<img src='"+image_url+"/assets/images/right__arrow.png'>"],
					responsive: {
						0:{
							items: 1,
						},
						992:{
							items: 3,

						}
					}
				});

				jQuery(".eshop__gallery__slider").on("translate.owl.carousel", function(e) {
					jQuery(".left-of-center").removeClass("left-of-center");
					jQuery(".right-of-center").removeClass("right-of-center");
				});

			});
			/* End eshop gallery carousel */
		</script>
		<script>
			function openModal() {
				document.getElementById("eshopModal").style.display = "block";
			}

			function closeModal() {
				document.getElementById("eshopModal").style.display = "none";
			}

			var slideIndex = 1;
			showSlides(slideIndex);

			function plusSlides(n) {
				showSlides(slideIndex += n);
			}

			function currentSlide(n) {
				showSlides(slideIndex = n);
			}

			function showSlides(n) {
				var i;
				var slides = document.getElementsByClassName("eshop__gallery__popup_img");
				if (n > slides.length) {slideIndex = 1}
				if (n < 1) {slideIndex = slides.length}
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}
				slides[slideIndex-1].style.display = "block";
			}
		</script>
		<?php
	}

}
