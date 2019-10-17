<?php
/**
* Do things related with Slider Block
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Slider' ) ) {
	class CB_Slider extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'post-slider';

		/**
		* To store Array of this blocks
		*
		* @access protected
		* @since 1.0.0
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @var object
		*/
		private static $instance;

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*/
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

	   /**
		* Enqueue Common Scripts and Styles
		* Called in enqueue_block_assets hook
		* Fires in frontend and backend
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function block_assets(){

			$scripts = array(
				array(
					'handler' => 'slick',
					'style'   => 'vendors/slick/slick.css',
					'version' => '1.8.1',
				),
				array(
					'handler' => 'slick-theme',
					'style'   => 'vendors/slick/slick-theme.css',
					'version' => '1.8.1',
				)
				
			);	

			$this->check_enqueue_block_assets( $scripts );

		}

	   /**
		* Enqueue Frontend Scripts and Styles
		* Called in wp_enqueue_scripts hook
		* Fires in frontend
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function enqueue_scripts_styles(){
			if( count( $this->blocks ) > 0 ){
				$scripts = array(
					array(
						'handler'    => 'slick',
						'script'     => 'vendors/slick/slick.min.js',
						'version'    => '1.8.1',
						'dependency' => array( 'jquery' )
					)
				);
				$scripts = apply_filters( $this->block_name . '_frontend_assets', $scripts );
				self::enqueue( $scripts );
			}
		}

	   /**
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles(){ 
			
			foreach( $this->blocks as $block ){

				$attrs = self::get_attrs_with_default( $block[ 'attrs' ] );
				
				$dynamic_css = array(
					array(
						'selector' => '.cb-block__post-title',
						'props' => array(
							'color' => 'headingColor',
							'font-size' => 'headingSize',
							'margin-bottom' => 'headingSpacing',
						)
					),
					array(
						'selector' => '.cb-block__slider-overlay',
						'props' => array(
							'background-color' => 'bgOverlayColor',
							'opacity' => 'bgOverlayOpacity'
						)
					),
					array(
						'selector' => '.cb-block__slider-wrapper',
						'props' => array(
							'background-position' => 'bgPosition',
							'min-height' => 'height'
						)
					),
					array(
						'selector' => '.cb-block__post-text',
						'props' => array(
							'font-size' => 'excerptSize',
							'color' => 'excerptColor',
							'margin-bottom' => 'excerptSpacing',
						)
					),
					array(
						'selector' => '.cb-block__post-meta',
						'props' => array(
							'color' => 'metaColor',
							'margin-bottom' => 'metaSpacing',
						)
					),
					array(
						'selector' => '.cb-block__post-meta-category',
						'props' => array(
							'margin-bottom' => 'categorySpacing',
							'color' => 'metaColor',
						)
					),
					array(
						'selector' => '.cb-block__post-slider button.slick-arrow',
						'props' => array(
							'color' => 'arrowColor',
							'background' =>  $attrs[ 'arrowStyle'] == 'background' ? 'arrowBgColor' : false,
							'border-color' => 'borderColor'
						)
					),
					array(
						'selector' => '.cb-block__post-slider article.cb-block__post',
						'props' => array(
							'border-color' => $attrs[ 'arrowStyle'] == 'background' ? 'arrowBgColor' : 'borderColor',
						)
					)
				);
				if( $attrs[ 'moreText' ] ){

					$dynamic_css[] = array(
						'selector' => '.cb-block__button-wrapper',
						'props' => array(
							'margin-bottom' => 'moreTextSpacing',
						)
					);

					$dynamic_css[] = array(
						'selector' => '.cb-block__button-wrapper .cb-block-button',
						'props' => array(
							'font-size' => 'moreTextSize',
							'color' => 'moreTextColor',
						)
					);

					$dynamic_css[] = array(
						'selector' => '.cb-block__button-wrapper .cb-block-button:hover',
						'props' => array(
							'color' => 'moreTextHoverColor',
						)
					);
				}

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
				));

				$control  = $attrs[ 'control' ];
				$autoplay = $attrs[ 'autoPlay' ] ? 1 : 0;
				$infinite = $attrs[ 'infiniteLoop' ] ? 1 : 0;
				ob_start();

				$dots = false;
				$arrows = false;
				if( $control == 'arrow' ){
					$arrows = true;
				}else if( $control == 'dots' ){
					$dots = true;
				}else if( $control == 'both' ){
					$arrows = true;
					$dots   = true;
				}
				?>
				var cb_slider_args = {
				 	slidesToShow: <?php echo esc_attr( $attrs[ 'perSlide' ] ); ?>,
				 	slidesToScroll: <?php echo esc_attr( $attrs[ 'perSlide' ] ); ?>,
				 	autoplay: <?php echo esc_attr( $autoplay ); ?>,
				 	infinite: <?php echo esc_attr( $infinite ); ?>,
				 	autoplaySpeed: <?php echo esc_attr( $attrs[ 'duration' ] ); ?> * 1000,
				 	prevArrow: '<button type="button" class="slick-next"></button>',
				 	nextArrow:'<button type="button" class="slick-prev"></button>',
				 	arrows: <?php if( $arrows){ ?>true<?php }else{ ?>false<?php } ?>,
				 	dots: <?php if( $dots){ ?>true<?php }else{ ?>false<?php } ?>,
				 	adaptiveHeight: true
				};
				jQuery('#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .cb-block__post-slider').slick( cb_slider_args );
				<?php
				$js =  ob_get_clean();
				self::add_scripts( $js );
			}
		}

	   /**
		* Returns attributes for this Block
		*
		* @access public
		* @since 1.0.0
		* @return array
		*/
		protected function get_attrs(){
			return array(

				# Hidden setting
				'block_id' => array(
					'type' => 'string',
				),
				'align' => array(
					'type'    => 'string',
					'default' => 'center'
				),
				'textAlign' => array(
					'type'    => 'string',
					'default' => 'center'
				),
				# Slider Setting
				'postsToShow'     => array(
					'type'    => 'number',
					'default' => 5,
				),
				'perSlide' => array(
					'type' => 'number',
					'default' => 1
				),
				'layout' => array(
					'type' => 'string',
					'default' => 'layout-1'
				),
				'contentPosition' => array(
					'type' => 'string',
					'default' => 'center'
				),
				'autoPlay' => array(
					'type' => 'boolean',
					'default' => false
				),
				'infiniteLoop' => array(
					'type' => 'boolean',
					'default' => false
				),
				'duration' => array(
					'type' => 'number',
					'default' => 7
				),

				# Post Setting
				'order'           => array(
					'type'    => 'string',
					'default' => 'desc',
				),
				'orderBy'         => array(
					'type'    => 'string',
					'default' => 'date',
				),
				'categories' => array(
					'type' => 'string',
				),

				# Control Setting
				'control' => array(
					'type' => 'string',
					'default' => 'both'
				),
				'controlPosition' => array(
					'type' => 'string',
					'default' => 'mid-bottom'
				),
				'arrowStyle' => array(
					'type' => 'string',
					'default' => 'solid'
				),
				'arrowSize' => array(
					'type' => 'number',
					'default' => 20
				),
				'arrowRadius' => array(
					'type' => 'number',
					'default' => 100
				),
				'dotSize' => array(
					'type' => 'number',
					'default' => 0
				),
				'arrowColor' => array(
					'type' => 'string'
				),
				'arrowBgColor' => array(
					'type' => 'string'
				),
				'borderColor' => array(
					'type' => 'string'
				),


				# Image Setting
				'image' => array(
					'type' => 'boolean',
					'default' => true,
				),
				'imagePosition' => array(
					'type' => 'string',
					'default' => 'background'
				),
				'bgPosition' => array(
					'type' => 'string',
					'default' => 'center center'
				),
				'imageSize' => array(
					'type' => 'string',
					'default' => 'large',
				),
				'bgOverlayColor' => array(
					'type' => 'string'
				),
				'bgOverlayOpacity' => array(
					'type' => 'number',
					'default' => 0
				),

				# Content Settings
				'showExcerpt' => array(
					'type' => 'boolean',
					'default' => true
				),
				'excerptLength' => array(
					'type' => 'number',
					'default' => 25
				),
				'moreText' => array(
					'type' => 'boolean',
					'default' => true
				),
				'displayPostDate' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostAuthor' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostComment' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostCategory' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'displayPostFormat' => array(
					'type'    => 'boolean',
					'default' => true,
				),

				# Typography
				'tag' => array(
					'type' => 'string',
					'default' => 'h3'
				),
				'headingSize' => array(
					'type' => 'number',
				),
				'excerptSize' => array(
					'type' => 'number',
				),
				'moreTextSize' => array(
					'type' => 'number',
				),

				# Color Setting
				'headingColor' => array(
					'type' => 'string'
				),
				'metaColor' => array(
					'type' => 'string'
				),
				'excerptColor' => array(
					'type' => 'string'
				),
				'moreTextColor' => array(
					'type' => 'string'
				),
				'moreTextHoverColor' => array(
					'type' => 'string'
				),

				# Spacing Setting
				'categorySpacing' => array(
					'type' => 'string'
				),
				'headingSpacing' => array(
					'type' => 'string'
				),
				'metaSpacing' => array(
					'type' => 'string'
				),
				'excerptSpacing' => array(
					'type' => 'string'
				),
				'moreTextSpacing' => array(
					'type' => 'string'
				),
				'height' => array(
					'type' => 'number',
					'default' => 450
				)
			);
		}

	   /**
		* Renders blocks in frontend
		*
		* @access public
		* @since 1.0.0
		* @return string
		*/
		public function render( $attrs, $content ){
			
			$block_content = '';
			$args = array(
				'posts_per_page' => $attrs['postsToShow'],
				'post_status'    => 'publish',
				'order'          => $attrs['order'],
				'orderby'        => $attrs['orderBy'],
			);

			if ( isset( $attrs['categories'] ) ) {
				$args['category'] = $attrs['categories'];

				$_cat = get_category( absint( $attrs[ 'categories' ] ) );
				$cat = self::make_category_arr( $_cat );
			}


			$query = new WP_Query( $args );

			if( $query->have_posts() ):
				ob_start();

				$cls = array(
					'cb-block__post-grid',
					'cb-items-per-slide-' . esc_attr( $attrs[ 'perSlide' ] ) . '',
					'cb-block__' . esc_attr( $attrs[ 'layout' ] ) . '',
					'cb-block__content-position-'. esc_attr( $attrs[ 'contentPosition' ] ).'',
					'cb-block__control-position-'. esc_attr( $attrs[ 'controlPosition' ] ).'',
					'cb-block__arrow-style-'. esc_attr( $attrs[ 'arrowStyle' ] ).'',
					'cb-block__arrow-size-'. esc_attr( $attrs[ 'arrowSize' ] ).'',
					'cb-block__arrow-radius-'.$attrs[ 'arrowRadius' ].'',
					'cb-block__dot-size-'.esc_attr( $attrs[ 'dotSize' ] ).'',
					'cb-' . esc_attr( $attrs[ 'textAlign' ] ),
					'align' . esc_attr( $attrs[ 'align' ] )
				);
				?>
				<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>" class="<?php self::classnames( $cls ); ?>">
					<div class="cb-block__post-slider">
						<?php while( $query->have_posts() ): ?>
							<?php $query->the_post(); ?>
							<?php
								$image = false;
								$style = '';
								if( $attrs[ 'image' ] && has_post_thumbnail() ){
									$image = get_the_post_thumbnail_url( get_the_ID(), $attrs[ 'imageSize' ] );
									$style = ' style="background-image: url('.esc_url( $image ).')"';	
								}

								$text = get_the_excerpt();

								if( !isset( $attrs[ 'categories' ] ) ){
						    		$_cat = get_the_category();
						    		$cat = self::make_category_arr( $_cat[ 0 ] );
						    	}
							?>
							<div class="cb-block__slider-item" >
								<div class="cb-block__slider-wrapper" <?php echo $style; ?>>
									<div class="cb-block__slider-overlay"></div>	
									<article class="cb-block__post aligment-<?php echo esc_attr( $attrs[ 'textAlign' ] ); ?>">
										<div class="cb-block__post-content">
											<?php if( $attrs[ 'displayPostCategory' ] ): ?>
												<div class="cb-block__post-meta-category" >
												    <a href="<?php echo esc_url( $cat[ 'link' ] ); ?>">
												        <span><?php echo $cat[ 'name' ]; ?></span>
												    </a>
												</div>
											<?php endif; ?>

											<<?php echo $attrs[ 'tag' ] ?> class="cb-block__post-title">
												<a href="<?php the_permalink(); ?>">
													<?php the_title(); ?>	
												</a>
											</<?php echo $attrs[ 'tag' ] ?>>

											<div class="cb-block__post-meta">
												<?php if( $attrs[ 'displayPostAuthor' ] ): ?>
													<div class="cb-block__post-meta-author">
														<a href="<?php the_author_link(); ?>">
															<span class="icon far fa-user"></span>
															<?php echo get_the_author_link(); ?>
														</a>
													</div>
												<?php endif; ?>

												<?php if( $attrs[ 'displayPostDate' ] ): ?>
													<div class="cb-block__post-meta-date">
														 <a href="<?php echo esc_url( self::get_date_link() ); ?>" target="_blank">
															<span class="icon far fa-clock"></span>
															<span class="cb-block__date-format">
																<?php echo get_the_date(); ?>
															</span>
														</a>
													</div>
												<?php endif; ?>

												<?php if( $attrs[ 'displayPostComment' ] ): ?>
													<div class="cb-block__post-meta-comment">
														<a href="<?php comments_link(); ?>">
															<span class="icon far fa-comment-dots"></span>
															<span class="cb-block__comment-count">
																<?php echo self::get_total_comment( get_the_ID() ); ?>
															</span>
														</a>
													</div>
												<?php endif; ?>
											</div>
											
											<?php if( $attrs[ 'showExcerpt' ] ): ?>
												<div class="cb-block__post-text">
													<?php echo wp_trim_words( $text, $attrs[ 'excerptLength' ], '...' ); ?>
												</div>
											<?php endif; ?>

											<?php if( $attrs[ 'moreText' ] ): ?>
												<div class="cb-block__button-wrapper">
													<a href="<?php the_permalink(); ?>" class="cb-block-button">
														<?php esc_html_e( "Continue Reading", "creative-blocks" ); ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
									</article>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<?php
				wp_reset_postdata();
				$block_content = ob_get_clean();
			endif; 

			return $block_content;
		}
	}
}
CB_Slider::get_instance()->init();
