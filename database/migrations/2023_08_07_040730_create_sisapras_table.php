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
        Schema::create('borrows', function (Blueprint $table) {
            $table->integer('borrow_id', true);
            $table->integer('location_id')->nullable()->index('location_id');
            $table->integer('item_id')->nullable()->index('item_id');
            $table->integer('user_id')->nullable()->index('user_id');
            $table->timestamp('lend_date')->useCurrent();
            $table->date('return_date');
            $table->integer('lend_quantity');
            $table->text('lend_detail');
            $table->string('lend_photo');
            $table->enum('lend_status', ['requested', 'approved', 'declined', 'canceled', 'borrowed', 'returned', 'overdue'])->default('requested');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->integer('item_id', true);
            $table->integer('location_id')->nullable()->index('location_id');
            $table->string('item_name');
            $table->integer('item_quantity')->nullable()->default(0);
            $table->string('item_desc')->nullable();
            $table->softDeletes();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->integer('location_id', true);
            $table->string('location_name', 100)->unique('location_name');
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->integer('location_id')->nullable()->index('location_id');
            $table->string('username')->nullable();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique('email');
            $table->string('reg_number');
            $table->string('hp_number', 20);
            $table->string('department');
            $table->enum('role', ['user', 'admin', 'superadmin'])->default('user');
            $table->softDeletes();
        });

        Schema::table('borrows', function (Blueprint $table) {
            $table->foreign(['location_id'], 'borrows_ibfk_1')->references(['location_id'])->on('locations')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['item_id'], 'borrows_ibfk_2')->references(['item_id'])->on('items')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'borrows_ibfk_3')->references(['user_id'])->on('users')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign(['location_id'], 'items_ibfk_1')->references(['location_id'])->on('locations')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['location_id'], 'users_ibfk_1')->references(['location_id'])->on('locations')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ibfk_1');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_ibfk_1');
        });

        Schema::table('borrows', function (Blueprint $table) {
            $table->dropForeign('borrows_ibfk_1');
            $table->dropForeign('borrows_ibfk_2');
            $table->dropForeign('borrows_ibfk_3');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('locations');

        Schema::dropIfExists('items');

        Schema::dropIfExists('borrows');
    }
};
