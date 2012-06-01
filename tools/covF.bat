E: 
cd E:\dev\workspaces\perso\f
rmdir /s E:\dev\workspaces\perso\f\reports
phpunit -c tests/coverage.xml --coverage-html "reports/coverage/unit" "tests/unit/php" && phpunit -c tests/coverage.xml --coverage-html "reports/coverage/integration" "tests/integration/php" 