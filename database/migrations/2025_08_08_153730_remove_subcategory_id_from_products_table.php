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
            Schema::table('products', function (Blueprint $table) {
                // Elimina la columna subcategory_id de la tabla products
                $table->dropForeign(['subcategory_id']); // Opcional: si la columna era una llave foránea
                $table->dropColumn('subcategory_id');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('products', function (Blueprint $table) {
                // Si necesitas revertir la migración, vuelve a añadir la columna
                $table->unsignedBigInteger('subcategory_id')->nullable();
                $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
            });
        }
    };
    