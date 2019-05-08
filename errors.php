<?php
/**
 * Created by PhpStorm.
 * User: Kyle.henson
 * Date: 3/30/2019
 * Time: 3:26 PM
**/

 if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php  endif ?>