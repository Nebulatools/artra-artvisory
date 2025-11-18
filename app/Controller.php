<?php
class Controller {
	protected function render($page, $title = '') {
		$data['title'] = $title;
		echo view('layouts/head', $data);
		echo view('layouts/header');
		echo view($page);
		echo view('layouts/footer');
	}
	public function index() {
		/* return redirect()->to('home'); */
		$this->render('home', 'Home');
	}
	public function home() {
		$this->render('home', 'Home');
	}
	public function about() {
		$this->render('about', 'About');
	}
	public function artworks() {
		$this->render('artworks', 'Artworks');
	}
	public function artists() {
		$this->render('artists', 'Artists');
	}
	public function catalogue() {
		$this->render('catalogue', 'Catalogue');
	}
	public function frames() {
		$this->render('frames', 'Frames');
	}
	public function gallery() {
		$this->render('gallery', 'Gallery');
	}
	public function hwdi() {
		$this->render('hwdi', 'How We Do It');
	}
}
?>