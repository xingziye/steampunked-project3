<?php

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";

class ControllerTest extends \PHPUnit_Framework_TestCase
{
	const SEED = 1422668587;

	//Test Controller construction
	public function test_construct() {
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($steampunked, array());

		//Test if Controller class constructs without error
		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('steampunked.php', $controller->getPage());
	}

	//Test post retrieval and redirects from posts
	public function test_actions() {
		//test addPiece post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($steampunked, array('add', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('add', $controller->getAction());
		$this->assertEquals("cap-e.png", $controller->getImage());
		$this->assertEquals('steampunked.php', $controller->getPage());
		//next line would check if this piece is equal to piece that has been added to the grid
		//$this->assertEquals(original piece object, piece object in intended add position));

		//test rotatePiece post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($steampunked, array('rotate', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('rotate', $controller->getAction());
		$this->assertEquals("cap-e.png", $controller->getImage());
		//next line would check if posted piece object is not equal to the rotated pieces coordinates/values
		//$this->assertNotEquals(cap-e.png object, $controller->getPieceObject());
		$this->assertEquals('steampunked.php', $controller->getPage());

		//test discardPiece post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($steampunked, array('discard', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('discard', $controller->getAction());
		$this->assertNull($controller->getImage());
		$this->assertEquals('steampunked.php', $controller->getPage());

		//test giveUp post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($steampunked, array('giveUp'));

		$this->assertInstanceOf('\Steampunked\SteampunkedController', $controller);
		$this->assertEquals('giveUp', $controller->getAction());
		$this->assertNull($controller->getImage());
		//change to correct end game page.php
		$this->assertEquals('win.php', $controller->getPage());
	}
}

/// @endcond
?>
