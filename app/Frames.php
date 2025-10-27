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

	public function frame($id) {
		var_dump($id);
		switch ($id) {
			case 745037:
				$this->render('frame/745037', 'Frame Detail: 745037');
				var_dump($id);
				break;
            case 'eliminar':
                break; // Sale del switch
            case 'actualizar':
                break; // Sale del switch
            default:
                break; // Aunque no es estrictamente necesario aquí, es buena práctica
		}
	}
}
?>