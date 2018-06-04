# opensource-licenses-report
Generates used opensource licenses report based on multiple composer or yarn reports

# Usage

1. Download composer [https://getcomposer.org/download/]()
2. Run `composer install`
3. Get all your composer licenses into single directory `composer licenses -f json > /tmp/licenses/myproject.composer.dev.json`. Keep file name format
4. Get all your yarn licenses into single directory `yarn licenses list --json --no-progress > /tmp/myproject.prod.yarn.txt`. Keep file name format
5. Aggragate all files into single report `bin/console generate-report /tmp/licenses/ -f csv -o report.csv`. Possible output options: csv, html, text

