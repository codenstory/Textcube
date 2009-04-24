<?php
/// Copyright (c) 2004-2009, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)
class Model_TrackbackLog {
	function __construct() {
		$this->reset();
	}

	function reset() {
		$this->error =
		$this->id =
		$this->entry =
		$this->url =
		$this->sent =
			null;
	}
	
	function open($filter = '', $fields = '*', $sort = 'written') {
		global $database;
		if (is_numeric($filter))
			$filter = 'AND id = ' . $filter;
		else if (!empty($filter))
			$filter = 'AND ' . $filter;
		if (!empty($sort))
			$sort = 'ORDER BY ' . $sort;
		$this->close();
		$this->_result = Data_IAdapter::query("SELECT $fields FROM {$database['prefix']}RemoteResponseLogs WHERE blogid = ".getBlogId()." AND type = 'trackback' $filter $sort");
		if ($this->_result) {
			if ($this->_count = Data_IAdapter::num_rows($this->_result))
				return $this->shift();
			else
				Data_IAdapter::free($this->_result);
		}
		unset($this->_result);
		return false;
	}
	
	function close() {
		if (isset($this->_result)) {
			Data_IAdapter::free($this->_result);
			unset($this->_result);
		}
		$this->_count = 0;
		$this->reset();
	}
	
	function shift() {
		$this->reset();
		if ($this->_result && ($row = Data_IAdapter::fetch($this->_result))) {
			foreach ($row as $name => $value) {
				if ($name == 'blogid')
					continue;
				switch ($name) {
					case 'written':
						$name = 'sent';
						break;
				}
				$this->$name = $value;
			}
			return true;
		}
		return false;
	}
	
	function add() {
		if (!isset($this->id))
			$this->id = $this->nextId();
		else $this->id = $this->nextId($this->id);
		if (!isset($this->entry))
			return $this->_error('entry');
		if (!isset($this->url))
			return $this->_error('url');
		
		if (!$query = $this->_buildQuery())
			return false;
		if (!$query->hasAttribute('written'))
			$query->setAttribute('written', 'UNIX_TIMESTAMP()');
		
		if (!$query->insert())
			return $this->_error('insert');
		
		return true;
	}
	
	function getCount() {
		return (isset($this->_count) ? $this->_count : 0);
	}
	
	function nextId($id = 0) {
		global $database;
		$maxId = Data_IAdapter::queryCell("SELECT max(id) FROM {$database['prefix']}RemoteResponseLogs WHERE blogid = ".getBlogId());
		if($id == 0)
			return $maxId + 1;
		else
			 return ($maxId > $id ? $maxId : $id);
	}
	
	function _buildQuery() {
		global $database;
		$query = new Data_table($database['prefix'] . 'RemoteResponseLogs');
		$query->setQualifier('blogid', getBlogId());
		$query->setQualifier('type', 'trackback',false);
		if (isset($this->id)) {
			if (!Validator::number($this->id, 1))
				return $this->_error('id');
			$query->setQualifier('id', $this->id);
		}
		if (isset($this->entry)) {
			if (!Validator::number($this->entry, 1))
				return $this->_error('entry');
			$query->setAttribute('entry', $this->entry);
		}
		if (isset($this->url)) {
			$this->url = UTF8::lessenAsEncoding(trim($this->url), 255);
			if (empty($this->url))
				return $this->_error('url');
			$query->setAttribute('url', $this->url, true);
		}
		if (isset($this->sent)) {
			if (!Validator::timestamp($this->sent))
				return $this->_error('sent');
			$query->setAttribute('written', $this->sent);
		}
		return $query;
	}

	function _error($error) {
		$this->error = $error;
		return false;
	}
}
?>