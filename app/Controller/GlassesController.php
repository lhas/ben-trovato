<?php
App::uses('AppController', 'Controller');
/**
 * Glasses Controller
 *
 */
class GlassesController extends AppController {

/**
 * Método para recuperar todos os atributos usados.
 */
	private function getAttributes() {
		
		/**
		 * Atributos do model para gerar o formulário mais DRY.
		 */
		$options['sex'] = $this->Glass->sex;
		$options['color'] = $this->Glass->color;
		$options['material'] = $this->Glass->material;
		$options['format'] = $this->Glass->format;
		$options['size'] = $this->Glass->size;
		$options['type'] = $this->Glass->type;

		// Envia os atributos do model para a view
		$this->set(compact('options'));
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Glass->recursive = 0;

		$this->paginate = array(
			'order' => array(
				'Glass.created' => 'DESC'
			)
		);
		
		$this->set('glasses', $this->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Glass->create();
			if ($this->Glass->save($this->request->data)) {
				$this->Session->setFlash(__('The glass has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The glass could not be saved. Please, try again.'));
			}
		}

		$this->getAttributes();
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Glass->exists($id)) {
			throw new NotFoundException(__('Invalid glass'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Glass->save($this->request->data)) {
				$this->Session->setFlash(__('The glass has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The glass could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Glass.' . $this->Glass->primaryKey => $id));
			$this->request->data = $this->Glass->find('first', $options);
		}

		$this->getAttributes();
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Banner->id = $id;
		if (!$this->Banner->exists()) {
			throw new NotFoundException(__('Invalid banner'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Banner->delete()) {
			$this->Session->setFlash(__('Banner deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Banner was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
