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
        if( ! is_user_logged_in() || WP_DEBUG ) {
           get_template_part( 'template-parts/section', 'footer-cta' ); 
        }
        ?>
        
        <div class="footer-bottom">
    
            <div class="footer-widgets">
                
                <div class="row align-top align-center align-middle large-unstack">
                
                    <div class="column column-block large-4 large-order-2">
                    <?php
                    $site_url = home_url();
                        $logo = sprintf('<img src="%sfooter-logo.png" class="" />', trailingslashit( THEME_IMG ) );                    
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
