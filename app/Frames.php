<?php
class Frames {
	protected function frame_render($page, $title = '') {
		$data['title'] = $title;
		echo view('layouts/head', $data);
		echo view('layouts/header');
		echo view('frames/'.$page);
		echo view('layouts/footer');
	}
	public function index() {
		return redirect()->to('frames');
	}
	public function frames() {
		$this->render('frames', 'Frames');
	}
	public function frame_745037() {
		$this->frame_render('roma_745037', 'Frame Detail: 745037');
	}
	public function frame_535046() {
		$this->frame_render('roma_535046', 'Frame Detail: 535046');
	}
	public function frame_99909000() {
		$this->frame_render('roma_99909000', 'Frame Detail: 99909000');
	}
	public function frame_99916005() {
		$this->frame_render('roma_99916005', 'Frame Detail: 99916005');
	}
	public function frame_42300() {
		$this->frame_render('roma_42300', 'Frame Detail: 42300');
	}
	public function frame_57443() {
		$this->frame_render('roma_57443', 'Frame Detail: 57443');
	}
	public function frame_6236() {
		$this->frame_render('roma_6236', 'Frame Detail: 6236');
	}
	public function frame_4431() {
		$this->frame_render('roma_4431', 'Frame Detail: 4431');
	}
	public function frame_869048() {
		$this->frame_render('roma_869048', 'Frame Detail: 869048');
	}
	public function frame_606052() {
		$this->frame_render('roma_606052', 'Frame Detail: 606052');
	}
}
?>