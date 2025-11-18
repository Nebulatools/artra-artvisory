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
	public function frame_869048() {
		$this->frame_render('roma_869048', 'Frame Detail: 869048');
	}
	public function frame_606052() {
		$this->frame_render('roma_606052', 'Frame Detail: 606052');
	}
}
?>