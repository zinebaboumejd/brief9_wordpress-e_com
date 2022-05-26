<?php


class mgProducts_carousel extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Blank widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'mgpd_carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve Blank widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('MPD Products Carousel', 'magical-products-display');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Blank widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-carousel';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Blank widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['mpd-productwoo'];
    }

    public function get_keywords()
    {
        return ['mpd', 'woo', 'product', 'carousel', 'slider'];
    }


    /**
     * Register Blank widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->register_content_controls();
        $this->register_style_controls();
        $this->register_advanced_controls();
    }


    /**
     * Register Blank widget content ontrols.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    function register_content_controls()
    {

        $this->start_controls_section(
            'mgpcar_query',
            [
                'label' => esc_html__('Products Query', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_products_filter',
            [
                'label' => esc_html__('Filter By', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => [
                    'recent' => esc_html__('Recent Products', 'magical-products-display'),
                    'featured' => esc_html__('Featured Products', 'magical-products-display'),
                    'best_selling' => esc_html__('Best Selling Products', 'magical-products-display'),
                    'sale' => esc_html__('Sale Products', 'magical-products-display'),
                    'top_rated' => esc_html__('Top Rated Products', 'magical-products-display'),
                    'random_order' => esc_html__('Random Products', 'magical-products-display'),
                    'show_byid' => esc_html__('Show By Id', 'magical-products-display'),
                    'show_byid_manually' => esc_html__('Add ID Manually', 'magical-products-display'),
                ],
            ]
        );

        $this->add_control(
            'mgpcar_product_id',
            [
                'label' => __('Select Product', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mgproducts_display_product_name(),
                'condition' => [
                    'mgpcar_products_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_product_ids_manually',
            [
                'label' => __('Product IDs', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpcar_products_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_products_count',
            [
                'label'   => __('Products Limit', 'magical-products-display'),
                'description' => esc_html__('Set products number for this section', 'magical-products-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgpcar_grid_categories',
            [
                'label' => esc_html__('Product Categories', 'magical-products-display'),
                'description' => esc_html__('Leave Empty For Show All Categories', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mgproducts_display_taxonomy_list(),
                'condition' => [
                    'mgpcar_products_filter!' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_custom_order',
            [
                'label' => esc_html__('Custom order', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Orderby', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'          => esc_html__('None', 'magical-products-display'),
                    'ID'            => esc_html__('ID', 'magical-products-display'),
                    'date'          => esc_html__('Date', 'magical-products-display'),
                    'name'          => esc_html__('Name', 'magical-products-display'),
                    'title'         => esc_html__('Title', 'magical-products-display'),
                    'comment_count' => esc_html__('Comment count', 'magical-products-display'),
                    'rand'          => esc_html__('Random', 'magical-products-display'),
                ],
                'condition' => [
                    'mgpcar_custom_order' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('order', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC'  => esc_html__('Descending', 'magical-products-display'),
                    'ASC'   => esc_html__('Ascending', 'magical-products-display'),
                ],
                'condition' => [
                    'mgpcar_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // Product Content
        $this->start_controls_section(
            'mgpcar_layout',
            [
                'label' => esc_html__('Grid Layout', 'magical-products-display'),
            ]
        );
        $this->add_control(
            'mgpcar_product_style',
            [
                'label'   => __('Grid Style', 'magical-products-display'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __('Style One', 'magical-products-display'),
                    '2'  => __('Style Two', 'magical-products-display'),
                    '3'  => __('Style Three', 'magical-products-display'),
                ]
            ]
        );
        $this->add_control(
            'mgpd_fixd_grid_height',
            [
                'label' => esc_html__('Use Fixed Grid Height', 'magical-products-display'),
                'description' => esc_html__('You can also set image height from the image style section', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Show', 'magical-products-display'),
                'label_off' => esc_html__('Hide', 'magical-products-display'),

            ]
        );
        $this->add_responsive_control(
            'mgpdeg_grid_height',
            [
                'label' => __('Grid Height', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpde-card.mgpdeg-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpd_fixd_grid_height' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
        // Product image
        $this->start_controls_section(
            'mgpcar_img_section',
            [
                'label' => esc_html__('Products Image', 'magical-products-display'),
            ]
        );
        $this->add_control(
            'mgpcar_product_img_show',
            [
                'label'     => __('Show Products image', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_img_size',
            [
                'label' => esc_html__('Image Size', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium_large',
                'options' => [
                    'thumbnail'  => esc_html__('Thumbnail (150px x 150px max)', 'magical-products-display'),
                    'medium'   => esc_html__('Medium (300px x 300px max)', 'magical-products-display'),
                    'medium_large'   => esc_html__('Large (768px x 0px max)', 'magical-products-display'),
                    'large'   => esc_html__('Large (1024px x 1024px max)', 'magical-products-display'),
                    'full'   => esc_html__('Full Size (Original image size)', 'magical-products-display'),
                ],
                'condition' => [
                    'mgpcar_product_img_show' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_img_effects',
            [
                'label' => esc_html__('Image Hover Effects', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'mgpr-hvr-shine',
                'options' => [
                    'mgpr-default'  => esc_html__('No Effects', 'magical-products-display'),
                    'mgpr-hvr-circle'   => esc_html__('Circle Effect', 'magical-products-display'),
                    'mgpr-hvr-shine'   => esc_html__('Shine Effect', 'magical-products-display'),
                    'mgpr-hvr-flashing'   => esc_html__('Flashing Effect', 'magical-products-display'),
                    'mgpr-hvr-hover'   => esc_html__('Opacity Effect', 'magical-products-display'),
                    'mgpr-hvr-blur'   => esc_html__('Blur Effect', 'magical-products-display'),
                    'mgpr-hvr-rotate'   => esc_html__('Rotate Effect', 'magical-products-display'),
                    'mgpr-hvr-slide'   => esc_html__('Slide Effect', 'magical-products-display'),
                    'mgpr-hvr-zoom-out'   => esc_html__('Zoom Out Effect', 'magical-products-display'),
                    'mgpr-hvr-zoom-in'   => esc_html__('Zoom In Effect', 'magical-products-display'),
                ],
                'condition' => [
                    'mgpcar_product_img_show' => 'yes',
                ]

            ]
        );

        $this->end_controls_section();
        // carousel settings
        $this->start_controls_section(
            'mgpcar_navdots_section',
            [
                'label' => __('Nav & Dots', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpcar_dots',
            [
                'label' => __('Slider Dots?', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-products-display'),
                'label_off' => __('No', 'magical-products-display'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_navigation',
            [
                'label' => __('Slider Navigation?', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-products-display'),
                'label_off' => __('No', 'magical-products-display'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpcar_nav_prev_icon',
            [
                'label' => __('Choose Prev Icon', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-left',
                        'arrow-circle-left',
                        'arrow-left',
                        'long-arrow-alt-left',
                        'angle-left',
                        'chevron-circle-left',
                        'fa-chevron-left',
                        'angle-double-left',
                    ],
                    'fa-regular' => [
                        'hand-point-left',
                        'arrow-alt-circle-left',
                        'caret-square-left',
                    ],
                ],
                'condition' => [
                    'mgpcar_navigation' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgpcar_nav_next_icon',
            [
                'label' => __('Choose Next Icon', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-right',
                        'arrow-circle-right',
                        'arrow-right',
                        'long-arrow-alt-right',
                        'angle-right',
                        'chevron-circle-right',
                        'fa-chevron-right',
                        'angle-double-right',
                    ],
                    'fa-regular' => [
                        'hand-point-right',
                        'arrow-alt-circle-right',
                        'caret-square-right',
                    ],
                ],
                'condition' => [
                    'mgpcar_navigation' => 'yes',
                ],

            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'mgpcar_settings_section',
            [
                'label' => __('Carousel Settings', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpcar_products_number',
            [
                'label' => __('Carousel Items', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 1,
                'max' => 100,
                'default' => 3,
                'description' => __('Enter How many items show at a time in the carousel', 'magical-products-display'),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgpcar_products_margin',
            [
                'label' => __('Between Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'default' => [
                    'size' => 30,
                ],
            ]
        );

        $this->add_control(
            'mgpcar_slide_direction',
            [
                'label' => __('Slide Direction', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => __('Horizontal', 'magical-products-display'),
                    'vertical' => __('Vertical', 'magical-products-display'),
                ],
                'default' => 'horizontal',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );


        $this->add_control(
            'mgpcar_autoplay',
            [
                'label' => __('Autoplay?', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-products-display'),
                'label_off' => __('No', 'magical-products-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgpcar_autoplay_delay',
            [
                'label' => __('Autoplay Delay', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 1,
                'max' => 50000,
                'default' => 2500,
                'description' => __('Autoplay Delay in milliseconds', 'magical-products-display'),
                'frontend_available' => true,
                'condition' => [
                    'mgpcar_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'default' => 500,
                'description' => __('Autoplay speed in milliseconds', 'magical-products-display'),
                'condition' => [
                    'mgpcar_autoplay' => 'yes'
                ],
                'frontend_available' => 'true',
            ]
        );

        $this->add_control(
            'mgpcar_loop',
            [
                'label' => __('Infinite Loop?', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-products-display'),
                'label_off' => __('No', 'magical-products-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgpcar_grab_cursor',
            [
                'label' => __('Grab Cursor?', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-products-display'),
                'label_off' => __('No', 'magical-products-display'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );



        $this->end_controls_section();
        // Product Content
        $this->start_controls_section(
            'mgpcar_content',
            [
                'label' => esc_html__('Content Settings', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_show_title',
            [
                'label'     => __('Show Product Title', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-products-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpcar_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_title_tag',
            [
                'label' => __('Title HTML Tag', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
                'condition' => [
                    'mgpcar_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_desc_show',
            [
                'label'     => __('Show Product Description', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );
        $this->add_control(
            'mgpcar_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-products-display'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 15,
                'condition' => [
                    'mgpcar_desc_show' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'mgpcar_price_show',
            [
                'label'     => __('Show Product Price', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'mgpcar_cart_btn',
            [
                'label'     => __('Show button', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_responsive_control(
            'mgpcar_content_align',
            [
                'label' => __('Alignment', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-products-display'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-products-display'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-products-display'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'center',
                'classes' => 'flex-{{VALUE}}',
                'selectors' => [
                    '{{WRAPPER}} .mgpde-card-text.mgpdeg-card-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_meta_section',
            [
                'label' => __('Products Meta', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => 'no',
            ]
        );
        $this->add_control(
            'mgpcar_badge_show',
            [
                'label'     => __('Show Badge', 'magical-products-display'),
                'description'     => __('The badge will show if available.', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpcar_category_show',
            [
                'label'     => __('Show Category', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'mgpcar_ratting_show',
            [
                'label'     => __('Show Ratting', 'magical-products-display'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgpcar_card_button',
            [
                'label' => __('Cart Button', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'mgpcar_cart_btn' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpcar_btn_type',
            [
                'label' => esc_html__('Button type', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cart',
                'options' => [
                    'cart'  => esc_html__('Add to card button', 'magical-products-display'),
                    'view'   => esc_html__('View details', 'magical-products-display'),
                ],

            ]
        );


        $this->add_control(
            'mgpcar_card_text',
            [
                'label'       => __('Button Text', 'magical-products-display'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('View details', 'magical-products-display'),
                'default'     => __('View details', 'magical-products-display'),
                'condition' => [
                    'mgpcar_btn_type' => 'view',
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register Blank widget style ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_style_controls()
    {

        $this->start_controls_section(
            'mgpcar_style',
            [
                'label' => __('Grid style', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpcar_bg_color',
                'label' => esc_html__('Background', 'magical-products-display'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mgpdeg-card',
            ]
        );

        $this->add_control(
            'mgpcar_border_radius',
            [
                'label' => __('Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_content_border',
                'selector' => '{{WRAPPER}} .mgpdeg-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_content_shadow',
                'selector' => '{{WRAPPER}} .mgpdeg-card',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpcar_img_style',
            [
                'label' => __('Image style', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_width_set',
            [
                'label' => __('Width', 'magical-products-display'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'desktop_default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img figure img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mgpcar_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-products-display'),
                'label_off' => __('Off', 'magical-products-display'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpcar_img_height',
            [
                'label' => __('Image Height', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpcar_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_imgbg_height',
            [
                'label' => __('Image div Height', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mgpcar_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_img_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img, {{WRAPPER}} .mgpdeg-card-img figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_img_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpcar_img_bgcolor',
                'label' => esc_html__('Background', 'magical-products-display'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgpdeg-card-img, {{WRAPPER}} .mgpdeg-card-img figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_img_border',
                'selector' => '{{WRAPPER}} .mgpdeg-card-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_desc_style',
            [
                'label' => __('Product Title', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_title_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_title_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_title_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_descb_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_title_typography',
                'label' => __('Typography', 'magical-products-display'),
                'selector' => '{{WRAPPER}} .mgpdeg-card .mgpde-ptitle',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_description_style',
            [
                'label' => __('Description', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_description_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_description_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_description_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_description_typography',
                'label' => __('Typography', 'magical-products-display'),
                'selector' => '{{WRAPPER}} .mgpdeg-card-text p',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpcar_meta_style',
            [
                'label' => __('Products Meta', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpcar_meta_badge',
            [
                'label' => __('Products Badge', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgpcar_meta_badge_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-display-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_meta_badge_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-display-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_badge_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-display-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_badge_bgcolor',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-display-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_badge_typography',
                'label' => __('Typography', 'magical-products-display'),
                'selector' => '{{WRAPPER}} .mgp-display-badge',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_badge_border',
                'selector' => '{{WRAPPER}} .mgp-display-badge',
            ]
        );

        $this->add_control(
            'mgpcar_badge_border_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-display-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_cat',
            [
                'label' => __('Category style', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mgpcar_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text .mgpde-category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-card-text .mgpde-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_meta_cat_typography',
                'label' => __('Typography', 'magical-products-display'),
                'selector' => '{{WRAPPER}} .mgpdeg-card-text .mgpde-category a',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );
        $this->add_control(
            'mgpcar_meta_star',
            [
                'label' => __('Rating Style', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mgpcar_meta_star_color',
            [
                'label' => __('Rating star Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-product-rating .wd-product-ratting i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_meta_starfill_color',
            [
                'label' => __('Rating star Fill Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-product-rating .wd-product-ratting .wd-product-user-ratting i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_btn_style',
            [
                'label' => __('Button', 'magical-products-display'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_btn_padding',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpcar_btn_margin',
            [
                'label' => __('Margin', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpcar_btn_typography',
                'selector' => '{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart,{{WRAPPER}} .mgpdeg-cart-btn a.button',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_btn_border',
                'selector' => '{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart,{{WRAPPER}} .mgpdeg-cart-btn a.button',
            ]
        );

        $this->add_control(
            'mgpcar_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart',
            ]
        );
        $this->add_control(
            'mgpcar_button_color',
            [
                'label' => __('Button color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mgpcar_btn_normal_style',
            [
                'label' => __('Normal', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_btn_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_btn_hover_style',
            [
                'label' => __('Hover', 'magical-products-display'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpcar_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgpdeg-cart-btn a.button:hover,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:hover',
            ]
        );

        $this->add_control(
            'mgpcar_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button:hover, {{WRAPPER}} .mgpdeg-cart-btn a.button:focus,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:hover, {{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button:hover, {{WRAPPER}} .mgpdeg-cart-btn a.button:focus,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:hover, {{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpcar_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgpdeg-cart-btn a.button:hover, {{WRAPPER}} .mgpdeg-cart-btn a.button:focus,{{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:hover, {{WRAPPER}} .mgpdeg-cart-btn a.added_to_cart:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_section_style_arrow',
            [
                'label' => __('Navigation - Arrow', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgpcar_arrow_position_toggle',
            [
                'label' => __('Position', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __('None', 'magical-products-display'),
                'label_on' => __('Custom', 'magical-products-display'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'mgpcar_arrow_positiony',
            [
                'label' => __('Vertical', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 500,
                    ],

                ],

                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_position_x',
            [
                'label' => __('Horizontal', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-container-rtl .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-container-rtl .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'mgpcar_arrow_border',
            [
                'label' => __('Padding', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};width:inherit;height:inherit',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpcar_arrow_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_border_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('mgpcar_tabs_arrow');

        $this->start_controls_tab(
            'mgpcar_tab_arrow_normal',
            [
                'label' => __('Normal', 'magical-products-display'),
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next i, {{WRAPPER}} .swiper-button-prev i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_arrow_bg_color',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_arrow_hover',
            [
                'label' => __('Hover', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_color',
            [
                'label' => __('Text Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_bg_color',
            [
                'label' => __('Background Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpcar_arrow_hover_border_color',
            [
                'label' => __('Border Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpcar_arrow_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgpcar_section_style_dots',
            [
                'label' => __('Navigation - Dots', 'magical-products-display'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_position_y',
            [
                'label' => __('Vertical Position', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, {{WRAPPER}} .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_spacing',
            [
                'label' => __('Spacing', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpcar_dots_nav_align',
            [
                'label' => __('Alignment', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-products-display'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-products-display'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-products-display'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'mgpcar_slide_direction' => 'horizontal',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'mgpcar_dots_width',
            [
                'label' => __('Dots Width', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_dots_height',
            [
                'label' => __('Dots Height', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpcar_dots_border_radius',
            [
                'label' => __('Border Radius', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('mgpcar_tabs_dots');
        $this->start_controls_tab(
            'mgpcar_tab_dots_normal',
            [
                'label' => __('Normal', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_color',
            [
                'label' => __('Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_dots_hover',
            [
                'label' => __('Hover', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_hover_color',
            [
                'label' => __('Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpcar_tab_dots_active',
            [
                'label' => __('Active', 'magical-products-display'),
            ]
        );

        $this->add_control(
            'mgpcar_dots_nav_active_color',
            [
                'label' => __('Color', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register Blank widget Advanced ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_advanced_controls()
    {
        $this->start_controls_section(
            'mgpdc_attr_sec',
            [
                'label' => __('Magical Attributes', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $this->add_control(
            'mgpdc_attr_calss',
            [
                'label' => __('Custom Class', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'mgpdc_attr_id',
            [
                'label' => __('Custom ID', 'magical-products-display'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpdc_custom_css_sec',
            [
                'label' => __('Magical Custom CSS', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );
        $this->add_control(
            'mgpdc_custom_css',
            [
                'label' => __('Custom CSS', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::CODE,
                'language' => 'css',
                'rows' => 20,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render Blank widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $mgpcar_filter = $this->get_settings('mgpcar_products_filter');
        $mgpcar_products_count = $this->get_settings('mgpcar_products_count');
        $mgpcar_custom_order = $this->get_settings('mgpcar_custom_order');
        $mgpcar_grid_categories = $this->get_settings('mgpcar_grid_categories');
        $orderby = $this->get_settings('orderby');
        $order = $this->get_settings('order');


        // Query Argument
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $mgpcar_products_count,
        );

        switch ($mgpcar_filter) {

            case 'sale':
                $args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
                break;

            case 'featured':
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
                break;

            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';
                break;

            case 'top_rated':
                $args['meta_key']   = '_wc_average_rating';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';
                break;

            case 'random_order':
                $args['orderby']    = 'rand';
                break;

            case 'show_byid':
                $args['post__in'] = $settings['mgpcar_product_id'];
                break;

            case 'show_byid_manually':
                $args['post__in'] = explode(',', $settings['mgpcar_product_ids_manually']);
                break;

            default: /* Recent */
                $args['orderby']    = 'date';
                $args['order']      = 'desc';
                break;
        }

        // Custom Order
        if ($mgpcar_custom_order == 'yes') {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        if (!(($mgpcar_filter == "show_byid") || ($mgpcar_filter == "show_byid_manually"))) {

            $product_cats = str_replace(' ', '', $mgpcar_grid_categories);
            if ("0" != $mgpcar_grid_categories) {
                if (is_array($product_cats) && count($product_cats) > 0) {
                    $field_name = is_numeric($product_cats[0]) ? 'term_id' : 'slug';
                    $args['tax_query'][] = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'terms' => $product_cats,
                            'field' => $field_name,
                            'include_children' => false
                        )
                    );
                }
            }
        }

        $mgpcar_show_title = $settings['mgpcar_show_title'];
        $mgpcar_crop_title = $settings['mgpcar_crop_title'];
        $mgpcar_title_tag  = $settings['mgpcar_title_tag'];
        $mgpcar_desc_show  = $settings['mgpcar_desc_show'];
        $mgpcar_crop_desc  = $settings['mgpcar_crop_desc'];
        $mgpcar_price_show = $settings['mgpcar_price_show'];
        $mgpcar_cart_btn   = $settings['mgpcar_cart_btn'];
        $mgpcar_category_show = $settings['mgpcar_category_show'];
        $mgpcar_ratting_show  = $settings['mgpcar_ratting_show'];
        $mgpcar_badge_show    = $settings['mgpcar_badge_show'];
        $mgpcar_content_align = $settings['mgpcar_content_align'];
        $mgpcar_btn_type      = $settings['mgpcar_btn_type'];
        $mgpcar_card_text     = $settings['mgpcar_card_text'];

        //grid layout
        $mgpcar_product_style = $this->get_settings('mgpcar_product_style');
        // grid content
        $mgpcar_product_img_show = $this->get_settings('mgpcar_product_img_show');


        if ($mgpcar_content_align == 'center') {
            $rating_class = 'flex-center';
        } elseif ($mgpcar_content_align == 'right') {
            $rating_class = 'flex-right';
        } else {
            $rating_class = 'flex-left';
        }

        $mgpcar_products = new WP_Query($args);
        $mgp_unque_num = rand('8652397', '5832471');
?>

        <div <?php if ($settings['mgpdc_attr_id']) : ?> id="<?php echo esc_attr($settings['mgpdc_attr_id']); ?>" <?php endif; ?> class="mgp-unique<?php echo esc_attr($mgp_unque_num); ?> mgproductd-grid <?php echo esc_attr($settings['mgpdc_attr_calss']); ?>">
            <?php if ($settings['mgpdc_custom_css']) : ?>
                <style>
                    <?php echo esc_html($settings['mgpdc_custom_css']); ?>
                </style>
            <?php endif; ?>
            <?php
            if ($mgpcar_products->have_posts()) :
            ?>

                <div id="mgpdeg-items" class="mgproductd mgpde-items style<?php echo esc_attr($mgpcar_product_style); ?>">
                    <div class="mgproductd mgpc-pcarousel swiper-container" data-loop="<?php echo esc_attr($settings['mgpcar_loop']); ?>" data-number="<?php echo esc_attr($settings['mgpcar_products_number']); ?>" data-margin="<?php echo esc_attr($settings['mgpcar_products_margin']['size']); ?>" data-direction="<?php echo esc_attr($settings['mgpcar_slide_direction']); ?>" data-autoplay="<?php echo esc_attr($settings['mgpcar_autoplay']); ?>" data-auto-delay="<?php echo esc_attr($settings['mgpcar_autoplay_delay']); ?>" data-speed="<?php echo esc_attr($settings['mgpcar_autoplay_speed']); ?>" data-grab-cursor="<?php echo esc_attr($settings['mgpcar_grab_cursor']); ?>" data-nav="<?php echo esc_attr($settings['mgpcar_navigation']); ?>" data-dots="<?php echo esc_attr($settings['mgpcar_dots']); ?>">
                        <div class="swiper-wrapper">
                            <?php while ($mgpcar_products->have_posts()) : $mgpcar_products->the_post(); ?>
                                <div class="swiper-slide no-load">
                                    <div class="mgpde-shadow mgpde-card mgpdeg-card mb-4 mgpde-has-hover">
                                        <?php if ($mgpcar_product_img_show == 'yes') : ?>
                                            <div class="mgpde-card-img mgpdeg-card-img <?php echo esc_attr($settings['mgpcar_img_effects']); ?>">
                                                <?php
                                                if (class_exists('WooCommerce') && $mgpcar_badge_show == 'yes') {
                                                    mgproducts_display_products_badge();
                                                }
                                                ?>
                                                <figure>
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail($settings['mgpcar_img_size']); ?>
                                                    </a>
                                                </figure>
                                                <?php if ($mgpcar_cart_btn == 'yes' && $mgpcar_product_style == '2') : ?>
                                                    <div class="woocommerce mgpdeg-cart-btn">
                                                        <?php if ($mgpcar_btn_type == 'cart') : ?>
                                                            <?php woocommerce_template_loop_add_to_cart(); ?>
                                                        <?php else : ?>
                                                            <a class="button " href="<?php the_permalink(); ?>"><?php echo esc_html($mgpcar_card_text); ?></a>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php $this->products_content($settings); ?>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                            ?>
                        </div>
                        <?php if ($settings['mgpcar_dots']) : ?>
                            <div class="swiper-pagination mgpcar-btn"></div>
                        <?php endif; ?>

                        <?php if ($settings['mgpcar_navigation']) : ?>
                            <div class="swiper-button-prev mgpcar-nav">
                                <?php \Elementor\Icons_Manager::render_icon($settings['mgpcar_nav_prev_icon']); ?>
                            </div>
                            <div class="swiper-button-next mgpcar-nav">
                                <?php \Elementor\Icons_Manager::render_icon($settings['mgpcar_nav_next_icon']); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php else : ?>
                <div class="alert alert-danger text-center mt-5 mb-5" role="alert">
                    <?php echo esc_html('No Products found this query. Please try another way!!', 'magical-posts-display'); ?>
                </div>


            <?php
            endif;
            ?>
        </div>
    <?php

    } // 



    public function products_content($settings)
    {
        global $product;
        $rating_count = $product->get_rating_count();
        $mgpcar_product_style = $settings['mgpcar_product_style'];
        $mgpcar_show_title = $settings['mgpcar_show_title'];
        $mgpcar_crop_title = $settings['mgpcar_crop_title'];
        $mgpcar_title_tag  = $settings['mgpcar_title_tag'];
        $mgpcar_desc_show  = $settings['mgpcar_desc_show'];
        $mgpcar_crop_desc  = $settings['mgpcar_crop_desc'];
        $mgpcar_price_show = $settings['mgpcar_price_show'];
        $mgpcar_cart_btn   = $settings['mgpcar_cart_btn'];
        $mgpcar_category_show = $settings['mgpcar_category_show'];
        $mgpcar_ratting_show  = $settings['mgpcar_ratting_show'];
        $mgpcar_badge_show    = $settings['mgpcar_badge_show'];
        $mgpcar_content_align = $settings['mgpcar_content_align'];
        $mgpcar_btn_type      = $settings['mgpcar_btn_type'];
        $mgpcar_card_text     = $settings['mgpcar_card_text'];
    ?>
        <div class="mgpde-card-text mgpdeg-card-text mgp-text-style<?php echo esc_attr($mgpcar_product_style); ?>">
            <?php if ($mgpcar_category_show == 'yes' && $mgpcar_product_style != '2') : ?>
                <div class="mgpde-meta mgpde-category">
                    <?php mgproducts_display_product_category(); ?>
                </div>
            <?php endif; ?>
            <?php if ($mgpcar_ratting_show && $mgpcar_product_style == '2') : ?>
                <div class="mg-rating-out">
                    <?php echo mgproducts_display_wc_get_rating_html(); ?>
                    <?php mgproducts_display_wc_rating_number(); ?>
                </div>
            <?php endif; ?>
            <?php if ($mgpcar_show_title == 'yes') : ?>
                <a class="mgpde-ptitle-link" href="<?php the_permalink(); ?>">
                    <?php
                    printf(
                        '<%1$s class="mgpde-ptitle">%2$s</%1$s>',
                        tag_escape($mgpcar_title_tag),
                        wp_trim_words(get_the_title(), $mgpcar_crop_title)
                    );
                    ?>
                </a>
            <?php endif; ?>
            <?php if ($mgpcar_category_show == 'yes' && $mgpcar_product_style == '2') : ?>
                <div class="mgpde-meta mgpde-category">
                    <?php mgproducts_display_product_category(); ?>
                </div>
            <?php endif; ?>
            <?php if ($mgpcar_ratting_show && $mgpcar_product_style != '2') : ?>
                <div class="mg-rating-out">
                    <?php echo mgproducts_display_wc_get_rating_html(); ?>
                    <?php mgproducts_display_wc_rating_number(); ?>
                </div>
            <?php endif; ?>
            <?php if ($mgpcar_desc_show) : ?>
                <p><?php echo wp_trim_words(get_the_content(), $mgpcar_crop_desc, '...'); ?></p>
            <?php endif; ?>
            <?php if ($mgpcar_price_show == 'yes' && $mgpcar_product_style != '3') : ?>
                <div class="mgpdeg-product-price mb-2">
                    <?php woocommerce_template_loop_price(); ?>
                </div>
            <?php endif; ?>
            <?php if ($mgpcar_cart_btn == 'yes' && $mgpcar_product_style == '1') : ?>
                <div class="woocommerce mgpdeg-cart-btn">
                    <?php if ($mgpcar_btn_type == 'cart') : ?>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    <?php else : ?>
                        <a class="button " href="<?php the_permalink(); ?>"><?php echo esc_html($mgpcar_card_text); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (($mgpcar_price_show == 'yes' ||  $mgpcar_cart_btn == 'yes')  && $mgpcar_product_style == '3') : ?>
                <div class="mgpdeg-price-btn mb-2 mt-2">
                    <?php
                    if ($mgpcar_price_show == 'yes') {
                        woocommerce_template_loop_price();
                    }
                    ?>
                    <?php if ($mgpcar_cart_btn == 'yes') : ?>
                        <div class="woocommerce mgpdeg-cart-link">
                            <?php if ($mgpcar_btn_type == 'cart') : ?>
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            <?php else : ?>
                                <a class="button " href="<?php the_permalink(); ?>"><?php echo esc_html($mgpcar_card_text); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>


<?php
    } // products content






}
