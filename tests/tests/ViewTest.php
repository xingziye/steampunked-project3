<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";

class ViewTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct()
	{
		$steampunked = new Steampunked\Steampunked();
		$view = new Steampunked\View($steampunked);

		$this->assertInstanceOf('Steampunked\View', $view);
	}

	public function test_gridPresent()
	{
		$steampunked = new Steampunked\Steampunked();
		$steampunked->createGame(6, "Anthony", "Santoro");
		$view = new Steampunked\View($steampunked);
		$html = $view->createGrid();
		$size = $steampunked->getSize();

		$this->assertContains('<p><img src="images/title.png"></p>', $html); // beginning of view
		$this->assertContains('<div class="row">', $html);
		$this->assertContains('<div class="cell">', $html);
		$this->assertEquals(6, $size); //match 6x6 grid

	}

	public function test_buttonsPresent()
	{
		$steampunked = new Steampunked\Steampunked();
		$player0 = new Steampunked\Player("Player1", 0);
		$player1 = new Steampunked\Player("Player2", 1);
		$steampunked->createGame(6, $player0, $player1);
		$view = new Steampunked\View($steampunked);
		$html = $view->createOptionButtons();
		$num_radio = $view->createRadioButtons();

		$this->assertContains("<p class=\"option\"><input type=\"submit\" name=\"rotate\" value=\"Rotate\"></p>", $html);
		$this->assertContains("<p class=\"option\"><input type=\"submit\" name=\"discard\" value=\"Discard\"></p>", $html);
		$this->assertContains("<p class=\"option\"><input type=\"submit\" name=\"open\" value=\"Open Valve\"></p>", $html);
		$this->assertContains("<p class=\"option\"><input type=\"submit\" name=\"giveup\" value=\"Give Up\"></p>", $html);
		$this->assertContains('radio5', $num_radio); //assert 5 radio buttons present

	}

	public function test_PlayersPresent()
	{
		$steampunked = new Steampunked\Steampunked();
		$player0 = new Steampunked\Player("Player1", 0);
		$player1 = new Steampunked\Player("Player2", 1);
		$steampunked->createGame(6, $player0, $player1);
		$view = new Steampunked\View($steampunked);
		$html = $view->presentTurn();
		$this->assertContains("<p class=\"message\">Player1, your turn!</p>", $html);

		$steampunked->nextTurn(); /// advance turn
		$html = $view->presentTurn();
		$this->assertContains("<p class=\"message\">Player2, your turn!</p>", $html);


	}


	public function test_StartbuttonsPresent()
	{
		$steampunked = new Steampunked\Steampunked();
		$player0 = new Steampunked\Player("Player1", 0);
		$player1 = new Steampunked\Player("Player2", 1);
		$steampunked->createGame(6, $player0, $player1);
		$view = new Steampunked\View($steampunked);
		$html = $view->createStartPage();
		$num_radio = $view->createRadioButtons();

		$this->assertContains("<input type=\"radio\" name=\"gamesize\" id=\"6x6\" value=\"6\" checked=\"checked\" >", $html); //6x6
		$this->assertContains("<input type=\"radio\" name=\"gamesize\" id=\"10x10\" value=\"10\">", $html);//10x10
		$this->assertContains("<input type=\"radio\" name=\"gamesize\" id=\"20x20\" value=\"20\">", $html);//20x20
		$this->assertContains('radio', $num_radio); //assert 5 radio buttons present
		$this->assertContains('<input type="text" name="player1" id="player1">', $html); // player 1
		$this->assertContains('<input type="text" name="player2" id="player2">', $html); // player 2

	}
}

/// @endcond
?>
