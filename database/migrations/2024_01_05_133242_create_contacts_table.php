<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_icon', 255)->nullable();
            $table->string('contact_name', 100);
            $table->string('contact_address', 255)->nullable();
            $table->string('contact_num', 20)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_url', 255)->nullable();
            $table->string('contact_hours', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
