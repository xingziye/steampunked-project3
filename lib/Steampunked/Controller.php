<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/12/16
 * Time: 1:55 PM
 */

namespace Steampunked;


class Controller
{
    public function __construct(Steampunked $steampunked, $post) {
        $this->steampunked = $steampunked;

        if (isset($post['player1']) and isset($post['player2']) and isset($post['gamesize'])) {
            $player0 = new Player(strip_tags($post['player1']), 0);
            $player1 = new Player(strip_tags($post['player2']), 1);
            $this->steampunked->createGame($post['gamesize'], $player0, $player1);
        }

        if(isset($post['leak']) and isset($post['radio'])){
            $split = explode(',', strip_tags($post['leak']));
            $row = intval($split[0]);
            $col = intval($split[1]);

            $turn = $this->steampunked->getTurn();
            $ndx = intval($post['radio']);
            $pipe = clone $this->steampunked->getPlayer($turn)->getSelections()[$ndx];
            $result = $this->steampunked->addPipe($pipe, $row, $col);
            if ($result == Steampunked::SUCCESS) {
                $pipe = new Tile(Tile::PIPE, $turn);
                $this->steampunked->getPlayer($turn)->setSelection($pipe, $ndx);
                $this->steampunked->nextTurn();
            }
            else if ($result == Steampunked::LOSE) {
                $this->steampunked->setContinued(false);
                $this->steampunked->nextTurn();
            }
        }
        else if(isset($post['rotate']) and isset($post['radio'])){
            $turn = $this->steampunked->getTurn();
            $ndx = intval($post['radio']);
            $this->steampunked->getPlayer($turn)->getSelections()[$ndx]->rotate();
        }
        else if(isset($post['discard']) and isset($post['radio'])){
            $turn = $this->steampunked->getTurn();
            $ndx = intval($post['radio']);
            $pipe = new Tile(Tile::PIPE, $turn);
            $this->steampunked->getPlayer($turn)->setSelection($pipe, $ndx);
            $this->steampunked->nextTurn();
        }
        else if(isset($post['open'])){
            $turn = $this->steampunked->getTurn();
            if ($this->steampunked->openValve($turn)) {
                $this->steampunked->nextTurn();
                $this->steampunked->setContinued(false);
            } else {
                $this->steampunked->setContinued(false);
            }
        }
        else if(isset($post['giveup'])){
            $this->steampunked->nextTurn();
            $this->steampunked->setContinued(false);
        }
        else if(isset($post['newgame'])){
            $this->page = './';
            $this->steampunked->setContinued(true);
            $this->reset = true;
        }
    }

    public function isReset()
    {
        return $this->reset;
    }

    public function getPage()
    {
        return $this->page;
    }

    private $page = 'game.php';     // The next page we will go to
    private $steampunked;
    private $reset = false;
}