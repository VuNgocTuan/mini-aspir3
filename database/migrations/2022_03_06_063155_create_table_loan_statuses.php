<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableLoanStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        DB::table('loan_statuses')->insert(
            [
                [
                    'name' => 'Application',
                ],
                [
                    'name' => 'Open',
                ],
                [
                    'name' => 'Closed',
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_statuses');
    }
}
