<?php

use App\Enums\DiskType;
use App\Models\Asset;
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
        Schema::create('asset_disks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Asset::class);
            $table->unsignedInteger('size');
            $table->enum('type', collect(DiskType::cases())->pluck('value')->toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_disks');
    }
};
