<?php
class Works {
	protected function work_render($page, $title = '') {
		$data['title'] = $title;
		echo view('layouts/head', $data);
		echo view('layouts/header');
		echo view('artworks/'.$page);
		echo view('layouts/footer');
	}
	public function index() {
		return redirect()->to('works');
	}
	public function frames() {
		$this->render('works', 'Artworks');
	}
	public function work_01() {
		$this->work_render('work_01', 'Work #01');
	}
	public function work_02() {
		$this->work_render('work_02', 'Work #02');
	}
	public function work_03() {
		$this->work_render('work_03', 'Work #03');
	}
	public function work_04() {
		$this->work_render('work_04', 'Work #04');
	}
	/* public function work($id) {
		switch ($id) {
			case 01:
				$this->work_render('work_01', 'Work #01');
			break;
			case 'eliminar': break;
			case 'actualizar': break;
			default: break;
		}
	} */
}
?>