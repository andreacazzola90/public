<?php

class PxlPostNavigation_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_post_navigation';
    protected $title = 'BR Post Navigation';
    protected $icon = 'eicon-navigation-horizontal';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"type","label":"Type","type":"select","default":"pagination","options":{"pagination":"Pagination","navigation":"Navigation"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}