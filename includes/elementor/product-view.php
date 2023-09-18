<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_base;
use Elementor\Repeater;

class Product_View extends Widget_Base {

	public function get_name() {
		return 'eshop-product-view';
	}

	public function get_title() {
		return __( 'Product view', '' );
	}

	public function get_icon() {
		return 'eicon-preview-medium';
	}

	public function get_categories() {
		return array( 'eshop-custom-category' );
	}

	public function get_style_depends() {
		return array( 'product-view' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'elementor-widget-developments' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'product_name',
			array(
				'label'   => esc_html__( 'Select product', '' ),
				'type'    => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->get_all_products(),
				'default' => '',
			)
		);

		$this->add_control(
			'product_image',
			array(
				'label'   => esc_html__( 'Product image', '' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					\Elementor\Utils::get_placeholder_image_src(),
				),
			),
		);

		$this->add_control(
			'show_price',
			array(
				'label'        => __( 'Show price', '' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', '' ),
				'label_off'    => __( 'Hide', '' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_badge',
			array(
				'label'        => __( 'Show badge', '' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', '' ),
				'label_off'    => __( 'Hide', '' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'badge_title',
			array(
				'label'     => __( 'Badge Title', '' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'condition' => array(
					'show_badge' => 'yes',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'      => 'badge_background',
				'label'     => __( 'Badge Background', '' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .product_extra_info',
				'condition' => array(
					'show_badge' => 'yes',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			array(
				'label' => __( 'Style', '' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', '' ),
				'scheme'   => Global_Typography::TYPOGRAPHY_PRIMARY,
				'selector' => '{{WRAPPER}} .title',
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'label'    => __( 'Price Typography', '' ),
				'scheme'   => Global_Typography::TYPOGRAPHY_PRIMARY,
				'selector' => '{{WRAPPER}} .price',
			)
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$product_id  = $settings['product_name'];
		$image       = $settings['product_image'] ?? array();
		$badge_title = $settings['badge_title'] ?? '';
		$show_price  = $settings['show_price'] ?? '';
		$show_badge  = $settings['show_badge'] ?? '';
		if ( '' !== $product_id ) {
			?>

		<div class="product">
			<?php
				$product_image = isset( $image ) ? $image['url'] : get_the_post_thumbnail_url( $product_id );

			?>
			<div class="product_image">
				<a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>">
					<img decoding="async" src="<?php echo esc_url( $product_image ); ?>" alt="">
				</a>
			</div>
			<!-- /.product_image-->
			<?php if ( 'yes' == $show_badge ) { ?>
				<div class="product_extra_info">
					<span class="badge"><?php echo esc_html( $badge_title ); ?></span>
				</div>
			<?php } ?>
			<!-- /.product_extra_info -->
			<div class="product_info">
				<div class="title">
					<a href="<?php echo esc_url( get_the_permalink( $product_id ) ); ?>"><?php echo get_the_title( $product_id ); ?></a>
				</div>
				<!-- /.title -->
				<?php if ( 'yes' == $show_price ) { ?>
				<div class="price"><?php echo wc_price( get_post_meta( $product_id, '_regular_price', true ) ); ?></div>
				<!-- /.price -->
				<?php } ?>
			</div>
			<!-- /.product_info -->
		</div>
			<?php
		}
	}

	public function get_all_products() {
		$all_products = get_posts(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
			)
		);

		$products = array();
		if ( is_array( $all_products ) && count( $all_products ) ) {
			foreach ( $all_products as $single ) {
				$products[ $single->ID ] = $single->post_title;
			}
		}

		return $products;
	}



}
