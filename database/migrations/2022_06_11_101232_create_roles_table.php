<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::insert('insert into roles (id, name) values (?, ?)', [1, 'Admin']);
        DB::insert('insert into roles (id, name) values (?, ?)', [2, 'Orga']);
        DB::insert('insert into roles (id, name) values (?, ?)', [3, 'Checkin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
