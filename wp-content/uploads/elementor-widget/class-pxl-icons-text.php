<?php

class PxlIconsText_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_icons_text';
    protected $title = 'Case Icons Text';
    protected $icon = '';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"icons_text","label":"Icons Text","type":"repeater","controls":[{"name":"pxl_icon","label":"Icon","type":"icons","fa4compatibility":"icon"},{"name":"text","label":"Text","type":"text","label_block":true}],"title_field":"{{{ text }}}"}]},{"name":"section_style","label":"Style","tab":"style","controls":[[{"name":"text_color","label":"Text Color","type":"color","selectors":{"{{WRAPPER}} .pxl-icons-text .pxl-icon-text .text":"color: {{VALUE}};"}},{"name":"text_typography","label":"Text Typography","type":"typography","control_type":"group","selector":"{{WRAPPER}} .pxl-icons-text .pxl-icon-text .text"}]]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}