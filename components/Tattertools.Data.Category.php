<?
class Category {
	function Category() {
		$this->reset();
	}

	function reset() {
		$this->error =
		$this->id =
		$this->parent =
		$this->label =
		$this->name =
		$this->priority =
		$this->posts =
		$this->exposedPosts =
			null;
	}
	
	/*@polymorphous(bool $parentOnly, $fields, $sort)@*/
	/*@polymorphous(numeric $id, $fields, $sort)@*/
	function open($filter = true, $fields = '*', $sort = 'priority') {
		global $database, $owner;
		if (is_numeric($filter)) {
			$filter = 'AND id = ' . $filter;
		} else if (is_bool($filter)) {
			if ($filter)
				$filter = 'AND parent IS NULL';
		} else if (!empty($filter)) {
			$filter = 'AND ' . $filter;
		}
		if (!empty($sort))
			$sort = 'ORDER BY ' . $sort;
		$this->close();
		$this->_result = mysql_query("SELECT $fields FROM {$database['prefix']}Categories WHERE owner = $owner $filter $sort");
		if ($this->_result)
			$this->_count = mysql_num_rows($this->_result);
		return $this->shift();
	}
	
	function close() {
		if (isset($this->_result)) {
			mysql_free_result($this->_result);
			unset($this->_result);
		}
		$this->_count = 0;
		$this->reset();
	}
	
	function shift() {
		$this->reset();
		if ($this->_result && ($row = mysql_fetch_assoc($this->_result))) {
			foreach ($row as $name => $value) {
				if ($name == 'owner')
					continue;
				switch ($name) {
					case 'entries':
						$name = 'exposedPosts';
						break;
					case 'entriesInLogin':
						$name = 'posts';
						break;
				}
				$this->$name = $value;
			}
			return true;
		}
		return false;
	}
	
	function add() {
		global $database, $owner;
		$this->id = null;
		if (isset($this->parent) && !is_numeric($this->parent))
			return $this->_error('parent');
		$this->name = trim($this->name);
		if (empty($this->name))
			return $this->_error('name');
		
		$query = new TableQuery($database['prefix'] . 'Categories');
		$query->setQualifier('owner', $owner);
		if (isset($this->parent)) {
			if (($parentLabel = Category::getLabel($this->parent)) === null)
				return $this->_error('parent');
			$query->setQualifier('parent', $this->parent);
			$query->setAttribute('label', $parentLabel . '/' . $this->name, true);
		} else {
			$query->setAttribute('label', $this->name, true);
		}
		$query->setQualifier('name', $this->name, true);

		if (isset($this->priority)) {
			if (!is_numeric($this->priority))
				return $this->_error('priority');
			$query->setAttribute('priority', $this->priority);
		}
		
		if ($query->doesExist()) {
			$this->id = $query->getCell('id');
			if ($query->update())
				return true;
			else
				return $this->_error('update');
		}
		if (!$query->insert())
			return $this->_error('insert');
		$this->id = $query->id;
		return true;
	}
	
	function getCount() {
		return (isset($this->_count) ? $this->_count : 0);
	}
	
	function getChildren() {
		if (!$this->id)
			return null;
		$category = new Category();
		if ($category->open('parent = ' . $this->id))
			return $category;
	}

	function escape($escape = true) {
		$this->name = Validator::escapeXML(@$this->name, $escape);
		$this->label = Validator::escapeXML(@$this->label, $escape);
	}

	/*@static@*/
	function doesExist($id) {
		global $database, $owner;
		if (!Validator::number($id, 1))
			return false;
		return DBQuery::queryExistence("SELECT id FROM {$database['prefix']}Categories WHERE owner = $owner AND id = $id");
	}
	
	/*@static@*/
	function getId($label) {
		global $database, $owner;
		if (empty($label))
			return null;
		return DBQuery::queryCell("SELECT id FROM {$database['prefix']}Categories WHERE owner = $owner AND label = '" . mysql_real_escape_string($label) . "'");
	}
	
	/*@static@*/
	function getLabel($id) {
		global $database, $owner;
		if (!Validator::number($id, 1))
			return null;
		return DBQuery::queryCell("SELECT label FROM {$database['prefix']}Categories WHERE owner = $owner AND id = $id");
	}

	/*@static@*/
	function getParent($id) {
		global $database, $owner;
		if (!Validator::number($id, 1))
			return null;
		return DBQuery::queryCell("SELECT parent FROM {$database['prefix']}Categories WHERE owner = $owner AND id = $id");
	}

	function _error($error) {
		$this->error = $error;
		return false;
	}
}
?>