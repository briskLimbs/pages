<?php

class Pages {
	private $table;

	function __construct() {
		global $limbs;
		$this->limbs = $limbs;
		$this->database = $this->limbs->database;
		$this->table = 'pages';
		$this->KEYS = $this->database->getColumnsList($this->table);
		$this->defaultLimit = 10;
	}
	public function get($id) {
		$this->database->where('id', $id);
		return $this->database->getOne($this->table);
	}

	public function count($parameters = false) {
		if ($parameters) {
			$parameters['count'] = true;
			return $this->list($parameters);
		} else {
			return $this->database->getValue($this->table, 'count(*)');
		}
	}

	public function list($parameters = false) {
		if (is_array($parameters)) {
			foreach ($parameters as $column => $condition) {
				if (in_array($column, $this->KEYS)) {
					if (is_array($condition)) {
						$this->database->where($column, $condition['0'], $condition['1']);
					} else {
						$this->database->where($column, $condition);
					}
				}
			}
		}

		$limit = isset($parameters['limit']) ? $parameters['limit'] : $this->defaultLimit;
		$sort = isset($parameters['sort']) ? $parameters['sort'] : 'id';
		if ($sort) {
			if (is_array($sort)) {
				$this->database->orderBy($sort['0'], isset($sort['1']) ? $sort['1'] : 'DESC');
			} else {
				$this->database->orderBy($sort);
			}
		}
		
		return isset($parameters['count']) ? $this->database->getValue($this->table, 'count(*)') : $this->database->get($this->table, $limit);
	}

	public function slugExists($slug, $page = false) {
		if ($page) {
			$this->database->where('id', $page);
		}
    $this->database->where('slug', $slug);
    return $this->database->getValue($this->table, 'count(*)');
  }

	public function validate($formData, $update = false) {
		if (empty($formData['title'])) {
			return $this->limbs->errors->add('Page title is required');
		}

		if ($this->slugExists($formData['slug'], $update)) {
			return $this->limbs->errors->add('Page slug already exists');	
		}

		return true;
	}

	public function add($formData) {
		if ($this->validate($formData)) {
			return $this->database->insert($this->table, $formData);
		}
	}

	public function setField($field, $value, $identifierValue, $identifier = 'vkey') {
		$this->database->where($identifier, $identifierValue);
		return $this->database->update($this->table, array($field => $value));
	}

	public function setFields($fieldValueArray, $identifierValue, $identifier = 'vkey') {
		$this->database->where($identifier, $identifierValue);
		return $this->database->update($this->table, $fieldValueArray);
	}

	public function update($id, $fields) {
		if ($this->validate($fields, $id)) {
			return $this->setFields($fields, $id, 'id');
		}	
	}

	public function activate($page) {
    return $this->setField('status', 'active', $page, 'id');
  }
	
	public function deactivate($page) {
    return $this->setField('status', 'inactive', $page, 'id');
  }

  public function delete($page) {
    $this->database->where('id', $page);
    return $this->database->delete($this->table);
  }
}