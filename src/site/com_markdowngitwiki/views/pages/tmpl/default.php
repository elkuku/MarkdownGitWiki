<?php

JHtml::script('media/com_markdowngitwiki/site/js/php_file_tree.js');
JHtml::stylesheet('media/com_markdowngitwiki/site/css/php_file_tree.css');

echo '<h1>Page list</h1>';

echo MgwFileTree::drawTree(MGW_PATH_DATA, JRoute::_('&view=&page=[link]'));
