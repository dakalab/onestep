<?php

namespace App\Console\Commands;

use Google\Cloud\Translate\TranslateClient;
use Illuminate\Console\Command;

class TranslateAdminLTE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate-adminlte {lang}';

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

        $path = resource_path('lang/vendor/adminlte_lang/en');

        $f = resource_path('lang/vendor/adminlte_lang/' . $lang) . '/message.php';
        echo "generating $f\n";

        $arr = require $path . '/message.php';

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
