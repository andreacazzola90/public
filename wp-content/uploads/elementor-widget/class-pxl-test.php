<?php

class PxlTest_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_test';
    protected $title = 'BR Test';
    protected $icon = 'eicon-text';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Text Editor","tab":"content","controls":[]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}