<?php
App::uses('AppController', 'Controller');
/**
 * Imports Controller
 *
 * @property Import $Import
 */
class ImportsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		$this->paginate = array(
				'limit' => 20,
				'conditions' => array(
						'Import.user_id' => $this->Session->read('User.id'),
				),
		);
		
		$this->Import->recursive = 0;
		$this->set('imports', $this->paginate());
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
			throw new PrivateActionException(__('Na prístup k tomuto importu nemáte oprávnenie.'));
		}
		if (!$this->Import->exists($id)) {
			throw new NotFoundException(__('Invalid import'));
		}
		$options = array('conditions' => array('Import.' . $this->Import->primaryKey => $id));
		$this->set('import', $this->Import->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Import->create();
			
			$file = $this->data['Import']['file'];
			print_r($file['name']);			
			
			$fp = fopen($file['tmp_name'], 'r');	// make blob
			$content = fread($fp, filesize($file['tmp_name']));
			$blob = base64_encode($content);
			
			$extension = explode('.', $file['name']);  //	$extension = 'txt';
			$extension = array_pop($extension);
			fclose($fp);
			
			$loaded_file['Import']['filename'] = $file['name'];
			$loaded_file['Import']['xml_file'] = $blob;
			$loaded_file['Import']['user_id'] = $this->data['Import']['user_id'];
		
			$file_content = file_get_contents($file['tmp_name']);
				
			switch (strtolower($extension))
			{
				case 'txt':
					break;
				default: $this->Session->setFlash(__('Vybrali ste zlý typ súboru.'));
			}
			
			print_r($loaded_file);
			print_r($this->request->data);
			if ($this->Import->save($loaded_file)) {
				$this->Session->setFlash(__('Súbor bol importovaný.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Súbor sa nepodarilo importovať. Skúste prosím znovu.'));
			}
		}
		$user_id = $this->Session->read('User.id');
		
		$users = $this->Import->User->find('list');
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
			throw new PrivateActionException(__('Na prístup k tomuto importu nemáte oprávnenie.'));
		}
		if (!$this->Import->exists($id)) {
			throw new NotFoundException(__('Zlý import'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Import->save($this->request->data)) {
				$this->Session->setFlash(__('Import bol uložený.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Import sa nepodarilo uložiť. Skúste prosím znovu.'));
			}
		} else {
			$options = array('conditions' => array('Import.' . $this->Import->primaryKey => $id));
			$this->request->data = $this->Import->find('first', $options);
		}
		$users = $this->Import->User->find('list');
		$this->set(compact('users'));
		$this->set('import', $this->Import->find('first', $options));
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
			throw new PrivateActionException(__('Na prístup k tomuto importu nemáte oprávnenie.'));
		}
		$this->Import->id = $id;
		if (!$this->Import->exists()) {
			throw new NotFoundException(__('Zlý import'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Import->delete()) {
			$this->Session->setFlash(__('Import bol vymazaný.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Import nebol vymazaný.'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function parsing_slsp_abo($file_content) {
		
		$lines = split("\n", $file_content);
		
		for ($i = 0; $i < count($lines) - 1; $i++) {
			if ($i == 0) {   // Ak je to prvá veta - tzv. úvodná veta
			
				$header_line = $lines[0];
				// Označenie úvodnej vety Num(3) Konštanta "074"
				$parsed_file['header']['type'] = substr($header_line, 0, 3);

				// Čislo účtu Num(10) Číslo účtu (modulo11) v tvare jednotlivé pozície čísla účtu sú zmenené takto: ak je číslo účtu 0123456789, tak v poli pre číslo účtu je v tvare: 9785012346
				$cislo_uctu_klienta = substr($header_line, 3, 10);
				$cislo_uctu_klienta_decoded = substr($cislo_uctu_klienta, 4, 5) . substr($cislo_uctu_klienta, 3, 1) . substr($cislo_uctu_klienta, 9, 1) . substr($cislo_uctu_klienta, 1, 2) . substr($cislo_uctu_klienta, 0, 1);
				$parsed_file['header']['cislo_klienta'] = $cislo_uctu_klienta_decoded;

				// Predčíslo účtu Num(6) Predčíslo účtu {000000}
				// Názov účtu Char(20) Názov účtu
				$parsed_file['header']['nazov_org'] = substr($header_line, 19, 20);

				// Dátum predchádz. výpisu Date(6) Dátum v tvare DDMMRR
				$statement_from = substr($header_line, 39, 6);
				$statement_from_date = mktime(0, 0, 0, substr($statement_from, 2, 2), substr($statement_from, 0, 2), substr($statement_from, 4, 2));
				$parsed_file['header']['statement_from'] = date("Y-m-d", $statement_from_date);
	
				// Počiatočný stav účtu Num(14) Počiatočný stav účtu
				$parsed_file['header']['stary_zostatok'] = substr($header_line, 45, 14);

				// Znamienko pre poč. stav Účtu Char(1) + kladný, - záporný
				$parsed_file['header']['znamienko_stareho_zostatku'] = substr($header_line, 59, 1);
				$parsed_file['header']['stary_zostatok'] = (int) ($parsed_file['header']['znamienko_stareho_zostatku'] . $parsed_file['header']['stary_zostatok']) / 100;

				// Konečný stav účtu Num(14) Konečný stav účtu
				$parsed_file['header']['novy_zostatok'] = ((int) substr($header_line, 60, 14) / 100);

				// Znamienko pre koneč. stav účtu Char(1) + kladný, - záporný
				$parsed_file['header']['znamienko_noveho_zostatku'] = substr($header_line, 74, 1);
				$parsed_file['header']['novy_zostatok'] = (int) ($parsed_file['header']['znamienko_noveho_zostatku'] . $parsed_file['header']['novy_zostatok']) / 100;

				// Výbery spolu Num(14) Suma debetných obratov
				$parsed_file['header']['obraty_debet'] = ((int) substr($header_line, 75, 14) / 100);

				// Znamienko pre výbery Char(1) “0“=obrat, “- “ prevažujúce storná
				$parsed_file['header']['znamienko_obratov_debet'] = substr($header_line, 89, 1);


				// Vklady spolu Num(14) Suma kreditných obratov
				$parsed_file['header']['obraty_kredit'] = ((int) substr($header_line, 90, 14) / 100);

				// Znamienko pre vklady Char(1) “0“=obrat, “- “ prevažujúce storná
				$parsed_file['header']['znamienko_obratov_kredit'] = substr($header_line, 104, 1);

				// Poradové číslo výpisu Num(3) Číslo výpisu
				$parsed_file['header']['poradove_cislo_vypisu'] = substr($header_line, 105, 3);

				// Dátum výpisu Date (6) Dátum v tvare DDMMRR
				$statement_to = substr($header_line, 108, 6);
				$statement_to_date = mktime(0, 0, 0, substr($statement_to, 2, 2), substr($statement_to, 0, 2), substr($statement_to, 4, 2));
				$parsed_file['header']['statement_to'] = date("Y-m-d", $statement_to_date);

				$parsed_file['header']['znaky_medzera'] = substr($header_line, 114, 61); 	//	dump($header);
				// Označenie dátovej vety Num(3) Konštanta "075"

				if (isset($parsed_file['header']['cislo_klienta'])) {
					$client_account_number = $parsed_file['header']['cislo_klienta'];
					$client_bank_code = '0900'; // kód banky - Slovenská sporiteľňa					
				} 
			} 
			else {			// ak sú to ďalšie vety - tzv. dátové vety 
				$parsed_file['content'][$i]['ustav'] = 'slsp';
				$parsed_file['content'][$i]['type'] = substr($lines[$i], 0, 3);

				// Čislo účtu Num(10) Číslo účtu (modulo11) v tvare*
				// Predčíslo účtu Num(6) Predčíslo účtu {000000}
				$cislo_uctu_partnera = substr($lines[$i], 3, 10);
				$cislo_uctu_decoded = substr($cislo_uctu_partnera, 4, 5) . substr($cislo_uctu_partnera, 3, 1) . substr($cislo_uctu_partnera, 9, 1) . substr($cislo_uctu_klienta, 1, 2) . substr($cislo_uctu_partnera, 0, 1);
				$predcislie_uctu_partnera = substr($lines[$i], 13, 6);
				$parsed_file['content'][$i]['account_number'] = $cislo_uctu_decoded;
				$parsed_file['content'][$i]['account_prefix'] = $predcislie_uctu_partnera;

				// Číslo protiúčtu Num(10) Číslo protiúčtu (modulo11) v tvare *
				// Predčíslo protiúčtu Num(6) Predčíslo protiúčtu {000000}
				$cislo_uctu_odosielatela = substr($lines[$i], 19, 10);
				$cislo_uctu_odosielatela_decoded = substr($cislo_uctu_odosielatela, 4, 5) . substr($cislo_uctu_odosielatela, 3, 1) . substr($cislo_uctu_odosielatela, 9, 1) . substr($cislo_uctu_klienta, 1, 2) . substr($cislo_uctu_odosielatela, 0, 1);
				$predcislie_uctu_odosielatela = substr($lines[$i], 29, 6);
				$parsed_file['content'][$i]['partner_account_number'] = $cislo_uctu_odosielatela_decoded;
				$parsed_file['content'][$i]['partner_account_prefix'] = $predcislie_uctu_odosielatela;
	
				// Číslo dokladu Num(13) Poradové číslo vety
				$parsed_file['content'][$i]['cislo_dokladu'] = substr($lines[$i], 35, 13);

				// Suma obratu Num(12) Suma obratu (posledné dve čísla sú desatinné)
				$ciastka = (int) substr($lines[$i], 48, 12);
				$parsed_file['content'][$i]['amount'] = $ciastka / 100;

				// Kód účtovania obratu Num(1) 1-výber, 2-vklad, 4-storno výberu, 5-storno vkladu
				if (substr($lines[$i], 60, 1) == '1') {
					$parsed_file['content'][$i]['payment_type'] = 'DEBET';
					$parsed_file['content'][$i]['p_type_id'] = '2';
				} 
				else {
					$parsed_file['content'][$i]['payment_type'] = 'CREDIT';
					$parsed_file['content'][$i]['p_type_id'] = '1';
				}
	
				// Variabilný symbol Num(10) Variabilný symbol
				$parsed_file['content'][$i]['original_variable_symbol'] = substr($lines[$i], 61, 10);

				// Kód banky protiúčtu Char(6) Prvé dve pozície sú medzery+“kód banky (4)“
				$parsed_file['content'][$i]['partner_account_bank_code'] = substr($lines[$i], 73, 4);

				// Konštantný symbol Num(4) Konštantný symbol
				$parsed_file['content'][$i]['constant_symbol'] = substr($lines[$i], 81, 4);

				// špecifický symbol Num (10) Špecifický symbol
				$parsed_file['content'][$i]['specific_symbol'] = substr($lines[$i], 85, 10);

				// Účt. dátum transakcie Date(6) Dátum valuty v tvare DDMMRR
				$datum_uctovania = substr($lines[$i], 91, 6);  //	debug($datum_uctovania);	// ! datum
				$value_date = mktime(0, 0, 0, substr($datum_uctovania, 2, 2), substr($datum_uctovania, 0, 2), substr($datum_uctovania, 4, 2));
				$parsed_file['content'][$i]['value_date'] = date("Y-m-d", $value_date);   // ! datum

				$problem_str = mb_substr($lines[$i], 97, 21, "HTML-ENTITIES"); 	//	translate all weird chars to html entities
				$problem_str = mb_convert_encoding($problem_str, "UTF-8", "ASCII");
				$problem_str = $this->str_translate_ansi_to_utf($problem_str);
				$problem_str = html_entity_decode($problem_str, ENT_QUOTES, "UTF-8");
	
				// Názov protiúčtu Char(21) Posledný znak je vždy medzera
				$parsed_file['content'][$i]['detail'] = $problem_str;
				$parsed_file['content'][$i]['desc'] = '';

				// Zmena položky Char(1) 0 -položka nebola nemenená,
				//					P-dodatočne menená,alebo čiastočne hradená
				//					Z-zmenená,
				//					C-čiastočná úhrada
				$parsed_file['content'][$i]['zmena_polozky_v_k1_k2'] = substr($lines[$i], 116, 1);

				//	Druh údajov Num(3) 001–úhrada, 002-inkaso
				$parsed_file['content'][$i]['druh_udajov'] = substr($lines[$i], 117, 3);

				// Účt. dátum transakcie Num(6) Dátum transakcie v tvare DDMMRR
	
				$datum_splatnosti = substr($lines[$i], 122, 6);  //	debug($datum_splatnosti);	// date
				$post_date = mktime(0, 0, 0, substr($datum_splatnosti, 2, 2), substr($datum_splatnosti, 0, 2), substr($datum_splatnosti, 4, 2));
				$parsed_file['content'][$i]['post_date'] = date("Y-m-d", $post_date);  // date

				if (isset($parsed_file['header']['account_id'])) {
					$parsed_file['content'][$i]['account_id'] = $parsed_file['header']['account_id'];
				}								
			}
		}
		return $parsed_file;
	}
			
	function str_translate_ansi_to_utf($string) {		// AINSI na UTF
		//	weird characters
		$string = str_replace("&Egrave;", $this->unichr(268), $string); //È = Č
		$string = str_replace("&egrave;", $this->unichr(269), $string); //è = č
		$string = str_replace("&szlig;", $this->unichr(225), $string); //ß = á
		$string = str_replace("&sup2;", $this->unichr(382), $string); //² = ž
		$string = str_replace("&Uuml;", $this->unichr(353), $string); //Ü = š
		$string = str_replace("&#156;", $this->unichr(352), $string); //œ = Š
		$string = str_replace("&Iuml;", $this->unichr(270), $string); //I = Ď
		//	ok, but untranslatable chars
		$string = str_replace("&#154;", $this->unichr(353), $string); //š
		$string = str_replace("&#138;", $this->unichr(352), $string); //Š
		$string = str_replace("&#158;", $this->unichr(382), $string); //ž
		$string = str_replace("&#142;", $this->unichr(381), $string); //Ž
		return $string;
	}
	
	function unichr($u) {
		return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
	}
	
	function process_import($id) {		
		
		Controller::loadModel('Transaction');
		
		if ($this->request->is('post')) {
			$this->Transaction->create();
			
			if ($this->Transaction->saveAll($this->request->data['Transaction'])) {
				$this->Session->setFlash(__('Transakcie boli importované..', true));
				$this->redirect( array( 'action'=>'index' ) );
			} else {
				$this->Session->setFlash(__('Transakcie sa nepodarilo importovať. Skúste prosím znovu.', true));
			}
		} 
			
		$importFind = $this->Import->find('first', array(
				'conditions' => array(
						'Import.user_id' => $this->Session->read('User.id'),
						'Import.id' => $id,
				)
		));
		
		$this->set('parsed', $this->parsing_slsp_abo(base64_decode($importFind['Import']['xml_file'])));			
		$user_id = $this->Session->read('User.id');
		$this->set('categories', $this->Transaction->Category->find('list', array('conditions' => array('Category.user_id' => $user_id))));
		$this->set('subcategories', $this->Transaction->Subcategory->find('all', array('fields' => array('Subcategory.category_id', 'Subcategory.id', 'Subcategory.name'), 'recursive' => 1, 'conditions' => array('Subcategory.user_id' => $user_id))));
		$this->set('user', $user_id);
		
	}
	
	private function check_ownership($id) {
		$user_import = $this->Import->find('first', array(
				'conditions' => array('Import.id' => $id),));
		if ($this->Session->read('User.id') == $user_import['Import']['user_id']) {
			return true;
		}
		else {
			return false;
		}
	}
	

}
