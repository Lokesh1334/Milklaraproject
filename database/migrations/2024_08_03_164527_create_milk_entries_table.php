<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('milk_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price_per_liter', 8, 2);
            $table->timestamp('date');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_entries');
    }
}

