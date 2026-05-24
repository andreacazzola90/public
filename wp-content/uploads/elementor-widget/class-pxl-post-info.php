<?php

class PxlPostInfo_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_post_info';
    protected $title = 'BR Post Info';
    protected $icon = 'eicon-image';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_layout","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/leax.local\/wp-content\/themes\/gurus\/elements\/widgets\/img-layout\/pxl_post_info\/portfolio-layout1.jpg"}}}]},{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"style","label":"Style","type":"select","options":{"default":"Default","style1":"Style 1"}},{"name":"label","label":"Title","type":"text","label_block":true},{"name":"timeline_start","label":"Start Time","type":"date_time","label_block":true},{"name":"timeline_end","label":"End Time","type":"date_time","label_block":true}]},{"name":"section_settings","label":"Settings","tab":"settings","controls":[{"name":"show_date","label":"Show Date","type":"switcher","default":"true"},{"name":"show_title","label":"Show Title","type":"switcher","default":"true"},{"name":"show_client","label":"Show Client","type":"switcher","default":"true"},{"name":"show_timeline","label":"Show Timeline","type":"switcher","default":"true"},{"name":"show_service","label":"Show Date","type":"switcher","default":"true"}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}