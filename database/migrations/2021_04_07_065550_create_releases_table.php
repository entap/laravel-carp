<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('package_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('url')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['package_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('releases');
    }
}
