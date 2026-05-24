<?php

class PxlSerivceGrid_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_serivce_grid';
    protected $title = 'BR Services Grid';
    protected $icon = 'eicon-posts-grid';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[]}';
    protected $styles = array(  );
    protected $scripts = array( 'imagesloaded','isotope','pxl-post-grid' );
}