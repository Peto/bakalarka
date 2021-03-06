<?php
/**
 *  CakePHP HighCharts Plugin
 * 
 * 	Copyright (C) 2012 Kurn La Montagne / destinydriven
 *	<https://github.com/destinydriven> 
 * 
 * 	Multi-licensed under:
 * 		MPL <http://www.mozilla.org/MPL/MPL-1.1.html>
 * 		LGPL <http://www.gnu.org/licenses/lgpl.html>
 * 		GPL <http://www.gnu.org/licenses/gpl.html>
 * 		Apache License, Version 2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 */
 
/**
 * @property HighChartsController $HighCharts
 */
class HighChartsDemoController extends HighChartsAppController {
    public $name = 'HighChartsDemo';
    public $components = array('HighCharts.HighCharts');
    public $helpers = array('HighCharts.HighCharts');
    public $uses = array();
    public $layout = 'chart.demo';

    function index() {
    }
}