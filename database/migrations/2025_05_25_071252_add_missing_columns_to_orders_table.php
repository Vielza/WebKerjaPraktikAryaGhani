<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('sparepart_id')->nullable()->after('user_id')->constrained('spareparts')->onDelete('set null');
            $table->integer('quantity')->default(1)->after('sparepart_id');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['sparepart_id']);
            $table->dropColumn(['sparepart_id', 'quantity', 'updated_at']);
        });
    }
};