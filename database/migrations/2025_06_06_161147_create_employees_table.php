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
        Schema::create('employees', function (Blueprint $table) {
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
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
