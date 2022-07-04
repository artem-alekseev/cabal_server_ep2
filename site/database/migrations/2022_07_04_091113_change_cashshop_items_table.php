<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE CabalCash.dbo.ShopItems ALTER COLUMN [Image] varchar(200) COLLATE Chinese_PRC_CI_AS NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE CabalCash.dbo.ShopItems ALTER COLUMN [Image] varchar(200) COLLATE Chinese_PRC_CI_AS;");
    }
};
