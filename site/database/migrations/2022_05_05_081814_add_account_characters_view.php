<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW user_characters AS 
            SELECT cct.CharacterIdx, cat.UserNum 
            FROM gamedb.dbo.cabal_character_table AS cct 
            JOIN account.dbo.cabal_auth_table AS cat ON cct.CharacterIdx / 8 = cat.UserNum;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS user_characters');
    }
};
