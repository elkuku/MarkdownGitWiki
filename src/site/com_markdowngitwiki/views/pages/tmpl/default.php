<?php

JHtml::script('media/com_markdowngitwiki/site/js/php_file_tree.js');
JHtml::stylesheet('media/com_markdowngitwiki/site/css/php_file_tree.css');

echo MgwExtensionHelper::drawToolbar();

echo '<h1>Page List</h1>';

echo MgwFileTree::drawTree(MGW_PATH_DATA, JRoute::_('&view=&page=[link]'));
