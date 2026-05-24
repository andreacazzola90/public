<?php

class PxlIconTextList_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_icon_text_list';
    protected $title = 'Case Icons Text List';
    protected $icon = 'eicon-alert';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"icons_list","label":"Icons","type":"repeater","controls":[{"name":"pxl_icon","label":"Icon","type":"icons","fa4compatibility":"icon"},{"name":"icon_link","label":"Link","type":"url","label_block":true},{"name":"text","label":"Text","type":"text","label_block":true}],"title_field":"{{{ label }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}