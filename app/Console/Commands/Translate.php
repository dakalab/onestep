<?php

namespace App\Console\Commands;

use Google\Cloud\Translate\TranslateClient;
use Illuminate\Console\Command;

class Translate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translations automatically by google api';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lang = $this->argument('lang');

        echo "lang: $lang\n";

        $path = resource_path('lang/en');

        $files    = array_diff(scandir($path), ['.', '..']);
        $excludes = [
            'auth.php',
            'pagination.php',
            'passwords.php',
            'validation.php',
        ];

        foreach ($files as $file) {
            if (in_array($file, $excludes)) {
                continue;
            }

            $f = resource_path('lang/' . $lang) . '/' . $file;
            echo "generating $f\n";

            $arr = require $path . '/' . $file;

            $translate = new TranslateClient([
                'key'    => config('google.api_key'),
                'target' => $lang,
            ]);

            $trans = [];
            foreach ($arr as $k => $v) {
                $result    = $translate->translate($v);
                $trans[$k] = $result['text'];
            }

            $text = "<?php\n\nreturn " . var_export($trans, true) . ";\n";
            file_put_contents($f, $text);
        }
    }
}
