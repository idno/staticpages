<div class="row">

    <div class="span10 offset1">

        <?php

            if (!empty($vars['object']) && $vars['object'] instanceof \IdnoPlugins\StaticPages\StaticPage) {
                echo $vars['object']->draw();
            }



        ?>

    </div>

</div>