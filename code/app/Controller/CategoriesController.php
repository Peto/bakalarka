<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * 
 * 
 */
class CategoriesController extends AppController {
	
	public $paginate;
	public $HighCharts = null;
	public $components = array('HighCharts.HighCharts');
	
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->paginate = array(
				'limit' => 15,
				'conditions' => array(
						'Category.user_id' => $this->Session->read('User.id'),
				),
		);
		
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
		
		$categories=$this->paginate;
		
		
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
			throw new PrivateActionException(__('Na prístup k tejto kategórii nemáte oprávnenie.'));
		}
		Controller::loadModel('Transaction');
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Zlá kategória'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
		
		////////// graf kategórií v čase ///////////
		$chartData1 = array();
			
		$chartName = 'Column Chart';
		$mychart = $this->HighCharts->create( $chartName, 'column' );
		$this->HighCharts->setChartParams(
				$chartName,
				array(
						'renderTo'				=> 'columnwrapper',  // div to display chart inside
						'chartWidth'				=> 800,
						'chartHeight'				=> 300,
						'chartMarginTop' 			=> 50,
						'chartMarginLeft'			=> 90,
						'chartMarginRight'			=> 30,
						'chartMarginBottom'			=> 60,
						'chartSpacingRight'			=> 10,
						'chartSpacingBottom'			=> 15,
						'chartSpacingLeft'			=> 0,
						'chartAlignTicks'			=> FALSE,
						'chartBackgroundColorLinearGradient' 	=> array(0,0,0,300),
						'chartBackgroundColorStops'		=> array(array(0,'rgb(217, 217, 217)'),array(1,'rgb(255, 255, 255)')),
		
						'title'					=> 'Kategória v čase',
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
		
						'xAxisLabelsEnabled' 			=> TRUE,
						'xAxisLabelsAlign' 			=> 'right',
						'xAxisLabelsStep' 			=> 1,
						//'xAxisLabelsRotation' 		=> -35,
						'xAxislabelsX' 				=> 5,
						'xAxisLabelsY' 				=> 20,

		
						'yAxisTitleText' 			=> 'Suma',
		
						/* autostep options */
						'enableAutoStep' 			=> FALSE
				)
		);
		
		$series1 = $this->HighCharts->addChartSeries();
		$series1->type = 'column';
		
		
		if(!isset($this->request->data['Filter'])) {
			$time = strtotime("-11 month", time());
			$data['from_date'] = date("Y-m-d", $time);
			$data['to_date'] = date('Y-m-d');
			$data['year_month_day'] = '2';
			if (!$this->Session->check('filterdata')) {
				$this->Session->write('filterdata', $data);
			}
		} else {
			$data= $this->request->data['Filter'];
			$this->Session->write('filterdata', $data);
			$this->redirect(array('action' => 'view/'.$id, 'page' => 1));
		}
		
		$filterdata = $this->Session->read('filterdata');
	
		$transactions = $this->Transaction->find('all', array(
				'conditions' => array(
						'Transaction.user_id' => $this->Session->read('User.id'),
						'Transaction.post_date >=' => $filterdata['from_date'],
						'Transaction.post_date <=' => $filterdata['to_date'],
						'Transaction.category_id ' => $id,
				)
		));

		$this->Transaction->recursive = 0;
		$transactionsPaginate = $this->paginate('Transaction', array('Transaction.user_id' => $this->Session->read('User.id'),
												'Transaction.post_date >=' => $filterdata['from_date'],
												'Transaction.post_date <=' => $filterdata['to_date'],
												'Transaction.category_id ' => $id,
				
				)
		);

		$this->set('transactions', $transactionsPaginate);
		
		$this->set('from_date', $filterdata['from_date']);
		$this->set('to_date', $filterdata['to_date']);

		
		$date_array1 = array();
		$xAxisCategories = array();
		
		$from_year = date('Y', strtotime($filterdata['from_date']));
		$from_month = date('m', strtotime($filterdata['from_date']));
		$from_day = date('d', strtotime($filterdata['from_date']));
		
		$to_year = date('Y', strtotime($filterdata['to_date']));
		$to_month = date('m', strtotime($filterdata['to_date']));
		$to_day = date('d', strtotime($filterdata['to_date']));
		$mesiace_preklady = array('01' => 'január', '02' => 'február', '03' => 'marec', '04' => 'apríl', '05' => 'máj', '06' => 'jún', '07' => 'júl', '08' => 'august', '09' => 'september', '10' => 'október', '11' => 'november', '12' => 'december');
		$pocet_mesiacov = (strtotime($filterdata['to_date']) - strtotime($filterdata['from_date'])) / (60*60*24*30.5);
		
		if ($filterdata['year_month_day'] == '1') {		// filtrovanie podla rokov
			for ($i = $from_year; $i<=$to_year; $i++) {
				$date_array1[(string)$i] = 0;
			}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				if ($row['Transaction']['transaction_type_id'] == '1') {
					$date_array1[$r_year] += $row['Transaction']['amount'];
				}
				else {
					$date_array1[$r_year] -= $row['Transaction']['amount'];
				}
			}
		
			foreach ($date_array1 as $year => $val) {
				$chartData1[] = $val;
				$xAxisCategories[] = $year;
			}

				
			$series1->addName('Kategória za roky')->addData($chartData1);
		}
		else
			if ($filterdata['year_month_day'] == '2') {		// filtrovanie podla mesiacov
			for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
				if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
					for ($j = $from_month; $j<= $to_month; $j++) {
						$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
					}
				}
				else {
					if ($i == $from_year){
						for ($j = $from_month; $j<= 12; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($i> $from_year && $i < $to_year) {
						for ($j = 1; $j<= 12; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
					elseif ($i == $to_year) {
						for ($j = 1; $j<= $to_month; $j++) {
							$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)] = 0;
						}
					}
				}
			}
			foreach ($transactions as $row) {
				$r_year = date('Y', strtotime($row['Transaction']['post_date']));
				$r_month = date('m', strtotime($row['Transaction']['post_date']));
				if ($row['Transaction']['transaction_type_id'] == '1') {
					$date_array1[$r_year][$r_month] += $row['Transaction']['amount'];
				}
				else {
					$date_array1[$r_year][$r_month] -= $row['Transaction']['amount'];
				}
			}
		
			foreach ($date_array1 as $year => $val) {
				foreach ($val as $month => $val2) {
					$chartData1[] = $val2;
					if ($pocet_mesiacov > 12) {
						$xAxisCategories[] = $month;
					}
					elseif ($this->is_mobile) {    // ak je na mobile zobrazim len cisla mesiacov
						$xAxisCategories[] = $month;
					}
					else
						$xAxisCategories[] = $mesiace_preklady[$month];
				}
			}
	
			$series1->addName('Kategória za mesiace')->addData($chartData1);
		}
		else
			if ($filterdata['year_month_day'] == '3') {		// filtrovanie podla dni
			for ($i = $from_year; $i<=$to_year; $i++) {			// cykluje vsetky vybrane roky
				if ($from_year == $to_year) {			// ak su vybrate mesiace len v jednom roku
					for ($j = $from_month; $j<= $to_month; $j++) {
						if ($from_month == $to_month) {			// ak su dni len z jedneho mesiaca
							for ($k = $from_day; $k<= $to_day; $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j == $from_month) {		// ak od urciteho dna po koniec mesiaca
							for ($k = $from_day; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j == $to_month) {		// od zaciatku mesiaca po urcity den v nom
							for ($k = 1; $k<= $to_day; $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
							}
						}
						elseif ($j > $from_month && $j < $to_month) {   // vsetky dni v mesiaci
							for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
								$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
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
									}
								}
								else  {   // vsetky dni
									for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
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
									}
								}
								else {			// ak je cely mesiac
									for ($k = 1; $k<= cal_days_in_month(CAL_GREGORIAN, $j, $i); $k++) {
										$date_array1[(string)$i][str_pad((string)$j, 2, '0', STR_PAD_LEFT)][str_pad((string)$k, 2, '0', STR_PAD_LEFT)] = 0;
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
				}
				else {
					$date_array1[$r_year][$r_month][$r_day] -= $row['Transaction']['amount'];
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

				
			$series1->addName('Kategória za dni')->addData($chartData1);
		}
		
		$this->HighCharts->setChartParams( $chartName,	array('xAxisCategories'	=> $xAxisCategories ));
		
		if ($this->is_mobile) {
			$this->HighCharts->setChartParams( $chartName,	array('xAxisCategories'	=> $xAxisCategories,
					'chartWidth'				=> 320	 ));
		}
		
		$mychart->addSeries($series1);	
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('Kategória bola uložená.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kategóriu sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
		}
		$user_id = $this->Session->read('User.id');
		
		$users = $this->Category->User->find('list');
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Zlá kategória'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('Kategória bola uložená.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Kategóriu sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
		$users = $this->Category->User->find('list');
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
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Zlá kategória'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('Kategória bola vymazaná.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Kategória nebola vymazaná.'));
		$this->redirect(array('action' => 'index'));
	}
	
	private function check_ownership($id) {
		$user_category = $this->Category->find('first', array(
				'conditions' => array('Category.id' => $id),));
		if ($this->Session->read('User.id') == $user_category['Category']['user_id']) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
}
