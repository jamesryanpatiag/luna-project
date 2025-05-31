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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('contractor_id_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_active')->default(true);
            $table->string('email')->unique();
            $table->text('image')->nullable();

            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');

            $table->bigInteger('contractor_type_id')->unsigned()->nullable();
            $table->foreign('contractor_type_id')->references('id')->on('contractor_types');
            $table->string('contractor_position');
            $table->date('date_hired');
            $table->date('regularization_date');
            $table->boolean('hmo_active')->default(false);
            $table->string('slack_username')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('birth_date')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('current_home_address')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('personal_email')->nullable();
            $table->enum('marital_status', ['MARRIED', 'SINGLE', 'WIDOWED', 'SEPARATED'])->nullable();
            $table->string('tin_number')->nullable();
            $table->string('emergency_contact_person')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->text('emergency_contact_person_address')->nullable();
            $table->string('relationship_to_emergency_contact')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
