<?php

class PxlFeatureGrid_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_feature_grid';
    protected $title = 'BR Feature Grid';
    protected $icon = 'eicon-gallery-grid';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"items","label":"Feature","type":"repeater","controls":[{"name":"image","label":"Image","type":"media"},{"name":"title","label":"Title","type":"text","label_block":true}],"title_field":"{{{ title }}}"}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'imagesloaded','isotope','pxl-post-grid' );
}