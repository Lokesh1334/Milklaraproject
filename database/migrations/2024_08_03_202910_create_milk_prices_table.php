<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkPricesTable extends Migration
{
    public function up()
    {
        Schema::create('milk_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 2); // Adjust precision and scale if necessary
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_prices');
    }
}
