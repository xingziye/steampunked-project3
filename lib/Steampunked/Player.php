<?php
/**
 * Created by PhpStorm.
 * User: xingziye
 * Date: 2/15/16
 * Time: 6:18 PM
 */

namespace Steampunked;


class Player
{
    public function __construct($name, $id)
    {
        $this->name = $name;

        for ($i = 0; $i < 5; $i++) {
            $this->selections[] = new Tile(Tile::PIPE, $id);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSelection($pipe, $ndx)
    {
        if ($ndx >=0 and $ndx < 5) {
            $this->selections[$ndx] = $pipe;
        }
    }

    public function getSelections()
    {
        return $this->selections;
    }

    private $name;
    private $selections;
}