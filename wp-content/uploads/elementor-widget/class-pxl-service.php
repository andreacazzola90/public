<?php

class PxlService_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_service';
    protected $title = 'BR Service';
    protected $icon = 'eicon-posts';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_layout","label":"Layout","tab":"layout","controls":[{"name":"post_type","label":"Select Post Type","type":"select","multiple":true,"options":[],"default":"post"}]}]}';
    protected $styles = array(  );
    protected $scripts = array( 'imagesloaded','isotope','pxl-post-grid' );
}