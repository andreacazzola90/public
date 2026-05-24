<?php

class PxlShape_Widget extends Pxltheme_Core_Widget_Base{
    protected $name = 'pxl_shape';
    protected $title = 'BR Shape';
    protected $icon = 'eicon-shape';
    protected $categories = array( 'pxltheme-core' );
    protected $params = '{"sections":[{"name":"section_content","label":"Content","tab":"style","controls":[{"name":"style","label":"Style","type":"select","options":{"shape-default":"Default"},"default":"shape-default"},{"name":"effect","label":"Effect","type":"select","options":{"":"None","slide-in-tr":"Slide In Top Right","slide-in-bl":"Slide In Bottom Left"},"default":""},{"name":"min_width","label":"Width","type":"slider","control_type":"responsive","size_units":["px","%"],"range":{"px":{"min":0,"max":3000}},"selectors":{"{{WRAPPER}} .pxl-shape .pxl-item--shape":"min-width: {{SIZE}}{{UNIT}};"}},{"name":"height","label":"Height","type":"slider","control_type":"responsive","size_units":["px","%"],"range":{"px":{"min":0,"max":3000}},"selectors":{"{{WRAPPER}} .pxl-shape .pxl-item--shape":"height: {{SIZE}}{{UNIT}};"}},{"name":"bg_color","label":"Background Color","type":"color","selectors":{"{{WRAPPER}} .pxl-shape .pxl-item--shape":"background-color: {{VALUE}};"}},{"name":"border","label":"Border","type":"border","control_type":"group","selector":"{{WRAPPER}} .pxl-shape .pxl-item--shape"},{"name":"border_radius","label":"Border Radius","type":"dimensions","size_units":["px"],"selectors":{"{{WRAPPER}} .pxl-shape .pxl-item--shape":"border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};"}}]}]}';
    protected $styles = array(  );
    protected $scripts = array(  );
}