<?php

/*
Modal - Search
*/

?>
<div class="modal-search full reveal" id="modal-search" data-reveal>
    <div class="modal-content">
        <div class="row align-middle align-center">
            <div class="small-12 columns">
                <?php
                get_search_form();
                ?>
            </div>
        </div>
    </div>
    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
</div>