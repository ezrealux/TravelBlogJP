<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeInTableName extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 刪除原本的 string 欄位
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // 重新以 boolean 型態新增欄位，預設為 false，可視情況調整
            $table->boolean('is_admin')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
        });
    }
}
