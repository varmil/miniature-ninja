<?php
/**
 * @author yamamoto_akihiro
 */

require_once 'Foo.php';

class FooExtend extends Foo {
	function extend_method() {
		$val = $this->var_for_extend;
		
		return $val;
	}
} 