<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/15/16
 * Time: 6:07 PM
 */

namespace Steampunked;


class Tile
{
    const PIPE = 0;
    const LEAK = 1;
    const VALVE_CLOSE = 2;
    const VALVE_OPEN = 3;
    const GAUGE0 = 4;
    const GAUGE190 = 5;
    const GAUGE_TOP0 = 6;
    const GAUGE_TOP190 = 7;

    public function __construct($type, $playerID, $seed = null)
    {
        $this->type = $type;
        $this->id = $playerID;

        if ($type == Tile::PIPE) {
            $this->randOpen();
        } elseif ($type == Tile::VALVE_CLOSE) {
            $this->open = array("N"=>false, "E"=>true, "S"=>false, "W"=>false);
        } elseif ($type == Tile::GAUGE0) {
            $this->open = array("N"=>false, "E"=>false, "S"=>false, "W"=>true);
        }
    }

    public function rotate() {
        if ($this->type != Tile::PIPE) {
            return;
        }

        $temp = $this->open["N"];
        $this->open["N"] = $this->open["W"];
        $this->open["W"] = $this->open["S"];
        $this->open["S"] = $this->open["E"];
        $this->open["E"] = $temp;
    }

    public function indicateLeaks() {

        if($this->flag) {
            // Already visited
            return false;
        }

        $this->flag = true;

        $open = $this->open();
        foreach(array("N", "W", "S", "E") as $direction) {
            // Are we open in this direction?
            if($open[$direction]) {
                $n = $this->neighbor($direction);
                if($n === null) {
                    // We have a leak in this direction...
                    return true;
                } else {
                    // Recurse
                    if ($n->indicateLeaks()) {
                        return true;
                    }
                }
            }
        }
        return false;

    }

    /**
     * @return boolean
     */
    public function isFlag()
    {
        return $this->flag;
    }

    /**
     * @param boolean $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @param Tile
     * @param string
     */
    public function setNeighbor($neighbor, $direction)
    {
        $this->neighbors[$direction] = $neighbor;
        if ($this->type == Tile::LEAK) {
            $this->open = array("N"=>false, "E"=>false, "S"=>false, "W"=>false);
            $this->setOpenDirection($direction);
        }
    }

    public function neighbor($direction)
    {
        if (array_key_exists($direction, $this->neighbors)) {
            return $this->neighbors[$direction];
        }
    }

    public function getNeighbors()
    {
        return $this->neighbors;
    }

    public function open()
    {
        return $this->open;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setOpenDirection($direction)
    {
        $this->open[$direction] = true;
    }

    public function setOpen($direction, $boolean) {
        $this->open[$direction] = $boolean;
    }

    private function randOpen() {
        $this->open["N"] = (bool)rand(0,1);
        $this->open["E"] = (bool)rand(0,1);
        $this->open["S"] = (bool)rand(0,1);
        $this->open["W"] = (bool)rand(0,1);
        if ($this->open() == array("N"=>true, "E"=>true, "S"=>true, "W"=>true)) {
            $this->randOpen();
        } elseif ($this->open() == array("N"=>false, "E"=>false, "S"=>false, "W"=>false)) {
            $this->randOpen();
        }
    }

    private $type;
    private $id;
    private $flag = false;
    private $open = array();
    private $neighbors = array();
}