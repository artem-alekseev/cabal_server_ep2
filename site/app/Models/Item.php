<?php

namespace App\Models;

use Stringable;

use function Psy\bin;

class Item implements Stringable
{
    public string $id;
    public string $lvl;
    public string $bound;
    public string $postbound_bytes;
    public string $first_craft_slot;
    public string $first_craft_option;
    public string $two_craft_slot;
    public string $two_craft_option;
    public string $thrid_craft_slot;
    public string $thrid_craft_option;
    public string $count_slots;
    public string $four_craft_option;
    public string $position;
    public string $post_position_bytes;

    public int $dec_id;
    public int $dec_position;

    public bool $exist = true;
    public string $hex;

    public function __construct(string $item)
    {
        if (strlen($item) < 32) {
            $this->exist = false;
            $position = pack('V', $item);

            $item = '00000000000000000000' . bin2hex($position) . '0000';
        }

        $this->hex = $item;
        $this->id = substr($item, 0, 2) . '0'. substr($item, 3, 1);
        $this->lvl = substr($item, 2, 1);
        $this->bound = substr($item, 4, 2);
        $this->postbound_bytes = substr($item, 6, 6);
        $this->first_craft_slot = substr($item, 12, 1);
        $this->first_craft_option = substr($item, 13, 1);
        $this->two_craft_slot = substr($item, 14, 1);
        $this->two_craft_option = substr($item, 15, 1);
        $this->thrid_craft_slot = substr($item, 16, 1);
        $this->thrid_craft_option = substr($item, 17, 1);
        $this->count_slots = substr($item, 18, 1);
        $this->four_craft_option = substr($item, 19, 1);
        $this->position = substr($item, 20, 8);
        $this->post_position_bytes = substr($item, 28, 4);

        $this->dec_id = unpack('vid', hex2bin($this->id))['id'];
        $this->dec_position = unpack('Vpos', hex2bin($this->position))['pos'];
    }

    public function __toString(): string
    {
        return implode('', [
            $this->structuredId(),
            $this->bound,
            $this->postbound_bytes,
            $this->first_craft_slot,
            $this->first_craft_option,
            $this->two_craft_slot,
            $this->two_craft_option,
            $this->thrid_craft_slot,
            $this->thrid_craft_option,
            $this->count_slots,
            $this->four_craft_option,
            $this->position,
            $this->post_position_bytes
        ]);
    }

    public function structuredId()
    {
        return substr($this->id, 0 , 2) . $this->lvl . substr($this->id, 3 , 1);
    }

    public function getOptions(): string
    {
        return implode('', [
            $this->first_craft_slot,
            $this->first_craft_option,
            $this->two_craft_slot,
            $this->two_craft_option,
            $this->thrid_craft_slot,
            $this->thrid_craft_option,
            $this->count_slots,
            $this->four_craft_option,
        ]);
    }

    public function update($request)
    {
        foreach ($request as $key => $value) {
            $this->$key = $value;
        }
    }
}
