<?php

namespace App\Libraries\Helper;

use Illuminate\Support\Facades\DB;

class DatabaseLibrary
{
    public static function removeUpdatedAtFunction(): void
    {
        DB::statement(
        /** @lang PostgreSQL */
            'DROP FUNCTION IF EXISTS update_updated_at_column'
        );
    }

    public static function createUpdatedAtFunction(): void
    {
        DB::statement(
        /** @lang PostgreSQL */
            "CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
      NEW.updated_at = now();
      RETURN NEW;
END;
$$ language 'plpgsql'"
        );
    }

    public static function setUpdatedAtTrigger($tableName): void
    {
        $tableNameParts = explode('.', $tableName);
        if (isset($tableNameParts[1])) {
            $name = $tableNameParts[1];
        } else {
            $name = $tableName;
        }

        DB::statement(
        /** @lang PostgreSQL */
            "DROP TRIGGER IF EXISTS ${name}_before_update_updated_at ON ${tableName}"
        );
        DB::statement(
        /** @lang PostgreSQL */
            "CREATE TRIGGER
            ${name}_before_update_updated_at BEFORE UPDATE ON ${tableName}
            FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column()"
        );
    }

    public static function updateSequenceAfterInsert(string $dbName): void
    {
        DB::insert(
            "SELECT setval('${dbName}_id_seq',
              (SELECT max(id) + 1
               FROM ${dbName}
               LIMIT 1),
              TRUE);"
        );
    }
}
