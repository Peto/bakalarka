<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 */
class TransactionsController extends AppController {

	
	public $paginate;
	public $HighCharts = null;
	public $components = array('HighCharts.HighCharts');
	
/**
 * index method
 *
 * @return void
 */
		
	public function index() {
		
		/* $this->paginate = array(
			'limit' => 20,
			'order' => array(
				'Transaction.post_date' => 'asc'
			),
			'conditions' => array(
				'Transaction.user_id' => $this->Session->read('User.id'),
			),
		);
		
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate()); */
		
		$chartData1 = array();
		$chartData2 = array();
		$rozdielData = array();
			
		$chartName = 'Column Chart';
		$mychart = $this->HighCharts->create( $chartName, 'column' );
		$this->HighCharts->setChartParams(
				$chartName,
				array(
						'renderTo'				=> 'columnwrapper',  // div to display chart inside
						'chartWidth'				=> 800,
						'chartHeight'				=> 600,
						'chartMarginTop' 			=> 60,
						'chartMarginLeft'			=> 90,
						'chartMarginRight'			=> 30,
						'chartMarginBottom'			=> 110,
						'chartSpacingRight'			=> 10,
						'chartSpacingBottom'			=> 15,
						'chartSpacingLeft'			=> 0,
						'chartAlignTicks'			=> FALSE,
						'chartBackgroundColorLinearGradient' 	=> array(0,0,0,300),
						'chartBackgroundColorStops'		=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						'title'					=> 'Príjmy verzus výdavky',
						'titleAlign'				=> 'left',
						'titleFloating'				=> TRUE,
						'titleStyleFont'			=> '18px Metrophobic, Arial, sans-serif',
						'titleStyleColor'			=> '#0099ff',
						'titleX'				=> 20,
						'titleY'				=> 20,
		
						'legendEnabled'				=> TRUE,
						'legendLayout'				=> 'horizontal',
						'legendAlign'				=> 'center',
						'legendVerticalAlign '			=> 'bottom',
						'legendItemStyle'			=> array('color' => '#222'),
						'legendBackgroundColorLinearGradient' 	=> array(0,0,0,25),
						'legendBackgroundColorStops' => array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						'tooltipEnabled' 			=> FALSE,
						//'tooltipBackgroundColorLinearGradient'=> array(0,0,0,50),   // triggers js error
						//'tooltipBackgroundColorStops' 	=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						//'plotOptionsLinePointStart' 		=> strtotime('-30 day') * 1000,
						//'plotOptionsLinePointInterval' 	=> 24 * 3600 * 1000,
		
						//'xAxisType' 				=> 'datetime',
						//'xAxisTickInterval' 			=> 10,
						//'xAxisStartOnTick' 			=> TRUE,
						//'xAxisTickmarkPlacement' 		=> 'on',
						//'xAxisTickLength' 			=> 10,
						//'xAxisMinorTickLength' 		=> 5,
		
						'xAxisLabelsEnabled' 			=> TRUE,
						'xAxisLabelsAlign' 			=> 'right',
						'xAxisLabelsStep' 			=> 1,
						//'xAxisLabelsRotation' 		=> -35,
						'xAxislabelsX' 				=> 5,
						'xAxisLabelsY' 				=> 20,
						'xAxisCategories'           		=> array(
								'Jan',
								'Feb',
								'Mar',
								'Apr',
								'May',
								'Jun',
								'Jul',
								'Aug',
								'Sep',
								'Oct',
								'Nov',
								'Dec'
						),
		
						//'yAxisMin' 				=> 0,
						//'yAxisMaxPadding'			=> 0.2,
						//'yAxisEndOnTick'			=> FALSE,
						//'yAxisMinorGridLineWidth' 		=> 0,
						//'yAxisMinorTickInterval' 		=> 'auto',
						//'yAxisMinorTickLength' 		=> 1,
						//'yAxisTickLength'			=> 2,
						//'yAxisMinorTickWidth'			=> 1,
		
		
						'yAxisTitleText' 			=> 'Suma',
						//'yAxisTitleAlign' 			=> 'high',
						//'yAxisTitleStyleFont' 		=> '14px Metrophobic, Arial, sans-serif',
						//'yAxisTitleRotation' 			=> 0,
						//'yAxisTitleX' 			=> 0,
						//'yAxisTitleY' 			=> -10,
						//'yAxisPlotLines' 			=> array( array('color' => '#808080', 'width' => 1, 'value' => 0 )),
		
						/* autostep options */
						'enableAutoStep' 			=> FALSE
				)
		);
		
		$series1 = $this->HighCharts->addChartSeries();
		//$series1->type = 'areaspline';
		$series2 = $this->HighCharts->addChartSeries();
		//$series2->type = 'areaspline';
		
		$series1->addName('Tokyo')->addData($this->chartData1);
		$series2->addName('London')->addData($this->chartData2);
		
		$rozdiel = $this->HighCharts->addChartSeries();
		$rozdiel->type = 'spline';
		//$rozdiel->type = 'areaspline';    
		$rozdiel->addName('Rozdiel')->addData($this->rozdielData);
		
		
		if(!isset($this->request->data['Filter'])) {
			$time = strtotime("-11 month", time());
			$data['from_date'] = date("Y-m-d", $time);
			$data['to_date'] = date('Y-m-d');
			$data['year_month_day'] = '2';
		} else {
			$data= $this->request->data['Filter'];
		}
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.post_date >=' => $data['from_date'],
						'Transaction.post_date <=' => $data['to_date'],
				),
		);
		
		$this->Transaction->recursive = 0;
		$transactions = $this->paginate();
		$this->set('transactions', $transactions);
		
		
		$date_array1 = array();
		$date_array2 = array();
		$date_array3 = array();
		$xAxisCategories = array();
		
		$from_year = date('Y', strtotime($data['from_date']));
		$from_month = date('m', strtotime($data['from_date']));
		$from_day = date('d', strtotime($data['from_date']));
		
		$to_year = date('Y', strtotime($data['to_date']));
		$to_month = date('m', strtotime($data['to_date']));
		$to_day = date('d', strtotime($data['to_date']));
		$mesiace_preklady = array('01' => 'január', '02' => 'február', '03' => 'marec', '04' => 'apríl', '05' => 'máj', '06' => 'jún', '07' => 'júl', '08' => 'august', '09' => 'september', '10' => 'október', '11' => 'november', '12' => 'december');
		$pocet_mesiacov = (strtotime($data['to_date']) - strtotime($data['from_date'])) / (60*60*24*30.5);
		
		if ($data['year_month_day'] == '1') {		// filtrovanie podla rokov
			for ($i = $from_year; $i<=$to_year; $i++) {
				$date_array1[(string)$i] = 0;
				$date_array2[(string)$i] = 0;
				$date_array3[(string)$i] = 0;
			}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				if ($row['Transaction']['transaction_type_id'] == '1') {
					$date_array1[$r_year] += $row['Transaction']['amount'];
					$date_array3[$r_year] += $row['Transaction']['amount'];      // date_array pre rozdielovy graf - pricitovanie vkladov
				}
				else {
					$date_array2[$r_year] -= $row['Transaction']['amount'];
					$date_array3[$r_year] -= $row['Transaction']['amount'];			// date_array pre rozdielovy graf - odcitovanie vydavkov
				}
			}
		
			print_r($date_array1);
			print_r($date_array2);
		
			foreach ($date_array1 as $year => $val) {
				$chartData1[] = $val;
				$xAxisCategories[] = $year;
			}
			
			foreach ($date_array2 as $year => $val) {
				$chartData2[] = $val;
				$xAxisCategories[] = $year;
			}
			
			foreach ($date_array3 as $year => $val) {
				$rozdielData[] = $val;
			}
			
			$series1->addName('Príjmy za roky')->addData($chartData1);
			$series2->addName('Výdavky za roky')->addData($chartData2);
			$rozdiel->addName('Rozdiel za roky')->addData($rozdielData);
		}
		else
			if ($data['year_month_day'] == '2') {		// filtrovanie podla mesiacov
			for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
				if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
					for ($j = $from_month; $j<= $to_month; $j++) {
						$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
					}
				}
				else {
					if ($i == $from_year){
						for ($j = $from_month; $j<= 12; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($i> $from_year && $i < $to_year) {
						for ($j = 1; $j<= 12; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($i == $to_year) {
						for ($j = 1; $j<= $to_month; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
							$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
				}
			}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$r_month = date('m', strtotime($row['Transaction']['post_date']));
				if ($row['Transaction']['transaction_type_id'] == '1') {
					$date_array1[$r_year][$r_month] += $row['Transaction']['amount'];
					$date_array3[$r_year][$r_month] += $row['Transaction']['amount'];
				}
				else {
					$date_array2[$r_year][$r_month] -= $row['Transaction']['amount'];
					$date_array3[$r_year][$r_month] -= $row['Transaction']['amount'];
				}
			}
				
			print_r($date_array1);
			print_r($date_array2);
				
			foreach ($date_array1 as $year => $val) {
				foreach ($val as $month => $val2) {
					$chartData1[] = $val2;
					if ($pocet_mesiacov > 12) {
						$xAxisCategories[] = $month;
					}
					else
						$xAxisCategories[] = $mesiace_preklady[$month];
				}
			}
			
			foreach ($date_array2 as $year => $val) {
				foreach ($val as $month => $val2) {
					$chartData2[] = $val2;
					/*if ($pocet_mesiacov > 12) {
						$xAxisCategories[] = $month;
					}
					else
						$xAxisCategories[] = $mesiace_preklady[$month];*/
				}
			}
			
			foreach ($date_array3 as $year => $val) {
				foreach ($val as $month => $val2) {
					$rozdielData[] = $val2;
				}
			}
			
			$series1->addName('Príjmy za mesiace')->addData($chartData1);
			$series2->addName('Výdavky za mesiace')->addData($chartData2);
			$rozdiel->addName('Rozdiel za mesiace')->addData($rozdielData);
		}
		else
			if ($data['year_month_day'] == '3') {		// filtrovanie podla dni
			for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
				if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
					for ($j = $from_month; $j<= $to_month; $j++) {
						if ($from_month == $to_month) {			// ak su dni len z jedneho mesiaca
							for ($k = $from_day; $k<= $to_day; $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j == $from_month) {		// ak od urciteho dna po koniec mesiaca
							for ($k = $from_day; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j == $to_month) {		// od zaciatku mesiaca po urcity den v nom
							for ($k = 1; $k<= $to_day; $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j > $from_month && $j < $to_month) {   // vsetky dni v mesiaci
							for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
					}
				}
				else {
					if ($i == $from_year){
						for ($j = $from_month; $j<= 12; $j++) {
							for ($j = $from_month; $j<= $to_month; $j++) {
								if ($j == $from_month) {		// ak od urciteho dna po koniec mesiaca
									for ($k = $from_day; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									}
								}
								else  {   // vsetky dni
									for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									}
								}
							}
						}
					}
					elseif ($i> $from_year && $i < $to_year) {		// ak cely rok
						for ($j = 1; $j<= 12; $j++) {
							for ($j = $from_month; $j<= $to_month; $j++) {
								for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
									$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								}
							}
						}
					}
					elseif ($i == $to_year) {		// ak je to posledny rok
						for ($j = 1; $j<= $to_month; $j++) {
							for ($j = $from_month; $j<= $to_month; $j++) {
								if ($j == $to_month) {   // ak nie je cely zaverecny mesiac
									for ($k = 1; $k<= $to_day; $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									}
								}
								else {			// ak je cely mesiac
									for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array2[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
										$date_array3[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
									}
								}
							}
						}
					}
				}
			}
		
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$r_month = date('m', strtotime($row['Transaction']['post_date']));
				$r_day = date('d', strtotime($row['Transaction']['post_date']));
				
				if ($row['Transaction']['transaction_type_id'] == '1') {
					$date_array1[$r_year][$r_month][$r_day] += $row['Transaction']['amount'];
					$date_array3[$r_year][$r_month][$r_day] += $row['Transaction']['amount'];
				}
				else {
				$date_array2[$r_year][$r_month][$r_day] -= $row['Transaction']['amount'];
				$date_array3[$r_year][$r_month][$r_day] -= $row['Transaction']['amount'];
				}
			}
		
			foreach ($date_array1 as $year => $val1) {
				foreach ($val1 as $month => $val2) {
					foreach ($val2 as $day => $val3) {
						$chartData1[] = $val3;
						$xAxisCategories[] = $day;
					}
				}
			}
			
			foreach ($date_array2 as $year => $val1) {
				foreach ($val1 as $month => $val2) {
					foreach ($val2 as $day => $val3) {
						$chartData2[] = $val3;
						$xAxisCategories[] = $day;
					}
				}
			}
			
			foreach ($date_array3 as $year => $val1) {
				foreach ($val1 as $month => $val2) {
					foreach ($val2 as $day => $val3) {
						$rozdielData[] = $val3;
					}
				}
			}
			
			$series1->addName('Príjmy za dni')->addData($chartData1);
			$series2->addName('Výdavky za dni')->addData($chartData2);
			$rozdiel->addName('Výdavky za dni')->addData($rozdielData);
		}
		
		$this->HighCharts->setChartParams( $chartName,	array('xAxisCategories'	=> $xAxisCategories ));
		
		$mychart->addSeries($series1);
		$mychart->addSeries($series2);
		$mychart->addSeries($rozdiel);
	}
		
	public function income() {
		
		$chartData = array();		
			
		$chartName = 'Area Chart';
		
		$mychart = $this->HighCharts->create( $chartName, 'area' );
				
		$this->HighCharts->setChartParams(
				$chartName,
				array(
						'renderTo'				=> 'areawrapper',  // div do ktoreho sa generuje graf
						'chartWidth'				=> 800,
						'chartHeight'				=> 400,
						'chartMarginTop' 			=> 60,
						'chartMarginLeft'			=> 90,
						'chartMarginRight'			=> 30,
						'chartMarginBottom'			=> 110,
						'chartSpacingRight'			=> 10,
						'chartSpacingBottom'			=> 15,
						'chartSpacingLeft'			=> 0,
						'chartAlignTicks'			=> FALSE,
						'chartBackgroundColorLinearGradient' 	=> array(0,0,0,300),
						'chartBackgroundColorStops'             => array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						'title'					=> 'Príjmy',
						'titleAlign'				=> 'left',
						'titleFloating'				=> TRUE,
						'titleStyleFont'			=> '18px Metrophobic, Arial, sans-serif',
						'titleStyleColor'			=> '#0099ff',
						'titleX'				=> 20,
						'titleY'				=> 20,
		
						'legendEnabled' 			=> TRUE,
						'legendLayout'				=> 'horizontal',
						'legendAlign'				=> 'center',
						'legendVerticalAlign '			=> 'bottom',
						'legendItemStyle'			=> array('color' => '#222'),
						'legendBackgroundColorLinearGradient' 	=> array(0,0,0,25),
						'legendBackgroundColorStops'            => array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						'tooltipEnabled' 			=> FALSE,
						'plotOptionsFillColor' =>  array(
								'linearGradient' => array(0, 0, 0, 300),
								'stops' => array(
										array(0, 'rgba(112, 138, 255, 1.0)'),  // Highcharts.getOptions().colors[0]
										array(1, 'rgba(2,0,0,0)')
								)
						),
						'xAxisLabelsEnabled' 			=> TRUE,
						'xAxisLabelsAlign' 			=> 'right',
						'xAxisLabelsStep' 			=> 2,
						//'xAxisLabelsRotation' 		=> -35,
						'xAxislabelsX' 				=> 5,
						'xAxisLabelsY' 				=> 20,
						'xAxisCategories'           		=> array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
						'yAxisTitleText' 			=> 'Suma',
					
						// autostep options
						'enableAutoStep' 			=> FALSE,
		
						// credits setting  [HighCharts.com  displayed on chart]
						'creditsEnabled' 			=> FALSE,
						'creditsText'  	 			=> 'Example.com',
						'creditsURL'	 			=> 'http://example.com'
				)
		);
		
		$series = $this->HighCharts->addChartSeries();
		
				
		if(!isset($this->request->data['Filter'])) {
			$time = strtotime("-11 month", time());
			$data['from_date'] = date("Y-m-d", $time);
			$data['to_date'] = date('Y-m-d');
			$data['year_month_day'] = '2';
		} else {
			$data= $this->request->data['Filter'];
		}
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.transaction_type_id' => '1',
						'Transaction.post_date >=' => $data['from_date'],
						'Transaction.post_date <=' => $data['to_date'],
				),
		);
		
		
	
		$this->Transaction->recursive = 0;
		$transactions = $this->paginate();
		$this->set('transactions', $transactions);
		
		$date_array = array();
		$xAxisCategories = array();
		
		$from_year = date('Y', strtotime($data['from_date']));
		$from_month = date('m', strtotime($data['from_date']));
		$from_day = date('d', strtotime($data['from_date']));
		
		$to_year = date('Y', strtotime($data['to_date']));
		$to_month = date('m', strtotime($data['to_date']));
		$to_day = date('d', strtotime($data['to_date']));
		$mesiace_preklady = array('01' => 'január', '02' => 'február', '03' => 'marec', '04' => 'apríl', '05' => 'máj', '06' => 'jún', '07' => 'júl', '08' => 'august', '09' => 'september', '10' => 'október', '11' => 'november', '12' => 'december');
		$pocet_mesiacov = (strtotime($data['to_date']) - strtotime($data['from_date'])) / (60*60*24*30.5);
		
		print_r($date_array);
		if ($data['year_month_day'] == '1') {		// filtrovanie podla rokov
			for ($i = $from_year; $i<=$to_year; $i++) {
				$date_array[(string)$i] = 0;
			}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$date_array[$r_year] += $row['Transaction']['amount'];
			}
				
			print_r($date_array);
				
			foreach ($date_array as $year => $val) {		
					$chartData[] = $val;
					$xAxisCategories[] = $year;
			}
			$series->addName('Príjmy za roky')->addData($chartData);
		}
		else
		if ($data['year_month_day'] == '2') {		// filtrovanie podla mesiacov
		for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
			if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
				for ($j = $from_month; $j<= $to_month; $j++) {
					$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
				}
			}
			else {
				if ($i == $from_year){
					for ($j = $from_month; $j<= 12; $j++) {
						$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
					}
				}
				elseif ($i> $from_year && $i < $to_year) {
					for ($j = 1; $j<= 12; $j++) {
						$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
					}
				}
				elseif ($i == $to_year) {
					for ($j = 1; $j<= $to_month; $j++) {
						$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
					}
				}
			} 
					
	 		//$date_array[date('Y')] = array('01' => 0, '02' => 0, '03' => 0, '04' => 0, '05' => 0, '06' => 0, '07' => 0, '08' => 0, '09' => 0, '10' => 0, '11' => 0, '12' => 0);
		}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$r_month = date('m', strtotime($row['Transaction']['post_date']));
				$date_array[$r_year][$r_month] += $row['Transaction']['amount'];
			}
			
			print_r($date_array);
			
			foreach ($date_array as $year => $val) {
				foreach ($val as $month => $val2) {
					$chartData[] = $val2;
					if ($pocet_mesiacov > 12) {
						$xAxisCategories[] = $month;
					}
					else 
					$xAxisCategories[] = $mesiace_preklady[$month];
				}
			} 
			$series->addName('Príjmy za mesiace')->addData($chartData);
		}
		else 
		if ($data['year_month_day'] == '3') {		// filtrovanie podla dni ...zatial nefukcne
		for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
			if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
				for ($j = $from_month; $j<= $to_month; $j++) {
					if ($from_month == $to_month) {			// ak su dni len z jedneho mesiaca 
						for ($k = $from_day; $k<= $to_day; $k++) {
							$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($j == $from_month) {		// ak od urciteho dna po koniec mesiaca
						for ($k = $from_day; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
							$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($j == $to_month) {		// od zaciatku mesiaca po urcity den v nom
						for ($k = 1; $k<= $to_day; $k++) {
							$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($j > $from_month && $j < $to_month) {   // vsetky dni v mesiaci
						for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
							$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
				}
			}
			else {
				if ($i == $from_year){
					for ($j = $from_month; $j<= 12; $j++) {
						for ($j = $from_month; $j<= $to_month; $j++) {
							if ($j == $from_month) {		// ak od urciteho dna po koniec mesiaca
								for ($k = $from_day; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
									$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								}
							}
							else  {   // vsetky dni
								for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
									$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								}
							}
						}	
					}
				}
				elseif ($i> $from_year && $i < $to_year) {		// ak cely rok
					for ($j = 1; $j<= 12; $j++) {
						for ($j = $from_month; $j<= $to_month; $j++) {
							for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
								$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}	
					}
				}
				elseif ($i == $to_year) {		// ak je to posledny rok
					for ($j = 1; $j<= $to_month; $j++) {
						for ($j = $from_month; $j<= $to_month; $j++) {
							if ($j == $to_month) {   // ak nie je cely zaverecny mesiac
								for ($k = 1; $k<= $to_day; $k++) {
									$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								}
							}
							else {			// ak je cely mesiac
								for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
									$date_array[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
								}
							}
						}
					}
				}
			}
				
			//$date_array[date('Y')] = array('01' => 0, '02' => 0, '03' => 0, '04' => 0, '05' => 0, '06' => 0, '07' => 0, '08' => 0, '09' => 0, '10' => 0, '11' => 0, '12' => 0);
		}
		
			//$date_array[date('m')] = array('01' => 0, '02' => 0, '03' => 0, '04' => 0, '05' => 0, '06' => 0, '07' => 0, '08' => 0, '09' => 0, '10' => 0, '11' => 0, '12' => 0, '12' => 0, '13' => 0, '14' => 0, '15' => 0, '16' => 0, '17' => 0, '18' => 0, '19' => 0, '20' => 0, '21' => 0, '22' => 0, '23' => 0, '24' => 0, '25' => 0, '26' => 0, '27' => 0, '28' => 0, '29' => 0, '30' => 0, '31' => 0);
	
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$r_month = date('m', strtotime($row['Transaction']['post_date']));
				$r_day = date('d', strtotime($row['Transaction']['post_date']));
				$date_array[$r_year][$r_month][$r_day] += $row['Transaction']['amount'];
			}
			
			print_r($date_array);
			
			
				foreach ($date_array as $year => $val1) {
					foreach ($val1 as $month => $val2) {
						foreach ($val2 as $day => $val3) {
							$chartData[] = $val3;
							$xAxisCategories[] = $day;
						}
					}
				}
				$series->addName('Príjmy za dni')->addData($chartData);
		}
				
		$this->HighCharts->setChartParams( $chartName,	array('xAxisCategories'	=> $xAxisCategories ));
		
		$mychart->addSeries($series);
	}
	
	public function expense() {
	
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.transaction_type_id' => '2',
				),
		);
	
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}
	
	public function date_test() {
	
		$this->paginate = array(
				'limit' => 20,
				'order' => array(
						'Transaction.post_date' => 'asc'
				),
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.post_date <' => '2013-04-26',
				),
		);
	
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->check_ownership($id) ) {
			throw new PrivateActionException(__('Na prístup k tejto operácii nemáte oprávnenie.'));
		}
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		
		/* Array
		(
				[Transaction] => Array
				(
						[transaction_type_id] => 1
						[name] => name 30
						[amount] => 30
						[category_id] => 3
						[subcategory_id] => 3
						[user_id] => 8
						[post_date] => 2013-03-04
						[repeat] => 0
						[repeat_every] => mesiac
						[number_of_cycles] => 1
				)
		
		) */
		
		if ($this->request->is('post')) {
			$this->Transaction->create();
			print_r($this->request->data);
			$data= $this->request->data['Transaction'];
			if ($this->Transaction->save($this->request->data)) {
				
				if ($data['repeat'] == 1) {
					$data['original_transaction_id'] = $this->Transaction->id;
					$data['id'] = $this->Transaction->id;
					if($this->insert_repeat($data, $data['post_date'])) {
						$this->Session->setFlash(__('Transakcia bola uložená'));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('Zadajte prosím skorší deň v mesiaci pri výbere dátumu. Najneskorší povolený je 28. deň.'));
					}
					
				} else {
					$this->Session->setFlash(__('Transakcia bola uložená'));
					$this->redirect(array('action' => 'index'));
				}
				
			} else {
				$this->Session->setFlash(__('Transakciu sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
			
		}
		
		$user_id = $this->Session->read('User.id'); 
		
		//print_r($this->Session->read('User.id'));
		$users = $this->Transaction->User->find('list');
		$this->set('transaction_types', $this->Transaction->TransactionType->find('list'));
		$this->set('categories', $this->Transaction->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set('subcategories', $this->Transaction->Subcategory->find('all', array('fields' => array('Subcategory.category_id', 'Subcategory.id', 'Subcategory.name'), 'recursive' => 1, 'conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('user', $user_id); 	
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->check_ownership($id) ) {
			throw new PrivateActionException(__('Na prístup k tejto operácii nemáte oprávnenie.'));
		}
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Neplatná transakcia'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			print_r($this->request->data);
			
			$data= $this->request->data['Transaction'];
			$original_date=$this->Transaction->field('post_date');
			print_r($original_date);
			
			 if (empty($this->request->data['Transaction']['original_transaction_id'])) {
				$this->request->data['Transaction']['original_transaction_id'] = 0;
			} 
			if ($data['update_next'] == 1) {
				unset ($this->request->data['Transaction']['original_transaction_id']);
				$this->request->data['Transaction']['original_transaction_id'] = 0;
			}
			if ($this->Transaction->save($this->request->data)) {
				if ($data['update_next'] == 1) {
					//$this->delete_next_repeats();
					if ($data['original_transaction_id'] > 0) {    
						$data['original_transaction_id'] = $data['id'];
					}
					if($this->insert_repeat($data, $original_date)) {
						$this->Session->setFlash(__('Transakcia bola upravená'));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('Zadajte prosím skorší deň v mesiaci pri výbere dátumu. Najneskorší povolený je 28. deň.'));
					}
					
				} else {
					$this->Session->setFlash(__('Transakcia bola upravená'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				$this->Session->setFlash(__('Transakciu sa nepodarilo upraviť. Skúste prosím znovu.'));
			}
			
			
			
		} else {
			$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
			$this->request->data = $this->Transaction->find('first', $options);
			$this->set('data', $this->request->data);
		}
		
		$user_id = $this->Session->read('User.id');
		
		$users = $this->Transaction->User->find('list');
		$this->set('transaction_types', $this->Transaction->TransactionType->find('list'));
		$this->set('categories', $this->Transaction->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		//$this->set('subcategories', $this->Transaction->Subcategory->find('list', array('conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('subcategories', $this->Transaction->Subcategory->find('all', array('fields' => array('Subcategory.category_id', 'Subcategory.id', 'Subcategory.name'), 'recursive' => 1, 'conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('user', $user_id);
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->check_ownership($id) ) {
			throw new PrivateActionException(__('Na prístup k tejto operácii nemáte oprávnenie.'));
		}
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Zlá transakcia'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('Transakcia bola vymazaná'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transakciu sa nepodarilo vymazať'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	/**
	* delete_next_repeats method
	*
	* @throws NotFoundException
	* @throws MethodNotAllowedException
	* @param string $id
	* @return void
	*/
	public function delete_next_repeats($id = null) {
		if (!$this->check_ownership($id) ) {
			throw new PrivateActionException(__('Na prístup k tejto operácii nemáte oprávnenie.'));
		}
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Zlá transakcia'));
		}
		//$this->request->onlyAllow('post', 'delete');
		
		$original_id = $this->Transaction->field('original_transaction_id');
		$post_date = $this->Transaction->field('post_date');
		
		if ($this->Transaction->delete()) {
// 			$original_id = $this->Transaction->original_transaction_id;
// 			$post_date = $this->Transaction->post_date;
// echo $original_id.' | '.$post_date;
			if($original_id > 0) {
				if($this->Transaction->deleteAll(array('Transaction.original_transaction_id' => $original_id, 'Transaction.post_date >' => $post_date ), false)) {
					$this->Session->setFlash(__('Vybraté opakovanie transakcie a jej neskoršie opakovania boli vymazané.'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				if($this->Transaction->deleteAll(array('Transaction.original_transaction_id' => $id, 'Transaction.post_date >' => $post_date ), false)) {
					$this->Session->setFlash(__('Vybratá transakcia a jej neskoršie opakovania boli vymazané.'));
					$this->redirect(array('action' => 'index'));
				}
			}
// 			$this->Session->setFlash(__('Vybratá transakcia a jej neskoršie opakovania boli vymazané.'));
// 			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transakcia nebola vymazaná.'));
		//$this->redirect(array('action' => 'index'));
	}
	
	private function insert_repeat($data, $original_date) {
		if(!$this->Transaction->insert_repeat($data, $original_date)) {
			return false;
		} else {
			return true;
		} 
	}
	
	/* private function insert_repeat($data, $original_date) {
		$pom_data= array();
		
		$this->Transaction->deleteAll(array('Transaction.original_transaction_id' => $data['original_transaction_id'], 'Transaction.post_date >' => $original_date, 'Transaction.id <>' => $data['id']  ), false);
			
		
		
		for ($i = 1; $i<= $data['number_of_cycles']; $i++) {
			$timestamp= strtotime($data['post_date']);
			$day_of_the_month= date('j', $timestamp);	// kolky den v mesiaci bol nastaveny
			$month_of_the_year=date('n', $timestamp);
			if ($data['repeat_every'] == 'tyzden') {   //  ak je nastavene opakovanie kazdy tyzden
				$future_timestamp= strtotime("+$i week", $timestamp);
					
				$pom_data[] =
				array(
						'transaction_type_id' => $data['transaction_type_id'],
						'name' => $data['name'],
						'amount' => $data['amount'],
						'category_id' => $data['category_id'],
						'subcategory_id' => $data['subcategory_id'],
						'user_id' => $data['user_id'],
						'post_date' => date('Y-m-d', $future_timestamp),
						'original_transaction_id' => $data['original_transaction_id'], );
					
			}
			if ($data['repeat_every'] == 'mesiac') { 		// ak je nastavene opakovanie kazdy mesiac
				if ($day_of_the_month < 29) {
					$future_timestamp= strtotime("+$i month", $timestamp);
						
					$pom_data[] =
					array(
							'transaction_type_id' => $data['transaction_type_id'],
							'name' => $data['name'],
							'amount' => $data['amount'],
							'category_id' => $data['category_id'],
							'subcategory_id' => $data['subcategory_id'],
							'user_id' => $data['user_id'],
							'post_date' => date('Y-m-d', $future_timestamp),
							'original_transaction_id' => $data['original_transaction_id'], );
				}
				else {			// nastaveny prilis neskory datum v mesiaci
					if (!$this->Transaction->exists()) {
						throw new NotFoundException(__('Zlá transakcia'));
					}
					$this->request->onlyAllow('post', 'delete');   // potrebujem zmazat prvu vytvorenu originalnu transakciu, pretoze ostatne sa nemohli vytvorit
					if ($this->Transaction->delete()) {
						//$this->Session->setFlash(__('Zbytocna transakcia bola zmazaná'));
						$this->Session->setFlash(__('Zadajte prosím skorší deň v mesiaci pri výbere dátumu. Najneskorší povolený je 28. deň.'));
						//$this->redirect(array('action' => 'index'));
					}
					//$this->Session->setFlash(__('Zbytočnú transakciu sa nepodarilo zmazať'));
					//$this->redirect(array('action' => 'index'));
				}
					
			}
			if ($data['repeat_every'] == 'rok') { 		// ak je nastavene opakovanie kazdy rok
				if (($day_of_the_month == 29) && ($month_of_the_year == 2)) {
					$future_timestamp= strtotime("+$i year -1 day", $timestamp);   // ak je nastaveny 29.feb tj. priestupny rok zmeni nasledujuce opakovania na 28.feb
		
					$pom_data[] =
					array(
							'transaction_type_id' => $data['transaction_type_id'],
							'name' => $data['name'],
							'amount' => $data['amount'],
							'category_id' => $data['category_id'],
							'subcategory_id' => $data['subcategory_id'],
							'user_id' => $data['user_id'],
							'post_date' => date('Y-m-d', $future_timestamp),
							'original_transaction_id' => $data['original_transaction_id'], );
				}
				else {
					$future_timestamp= strtotime("+$i year", $timestamp);
		
					$pom_data[] =
					array(
							'transaction_type_id' => $data['transaction_type_id'],
							'name' => $data['name'],
							'amount' => $data['amount'],
							'category_id' => $data['category_id'],
							'subcategory_id' => $data['subcategory_id'],
							'user_id' => $data['user_id'],
							'post_date' => date('Y-m-d', $future_timestamp),
							'original_transaction_id' => $this->Transaction->id );
				}
					
			}
		}
		$this->Transaction->create();
		$this->Transaction->saveMany($pom_data);
		//print_r($pom_data);
		
	} */
	
	private function check_ownership($id) {    
		$user_transaction = $this->Transaction->find('first', array(
    'conditions' => array('Transaction.id' => $id),));
		if ($this->Session->read('User.id') == $user_transaction['Transaction']['user_id']) {
			return true;
		}
		else {
			return false;
		}
 	}

 	
}
	



