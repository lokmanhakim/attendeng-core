@echo "======================**Starting DB Roll back**======================"
call vendor/robmorgan/phinx/bin/phinx rollback -t 0
@echo "======================**Starting DB Migration**======================"
call vendor/robmorgan/phinx/bin/phinx migrate
@echo "======================**Starting DB Seeding**======================"
call vendor/robmorgan/phinx/bin/phinx seed:run -s UserSeeder
