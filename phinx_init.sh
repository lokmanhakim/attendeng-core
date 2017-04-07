git pull
vendor/robmorgan/phinx/bin/phinx rollback -t 0
vendor/robmorgan/phinx/bin/phinx migrate
vendor/robmorgan/phinx/bin/phinx seed:run -s UserSeeder