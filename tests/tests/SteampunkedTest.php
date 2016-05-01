<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class ModelTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$game = new \Steampunked\Steampunked();
        $this->assertInstanceOf('Steampunked\Steampunked', $game);
        $game = new \Steampunked\Steampunked(1234);
        $this->assertInstanceOf('Steampunked\Steampunked', $game);
	}

    public function test_size() {
        $game = new \Steampunked\Steampunked();
        $player0 = new \Steampunked\Player('Tom', 0);
        $player1 = new \Steampunked\Player('Mary', 1);
        $this->assertEquals(0, $game->getSize());
        $game->createGame(6, $player0, $player1);
        $this->assertEquals(6, $game->getSize());
        $game->createGame(20, $player0, $player1);
        $this->assertEquals(20, $game->getSize());
    }

    public function test_getPlayer() {
        $game = new \Steampunked\Steampunked();
        $player0 = new \Steampunked\Player('Tom', 0);
        $player1 = new \Steampunked\Player('Mary', 1);
        $game->createGame(6, $player0, $player1);
        $this->assertEquals(null, $game->getPlayer(-1));
        $this->assertEquals($player0, $game->getPlayer(0));
        $this->assertEquals(null, $game->getPlayer(2));
        $game->createGame(6, $player0, $player1);
        $this->assertEquals($player1, $game->getPlayer(1));
    }

    public function test_turn() {
        $game = new \Steampunked\Steampunked();
        $player0 = new \Steampunked\Player('Tom', 0);
        $player1 = new \Steampunked\Player('Mary', 1);
        $game->createGame(6, $player0, $player1);
        $this->assertEquals(0, $game->getTurn());
        $game->nextTurn();
        $this->assertEquals(1, $game->getTurn());
        $game->nextTurn();
        $this->assertEquals(0, $game->getTurn());
    }

    public function test_addPipe() {
        $game = new \Steampunked\Steampunked();
        $player0 = new \Steampunked\Player('Player1', 0);
        $player1 = new \Steampunked\Player('Player2', 1);
        $game->createGame(6, $player0, $player1);
        $pipe = new \Steampunked\Tile(\Steampunked\Tile::PIPE, 0);
        $pipe->setOpen("N", false);
        $pipe->setOpen("E", true);
        $pipe->setOpen("S", false);
        $pipe->setOpen("W", true);
        $this->assertTrue($game->check($pipe, 0, 0));
        $this->assertEquals(\Steampunked\Steampunked::SUCCESS, $game->addPipe($pipe, 0, 0));

        $pipe = new \Steampunked\Tile(\Steampunked\Tile::PIPE, 0);
        $pipe->setOpen("N", false);
        $pipe->setOpen("E", true);
        $pipe->setOpen("S", false);
        $pipe->setOpen("W", false);
        $this->assertFalse($game->check($pipe, 0, 1));
        $this->assertEquals(\Steampunked\Steampunked::FAILURE, $game->addPipe($pipe, 0, 1));
    }
}

/// @endcond
?>
