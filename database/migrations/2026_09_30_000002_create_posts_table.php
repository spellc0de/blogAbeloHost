<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class {
    public function up(): void
    {
        Capsule::schema()->create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->string('description', 500)->nullable();
            $table->mediumText('content');
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->dateTime('published_at')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->index('views');
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('posts');
    }
};
