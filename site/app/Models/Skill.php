<?php

namespace App\Models;

class Skill
{
    public string $id;
    public string $lvl;
    public string $position;

    public int $dec_id;
    public int $dec_position;

    public bool $exist = true;

    public function __construct(string $item)
    {
        if (strlen($item) < 8) {
            $this->exist = false;
            $position = pack('V', $item);

            $item = '000001' . bin2hex($position);
        }

        $this->id = substr($item, 0, 4);
        $this->lvl = substr($item, 4, 2);
        $this->position = '00' . substr($item, 6, 2);
        $this->dec_id = unpack('vid', hex2bin($this->id))['id'];
        $this->dec_position = unpack('npos', hex2bin($this->position))['pos'];
    }

    public function __toString(): string
    {
        return implode('', [
            $this->id,
            $this->lvl,
            substr($this->position, 2, 2)
        ]);
    }
}
