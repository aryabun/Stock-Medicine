<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInternalAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_admins', function (Blueprint $table) {
            $table->id();
//            $table->unsignedBigInteger('line_ministry_id')->nullable();
            $table->string('code',30)->unique();
            $table->string('first_name_en');
            $table->string('first_name_km');
            $table->string('last_name_en');
            $table->string('last_name_km');
            $table->text('camdigikey_access_token')->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('email')->nullable()->unique();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('profile')->nullable();
            $table->string('personal_code')->nullable();
            $table->string('camdigikey_id')->nullable();
            $table->string('nbf')->nullable();
            $table->string('exp')->nullable();
            $table->string('iat')->nullable();
            $table->string('jti')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
            $table->index(['code']);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->boolean('to_be_logged_out')->default(false);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->enum('type', \App\Models\Enumeration\SettingEnum::GUARDS)->default(\App\Models\Enumeration\SettingEnum::TYPE_INTERNAL_ADMIN);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_admins');
    }
}
