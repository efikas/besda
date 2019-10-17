<?php
/**
* Do things related with Post Masonry Block
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Post_Masonry' ) ) {
	class CB_Post_Masonry extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'post-masonry';

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
		* @access private
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
	   		$this->check_enqueue_block_assets( '' );
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
		   				'handler' => 'jquery-masonry',
		   				'script'  => true,
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
						'selector' => '.cb-block__post-title a',
						'props' => array(
							'color'         => 'headingColor',
							'font-size'     => 'headingSize',
							'margin-bottom' => 'headingSpacing',
						)
					),
					array(
						'selector' => '.cb-block__post-title',
						'props' => array(
							'margin-bottom' => 'headingSpacing',
						)
					),
					array(
						'selector' => '.cb-block__post-meta',
						'props' => array(
							'color'         => 'metaColor',
							'margin-bottom' => 'metaSpacing',
						)  
					),				
					array(
						'selector' => '.cb-block__post-meta-category',
						'props' => array(
							'margin-bottom' => 'categorySpacing',
							'color'         => 'metaColor',
						)  
					),
					array(
						'selector' => '.cb-block__post-text',
						'props' => array(
							'font-size'     => 'descriptionSize',
							'color'         => 'descriptionColor',
							'margin-bottom' => 'descriptionSpacing',
						)  
					),
					array(
						'selector' => '.cb-block__button-wrapper',
						'props' => array(
							'font-size'     => 'moreTextSize',
							'color'         => 'moreTextColor',
							'margin-bottom' => 'moreTextSpacing',
						)  
					),
					array(
						'selector' => '.cb-block__button-wrapper a:hover',
						'props' => array(
							'color'         => 'moreTextHoverColor',
						)  
					)
				);

				self::add_styles( array(
					'attrs' => $attrs,
					'css'   => $dynamic_css,
				));

				ob_start();
				?>
				jQuery( window ).load( function(){
					jQuery( '#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?> .cb-block__post-grid' ).masonry({
					    itemSelector: '.cb-post-masonry-grid',
					});
				});
				<?php
				$js =  ob_get_clean();
				self::add_scripts( $js );
			}
		}

	   /**
		* Returns attributes for this Block
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return array
		*/
		protected function get_attrs(){
			return array(
				# Hidden setting
				'block_id' => array(
					'type' => 'string'
				),
			    'order' => array(
			        'type'    => 'string',
			        'default' => 'desc',
			    ),
			    'orderBy' => array(
			        'type'    => 'string',
			        'default' => 'date',
			    ),
			    'categories' => array(
			        'type' => 'string',
			    ),
			    'postsToShow' => array(
			        'type'    => 'number',
			        'default' => 5,
			    ),
			    'columns_md' => array(
			        'type'    => 'number',
			        'default' => 2,
			    ),            
			    'columns_sm' => array(
			        'type'    => 'number',
			        'default' => 2,
			    ),            
			    'columns_xs' => array(
			        'type'    => 'number',
			        'default' => 1,
			    ),

			    'showImage' => array(
			        'type' => 'boolean',
			        'default' => true
			    ),
			    'imagePosition' => array(
			        'type' => 'string',
			        'default' => 'top'
			    ),
			    'imageSize' => array(
			        'type' => 'string',
			        'default' => 'large'
			    ),

			    'showExcerpt' => array(
			        'type'    => 'boolean',
			        'default' => true,
			    ),
			    'excerptLength' => array(
			        'type'    => 'number',
			        'default' => 25,
			    ),
			    'displayContinueText' => array(
			        'type'    => 'boolean',
			        'default' => true,
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
			    'tag' => array(
			        'type' => 'string',
			        'default' => 'h3'
			    ),
			    'headingSize' => array(
			        'type' => 'number',
			    ),
			    'descriptionSize' => array(
			        'type' => 'number',
			    ),
			    'moreTextSize' => array(
			        'type' => 'number',
			    ),

			    'headingColor' => array(
			        'type' => 'string'
			    ),
			    'metaColor' => array(
			        'type' => 'string'
			    ),
			    'descriptionColor' => array(
			        'type' => 'string'
			    ),
			    'moreTextColor' => array(
			        'type' => 'string'
			    ),
			    'moreTextHoverColor' => array(
			        'type' => 'string'
			    ),

			    'categorySpacing' => array(
			        'type' => 'number'
			    ),
			    'headingSpacing' => array(
			        'type' => 'number'
			    ),
			    'metaSpacing' => array(
			        'type' => 'number'
			    ),
			    'descriptionSpacing' => array(
			        'type' => 'number'
			    ),
			    'moreTextSpacing' => array(
			        'type' => 'number'
			    )
			);
		}

	   /**
		* Renders blocks in frontend
		*
		* @static
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
				$layout_cls = isset( $attrs[ 'layout' ] ) ? 'cb-' . $attrs[ 'layout' ] . '-post-layout' : '';
				?>
				<div id="<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>">
				    <div class="cb-block__post-grid cb-<?php echo esc_attr( $attrs[ 'imagePosition' ] ); ?>-image-position <?php echo esc_attr( $layout_cls ); ?>">
				        <div class="cb-row">
			            <?php
			                while( $query->have_posts() ) {
			                    $query->the_post();
			                    $cls = 'cb-post-masonry-grid cb-col-md-' . 12/$attrs[ 'columns_md' ] . ' cb-col-sm-' . 12/$attrs[ 'columns_sm' ] . ' cb-col-xs-' . 12/$attrs[ 'columns_xs' ];

		                    		if( !isset( $attrs[ 'categories' ] ) ){
		                        		$_cat = get_the_category();
		                        		$cat = self::make_category_arr( $_cat[ 0 ] );
		                        	}
			                   ?>
			                   <div class="<?php echo esc_attr( $cls ); ?>">
			                        <article class="cb-block__post">
			                            <?php if( $attrs[ 'showImage' ] && has_post_thumbnail() ): ?>
			                                <figure class="cb-block__post-img">
			                                	<a href="<?php the_permalink(); ?>" >
			                                    	<?php the_post_thumbnail( $attrs[ 'imageSize' ] ); ?>
			                                	</a>
			                           		</figure>
			                            <?php endif; ?>
			                            <div class="cb-block__post-content">
		                            		<?php if( $attrs[ 'displayPostCategory' ] ): ?>
		                                    	<div class="cb-block__post-meta-category" >
		                                    	    <a href="<?php echo esc_url( $cat[ 'link' ] ); ?>">
		                                    	        <span><?php echo $cat[ 'name' ]; ?></span>
		                                    	    </a>
		                                    	</div>
		                                    <?php endif; ?>

			                                <<?php echo esc_attr( $attrs[ 'tag' ] ); ?> class="cb-block__post-title">
			                                    <a href="<?php the_permalink(); ?>">
			                                        <?php the_title(); ?>
			                                    </a>
			                                </<?php echo esc_attr( $attrs[ 'tag' ] ); ?>>
			                                
			                                <div class="cb-block__post-meta">
			                                    <?php if( $attrs[ 'displayPostAuthor' ] ): ?>
			                                        <div class="cb-block__post-meta-author">
			                                            <a href="<?php the_author_link(); ?>">
			                                            	<span class="icon far fa-user"></span>
			                                                <?php the_author(); ?>
			                                            </a>
			                                        </div>
			                                    <?php endif; ?>

			                                    <?php if( $attrs[ 'displayPostDate' ] ): ?>
			                                        <div class="cb-block__post-meta-date">
			                                            <a href="<?php echo esc_url(get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') )); ?>">
			                                            	<span class="icon far fa-clock"></span>
			                                                <span class="cb-block__date-format"><?php echo get_the_date(); ?></span>
			                                            </a>
			                                        </div>
			                                    <?php endif; ?>

			                                    <?php if( $attrs[ 'displayPostComment' ] ): ?>
			                                        <div class="cb-block__post-meta-comment">
			                                        	<a href="<?php comments_link(); ?>">
			                                            	<span class="icon far fa-comment-dots"></span>
			                                            	<span class="cb-block__comment-count"><?php echo get_comments_number(); ?></span>
			                                            </a>
			                                        </div>
			                                    <?php endif; ?>
			                                </div>

			                                <?php if( $attrs[ 'showExcerpt' ] ): ?>
			                                    <div class="cb-block__post-text">
			                                        <?php 
			                                        	echo wp_trim_words( 
			                                        		get_the_excerpt(), 
			                                        		$attrs[ 'excerptLength' ], 
			                                        		'...' 
			                                        	); 
			                                        ?>
			                                    </div>
			                                <?php endif; ?>

			                                <?php if( $attrs[ 'displayContinueText' ] ): ?>
			                                    <div class="cb-block__button-wrapper">
			                                        <a href="<?php the_permalink(); ?>">
			                                            <?php echo esc_html__( 'Continue Reading', 'creative-blocks' ); ?>
			                                        </a>
			                                    </div>
			                                <?php endif; ?>
			                            </div>
			                        </article>
			                    </div>
			                   <?php
			                }
			            ?>
				        </div>
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
CB_Post_Masonry::get_instance()->init();