<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE INDEX IF NOT EXISTS idx_bills_user_id ON bills(user_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_bills_bill_date ON bills(bill_date)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_bills_provider ON bills(provider)');

        DB::statement('CREATE INDEX IF NOT EXISTS idx_consumption_records_user_id ON consumption_records(user_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_consumption_records_bill_id ON consumption_records(bill_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_consumption_records_record_date ON consumption_records(record_date)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_consumption_records_provider ON consumption_records(provider)');

        DB::statement('CREATE INDEX IF NOT EXISTS idx_alerts_user_id ON alerts(user_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_alerts_bill_id ON alerts(bill_id)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_alerts_read_at ON alerts(read_at)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_alerts_type ON alerts(type)');
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table): void {
            $table->dropIndex('idx_bills_user_id');
            $table->dropIndex('idx_bills_bill_date');
            $table->dropIndex('idx_bills_provider');
        });

        Schema::table('consumption_records', function (Blueprint $table): void {
            $table->dropIndex('idx_consumption_records_user_id');
            $table->dropIndex('idx_consumption_records_bill_id');
            $table->dropIndex('idx_consumption_records_record_date');
            $table->dropIndex('idx_consumption_records_provider');
        });

        Schema::table('alerts', function (Blueprint $table): void {
            $table->dropIndex('idx_alerts_user_id');
            $table->dropIndex('idx_alerts_bill_id');
            $table->dropIndex('idx_alerts_read_at');
            $table->dropIndex('idx_alerts_type');
        });
    }
};
