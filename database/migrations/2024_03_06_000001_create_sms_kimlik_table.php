<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsKimlikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_kimlik', function (Blueprint $table) {
            $table->id();
            $table->string('ad_soyad', 50);
            $table->string('sifre', 50);
            $table->tinyInteger('loginpage')->default(1);
            $table->tinyInteger('durum')->default(1);
            $table->tinyInteger('yetki_type')->default(1);
            $table->Integer('karel_id')->default(0);
            $table->Integer('sip_id')->default(0);
            $table->Integer('birim_id')->nullable();
            $table->Integer('webuserid')->default(0);
            $table->decimal('para_limit',19,4)->default(0);
            $table->tinyInteger('webportal_izin')->default(0);
            $table->string('ceptel', 16);
            $table->string('sms_kimlik_email', 255);
            $table->string('sms_kimlik_email_username', 255);
            $table->string('sms_kimlik_email_password', 255);
            $table->string('mattermost_id', 255);
            $table->string('evtel', 16);
            $table->string('belge_token', 255);
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
        Schema::dropIfExists('sms_kimlik');
    }
}
