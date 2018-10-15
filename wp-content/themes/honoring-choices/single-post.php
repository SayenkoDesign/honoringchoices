<?php

get_header(); ?>

<?php
get_template_part( 'template-parts/hero', 'post' );
?>

<div class="row align-center">

    <div class="large-9 columns">
    
        <div id="primary" class="content-area">
        
            <main id="main" class="site-main" role="main">
                <?php
                while ( have_posts() ) :
    
                    the_post();
    
                    get_template_part( 'template-parts/content', 'post' );
                        
                endwhile;
               ?>
        
            </main>
        
        </div>
    
    </div>
    
</div>

<?php
get_template_part( 'template-parts/post', 'footer' );
?>

<?php
get_footer();
