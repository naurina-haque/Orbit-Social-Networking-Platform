<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');  // যাকে notify করতে হবে
        $table->unsignedBigInteger('from_user_id');  // কে action করেছে
        $table->string('type');  // 'like', 'comment', 'friend_request' etc
        $table->unsignedBigInteger('post_id')->nullable();  // যদি post সম্পর্কিত হয়
        $table->string('message');  // "John liked your post"
        $table->boolean('read')->default(false);  // পড়া হয়েছে কিনা
        $table->timestamps();
        
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
