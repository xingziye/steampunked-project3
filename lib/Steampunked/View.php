<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/12/16
 * Time: 1:55 PM
 */

namespace Steampunked;


class View
{
    /**
     * Constructor
     * @param Steampunked $steampunked The Steakmpunked game object
     */
    public function __construct(Steampunked $steampunked) {
        $this->game = $steampunked;
    }

    public function createGrid(){

        $html = <<<HTML
        <div class="container">
    <p><img src="images/title.png"></p>
    <form method="post" action="game-post.php">
            <div class="game">
HTML;

        ///loop for Number X Number grid
        $size = $this->game->getSize();
        for ($row = 0; $row < $size; $row++) {
            $html .= "<div class=\"row\">";
            for ($col = -1; $col < $size + 1; $col++) {
                if ($col == -1) {
                    $valves = $this->game->getValves();
                    $image = $this->getImage($valves[$row]);
                    $html .= "<div class=\"cell\"><img src=$image></div>";
                }
                else if ($col == $size) {
                    $gauges = $this->game->getGauges();
                    $image = $this->getImage($gauges[$row]);
                    $html .= "<div class=\"cell\"><img src=$image></div>";
                } else {
                    $pipe = $this->game->getPipe($row, $col);
                    if ($pipe !== null and $pipe->getType() == Tile::LEAK and $pipe->getId() == $this->game->getTurn()) {
                        switch($pipe->open()) {
                            case array("N"=>true, "E"=>false, "S"=>false, "W"=>false):
                                $html .= "<div class=\"cell\"><input class='north' type=\"submit\" name=\"leak\" value=\"$row, $col\"></div>";
                                break;
                            case array("N"=>false, "E"=>true, "S"=>false, "W"=>false):
                                $html .= "<div class=\"cell\"><input class='east' type=\"submit\" name=\"leak\" value=\"$row, $col\"></div>";
                                break;
                            case array("N"=>false, "E"=>false, "S"=>true, "W"=>false):
                                $html .= "<div class=\"cell\"><input class='south' type=\"submit\" name=\"leak\" value=\"$row, $col\"></div>";
                                break;
                            case array("N"=>false, "E"=>false, "S"=>false, "W"=>true):
                                $html .= "<div class=\"cell\"><input class='west' type=\"submit\" name=\"leak\" value=\"$row, $col\"></div>";
                        }
                    } else {
                        $image = $this->getImage($pipe);
                        $html .= "<div class=\"cell\"><img src=$image></div>";
                    }
                }
            }
            $html .= "</div>";

        }

        $html .= "</div>";

        return $html;
    }

    public function presentTurn() {
        $turn = $this->game->getTurn();
        $name = $this->game->getPlayer($turn)->getName();
        if($this->game->isContinued() == false){
            $html = "<p class=\"message\">$name, your win!</p>";
        }
        else{
            $html = "<p class=\"message\">$name, your turn!</p>";
        }

        return $html;
    }

    public function createRadioButtons(){
        $turn = $this->game->getTurn();
        $selections = $this->game->getPlayer($turn)->getSelections();
        $images = array();
        foreach($selections as $pipe) {
            $images[] = $this->getImage($pipe);
        }

        $html ="";

        if($this->game->isContinued() == true) {
            $html = <<<HTML
        <p class="pieces">
            <label for="radio1"><img src=$images[0] /></label>
            <input type="radio" name="radio" id="radio1" value="0" >
            <label for="radio2"><img src=$images[1] /></label>
            <input type="radio" name="radio" id="radio2" value="1" >
            <label for="radio3"><img src=$images[2] /></label>
            <input type="radio" name="radio" id="radio3" value="2" >
            <label for="radio4"><img src=$images[3] /></label>
            <input type="radio" name="radio" id="radio4" value="3" >
            <label for="radio5"><img src=$images[4] /></label>
            <input type="radio" name="radio" id="radio5" value="4" >
        </>
HTML;
        }

        return $html;
    }

    public function createOptionButtons(){
        if($this->game->isContinued() == false){
            $html = <<<HTML
        <div class="options">
            <p class="option"><input type="submit" name="newgame" value="New Game"></p>
        </div>
        </form>
        </div>

HTML;
        }
        else{
            $html = <<<HTML
        <div class="options">
            <p class="option"><input type="submit" name="rotate" value="Rotate"></p>
            <p class="option"><input type="submit" name="discard" value="Discard"></p>
            <p class="option"><input type="submit" name="open" value="Open Valve"></p>
            <p class="option"><input type="submit" name="giveup" value="Give Up"></p>
        </div>
        </form>
        </div>

HTML;
        }
        return $html;
    }

    /**
     * @param Tile
     * @return string
     */
    public function getImage($tile) {
        if ($tile === null) {
            return '';
        }

        switch($tile->getType()) {
            case Tile::PIPE:
                switch($tile->open()) {
                    case array("N"=>true, "E"=>false, "S"=>false, "W"=>false):
                        return 'images/cap-n.png';
                    case array("N"=>false, "E"=>true, "S"=>false, "W"=>false):
                        return 'images/cap-e.png';
                    case array("N"=>false, "E"=>false, "S"=>true, "W"=>false):
                        return 'images/cap-s.png';
                    case array("N"=>false, "E"=>false, "S"=>false, "W"=>true):
                        return 'images/cap-w.png';
                    case array("N"=>true, "E"=>false, "S"=>true, "W"=>false):
                        return 'images/straight-v.png';
                    case array("N"=>false, "E"=>true, "S"=>false, "W"=>true):
                        return 'images/straight-h.png';
                    case array("N"=>true, "E"=>true, "S"=>false, "W"=>false):
                        return 'images/ninety-ne.png';
                    case array("N"=>false, "E"=>true, "S"=>true, "W"=>false):
                        return 'images/ninety-es.png';
                    case array("N"=>false, "E"=>false, "S"=>true, "W"=>true):
                        return 'images/ninety-sw.png';
                    case array("N"=>true, "E"=>false, "S"=>false, "W"=>true):
                        return 'images/ninety-wn.png';
                    case array("N"=>false, "E"=>true, "S"=>true, "W"=>true):
                        return 'images/tee-esw.png';
                    case array("N"=>true, "E"=>false, "S"=>true, "W"=>true):
                        return 'images/tee-swn.png';
                    case array("N"=>true, "E"=>true, "S"=>false, "W"=>true):
                        return 'images/tee-wne.png';
                    case array("N"=>true, "E"=>true, "S"=>true, "W"=>false):
                        return 'images/tee-nes.png';
                }
            case Tile::LEAK:
                switch($tile->open()) {
                    case array("N" => true, "E" => false, "S" => false, "W" => false):
                        return 'images/leak-n.png';
                    case array("N" => false, "E" => true, "S" => false, "W" => false):
                        return 'images/leak-e.png';
                    case array("N" => false, "E" => false, "S" => true, "W" => false):
                        return 'images/leak-s.png';
                    case array("N" => false, "E" => false, "S" => false, "W" => true):
                        return 'images/leak-w.png';
                }
            case Tile::VALVE_CLOSE:
                return 'images/valve-closed.png';
            case Tile::VALVE_OPEN:
                return 'images/valve-open.png';
            case Tile::GAUGE0:
                return 'images/gauge-0.png';
            case Tile::GAUGE190:
                return 'images/gauge-190.png';
            case Tile::GAUGE_TOP0:
                return 'images/gauge-top-0.png';
            case Tile::GAUGE_TOP190:
                return 'images/gauge-top-190.png';
        }
    }

    public function createStartPage(){
        $html = <<<HTML
        <div class="screen">
    <p><img src="images/title.png" alt="Steampunked Logo"></p>
    <form method="post" action="game-post.php">
        <fieldset>
            <legend>Game Preferences</legend>
            <p>
                <label for="player1"> Player 1 Name:</label>
                <input type="text" name="player1" id="player1">
            </p>
            <br>
            <p>
                <label for="player2"> Player 2 Name:</label>
                <input type="text" name="player2" id="player2">
            </p>
            <br>
            <p>
                <label for="6x6">6x6</label>
                <input type="radio" name="gamesize" id="6x6" value="6" checked="checked" >
                <label for="10x10">10x10</label>
                <input type="radio" name="gamesize" id="10x10" value="10">
                <label for="20x20">20x20</label>
                <input type="radio" name="gamesize" id="20x20" value="20">
            </p>
            <br>
            <p>
                <input type="submit">
            </p>
        </fieldset>
    </form>
</div>

HTML;

        return $html;
    }


    private $game;
}