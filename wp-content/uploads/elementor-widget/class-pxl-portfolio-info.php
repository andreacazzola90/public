<?php

class PxlPortfolioInfo_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_portfolio_info';
    protected $title = 'Case Portfolio Info';
    protected $icon = 'eicon-image';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_layout","label":"Layout","tab":"layout","controls":[{"name":"layout","label":"Templates","type":"layoutcontrol","default":"1","options":{"1":{"label":"Layout 1","image":"http:\/\/localhost\/bravis\/themes\/zurick\/wp-content\/themes\/zurick\/elements\/widgets\/img-layout\/pxl_portfolio_info\/layout-1.jpg"},"2":{"label":"Layout 2","image":"http:\/\/localhost\/bravis\/themes\/zurick\/wp-content\/themes\/zurick\/elements\/widgets\/img-layout\/pxl_portfolio_info\/layout-2.jpg"}}}]},{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"case_title","label":"Title","type":"text","label_block":true,"condition":{"layout":["2"]}},{"name":"client_name","label":"Client Name","type":"text","label_block":true,"condition":{"layout":["2"]}},{"name":"timeline_start","label":"Timeline","type":"date_time","label_block":true,"description":"Start time!","condition":{"layout":["2"]}},{"name":"timeline_end","type":"date_time","description":"End time!","condition":{"layout":["2"]}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}