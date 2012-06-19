<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jtester
 * Date: 6/18/12
 * Time: 3:10 PM
 * To change this template use File | Settings | File Templates.
 */

?>
<div class="btn-toolbar pull-right">

    <div class="btn-group views">
        <a class="btn" href="<?= JRoute::_('&view=pages') ?>">
            <i class="icon-list-alt"></i>
            Page List
        </a>
    </div>

    <div class="btn-group actions">
        <?= $this->createButton; ?>
        <?php if('' == $this->createButton) : ?>
        <a class="btn" href="javascript:void(0);" onclick="alert('not yet...');">
            <i class="icon-pencil"></i>
            Edit
        </a>
        <a class="btn" href="javascript:void(0);" onclick="alert('not yet...');">
            <i class="icon-trash"></i>
            Delete
        </a>
        <?php endif; ?>
    </div>

</div>
