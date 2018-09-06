<?php

get_header(); ?>

<?php
get_template_part( 'template-parts/hero', 'story' );
?>

<div class="row align-center">

    <div class="large-9 columns">
    
        <div id="primary" class="content-area">
        
            <main id="main" class="site-main" role="main">
                <?php
                while ( have_posts() ) :
    
                    the_post();
    
                    get_template_part( 'template-parts/content', 'story' );
    
                endwhile;
               ?>
        
            </main>
        
        </div>
    
    </div>
    
</div>

<?php
get_template_part( 'template-parts/post', 'footer' );

get_template_part( 'template-parts/content', 'story-form' );
?>

<?php
get_footer();
