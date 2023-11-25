<?php

use App\Enums\UserRole;
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
        // UserRole::TYPES pozwala wybrać role z tablicy zwracanej z klasy app/Enums/UserRole
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', UserRole::TYPES)->default(UserRole::OPERATOR)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
