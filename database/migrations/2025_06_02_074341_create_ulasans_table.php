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
            Schema::create('ulasans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pengguna yang memberi ulasan
                $table->foreignId('lapangan_id')->constrained()->onDelete('cascade'); // Lapangan yang diulas
                $table->foreignId('reservasi_id')->nullable()->constrained()->onDelete('set null'); // (Opsional) Reservasi terkait
                $table->unsignedTinyInteger('rating'); // Rating bintang (misal 1-5)
                $table->text('komentar')->nullable(); // Isi komentar ulasan
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status ulasan
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('ulasans');
        }
    };
    