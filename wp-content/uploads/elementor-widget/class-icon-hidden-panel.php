<?php

class IconHiddenPanel_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'icon_hidden_panel';
    protected $title = 'Case Hidden Panel';
    protected $icon = 'eicon-menu-bar';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"content","controls":[{"name":"content_template","label":"Select Template","type":"select","options":{"0":"None","5674":"Panel Content"},"default":"df","description":"Add new tab template: \"<a href=\"http:\/\/localhost\/bravis-team\/zurick\/wp-admin\/edit.php?post_type=pxl-template\" target=\"_blank\">Click Here<\/a>\""},{"name":"icon_color","label":"Icon Color","type":"color","selectors":{"{{WRAPPER}} .pxl-hidden-panel-button .pxl-icon-line,{{WRAPPER}} .pxl-hidden-panel-button .pxl-icon-line::before, {{WRAPPER}} .pxl-hidden-panel-button .pxl-icon-line::after":"background-color: {{VALUE}};","{{WRAPPER}} .pxl-hidden-panel-button":"border-color: {{VALUE}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}