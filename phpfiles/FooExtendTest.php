<?php
require_once 'FooExtend.php';
class FooExtendTest extends PHPUnit_Framework_TestCase
{
	/** @var FooExtend $foo */
	private $foo;
	public function setUp() {
		$this->foo = new FooExtend();
	}
	/** @test */
	public function echo_simple() {
		$this->assertSame('hogehoge', $this->foo->extend_method() );
	}
}