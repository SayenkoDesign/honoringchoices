<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?>

</div><!-- #content -->


<footer id="colophon" class="site-footer" role="contentinfo">

    <div class="wrap">
    
        <?php
        $show_footer = true;
        
        // Hide for learndash & BB Press
        if( hc_is_learndash() || hc_is_bbpress() ) {
            $show_footer = false;
        }
        
        // Pages let you remove as needed
        if( is_page() ) {
            $remove_footer_cta = get_field( 'remove_footer_cta' );
            $show_footer = $remove_footer_cta ? false : true;
        }
        
        if( $show_footer ) {
           get_template_part( 'template-parts/section', 'footer-cta' ); 
        }
        ?>
        
        <div class="footer-bottom">
    
            <div class="footer-widgets">
                
                <div class="row align-top align-center align-middle large-unstack">
                
                    <div class="column column-block large-4 large-order-2">
                    <?php
                    $site_url = home_url();
                        $logo = sprintf('<img src="%sfooter-logo-v2.svg" class="" />', trailingslashit( THEME_IMG ) );                    
                        printf('<aside class="widget widget_media_image text-center"><a href="%s" title="%s">%s</a></aside>',
                                $site_url, get_bloginfo( 'name' ), $logo );
                    ?>
                    </div>
                    
                    <div class="column column-block large-4 large-order-1">
                    <?php
                    
                    if( is_active_sidebar( 'footer-1') ){
                        dynamic_sidebar( 'footer-1' );
                    }
                    ?>
                    </div>
                    
                    <div class="column column-block large-4 large-order-3">
                    <?php
                    if( is_active_sidebar( 'footer-2') ){
                        dynamic_sidebar( 'footer-2' );
                    }
                    ?>
                    </div>
                
                </div>
            
            </div>
            
            <div class="footer-copyright">
            
              <hr />
                    
              <div class="column row">                      
                <?php
                
                /*
                © 2018 Honoring Choice Pacific Northwest. Privacy Statement 
    The name Honoring Choices Pacific Northwest is used under license from Twin Cities Medical Society Foundation. All rights reserved. Seattle Web Design by Sayenko Design.
                */
                
                $copyright = sprintf( '<span>&copy; %s Honoring Choice Pacific Northwest.</span><span>Privacy Statement 
    The name Honoring Choices Pacific Northwest is used under license from Twin Cities Medical Society Foundation. All rights reserved.</span>', 
                                      date( 'Y' ) );
                                      
                $designer  = sprintf( '<span><a href="%1$s" target="_blank">Seattle Web Design</a> by <a href="%1$s" target="_blank">Sayenko Design</a></span>', 
                                       'http://www.sayenkodesign.com' );
                                    
                printf( '<div class="copyright"><p>%s%s</p></div>', $copyright, $designer );
                                            
                ?>
            </div>
    
                
             </div>
         
         </div>
     
     </div>
 
 </footer><!-- #colophon -->

<?php 
 
wp_footer(); 
?>
</body>
</html>
