<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(EavEntityInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(EavEntityInterface::ATTRIBUTE_ENTITY)->nullable(false)->index();
            $table->unsignedBigInteger(EavEntityInterface::ATTRIBUTE_ENTITYID)->nullable(false);
            $table->string(EavEntityInterface::ATTRIBUTE_NAME)->nullable(false);
            $table->text(EavEntityInterface::ATTRIBUTE_VALUE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(EavEntityInterface::TABLE_NAME);
    }
};
