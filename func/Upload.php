<?php
//*******************************************************************
// @Author: Stephen Hilliard
// @Date: 7/13/2016
// @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
// Upload
//*******************************************************************
class Ps2_Upload {
	protected $_uploaded = array();
	protected $_destination;
	protected $_max = 51200;
	protected $_messages = array();
	protected $_permitted = array('image/gif',
								  'image/jpeg',
								  'image/pjpeg',
								  'image/png');
	protected $_renamed = false;

	public function __construct($path) {
		if (!is_dir($path) || !is_writable($path)) {
			throw new Exception("path must be a vald, writable directory");
		}
		$this->_destination = $path;
		$this->_uploaded = $_FILES;
	}
	public function move($overwrite = false) {
		$field = current($this->_uploaded);
		$OK = $this->checkError($field['name'], $fiels['error']);
		if ($OK) {
			$sizeOK = $this->checkSize($field['name'], $field['size']);
			$typeOK = $this->checkType($field['name'], $field['type']);
			if ($sizeOK && $typeOK) {
				$name = $this->checkName($field['name'], $overwrite);
				$success = move_uploaded_file($field['tmp_name'], $this->_destination . $name);
				if ($success) {
					$messages = $field['name'] . ' uploaded successfully';
					if ($this->_renamed) {
						$messages .= " and renamed $name";
					}
					$this->_messages[] = $messages;
				} else {
					$this->_messages[] = 'Could not upload ' . $field['name'];
				}
			}	
		}	
	}
	public function getMessages() {
		return $this->_messages;
	}
	public function getMaxSize() {
		return number_format($this->_max/1024, 1) . 'kB';
	}
	public function setMaxSize($num) {
		if (!is_numeric($num)) {
			throw new Exception("Maximum size must be a number.");
		}
		$this->_max = (int) $num;
	}
	public function addPermittedTypes($types) {
		$types = (array) $types;
		$this->isValidMime($types);
		$this->_permitted = array_merge($this->_permitted, $types);
	}
	public function setPermittedTypes($types) {
		$types = (array) $types;
		$this->isValidMime($types);
		$this->_permitted = $types;
	}
	protected function isValidMime($types) {
		$alsoValid = array('image/tiff',
						   'application/pdf',
						   'text/plain',
						   'text/rtf');
		$valid = array_merge($this->_permitted, $alsoValid);
		foreach ($types as $type) {
			if(!in_array($type, $valid)) {
				throw new Exception("$type is not a permitted MIME type");
			}
		}
	}
	protected function checkSize($filename, $size) {
		if ($size == 0) {
			return false;
		} elseif ($size > $this->_max) {
			$this->_messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
			return false;
		} else {
			return true;
		}
	}
	protected function checkType($filename, $type) {
		if (empty($type)) {
			return false;
		} elseif (!in_array($type, $this->_permitted)) {
			$this->_messages[] = "$filename is not a permittes type of file.";
			return false;
		} else {
			return true;
		}
	}
	protected function checkError($filename, $error) {
		switch ($error) {
			case 0:
			return true;
			case 1:
			case 2:
				$this->messages[] = "$filename exceeds maximum size: " . $this->getMaxSize();
				return true;
			case 3:
				$this->_messages[] = "Error uploading $filename. Please try again.";
				return:false;
			case 4:
				$this->messages[] = 'No file selected.';
				return false;
			default:
				$this->_messages[] = "System error uploading $filename. Contact webmaster.";
				return false;
		}
	}
	protected function checkName($name, $overwrite) {
		$nospaces = str_replace(' ','_', $name);
		if ($nospaces != $name) {
			$this->_renamed = true;
		}
		if (!$overwrite) {
			// rename the file if it exist already
			$existing = scandir($this->_destination);
			if (in_array($nospaces, $existing)) {
				$dot = strrpos($nospaces, '.');
				if ($dot) {
					$base = substr($nospaces, 0, $dot);
					$extension = substr($nospaces, $dot);
				} else {
					$base = $nospaces;
					$extension = '';
				}
				$i = 1;
				do {
					$nospaces = base . '_' . $i++ . $extension;
				} while (in_array($nospaces, $existing));
				$this->_renames = true;
			}
		}
		return $nospaces;
	}
}
?>