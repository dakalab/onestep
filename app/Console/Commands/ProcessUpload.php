<?php

namespace App\Console\Commands;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\File;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Log;

class ProcessUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process product upload';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $startTime = microtime(true);
        $statMemory = memory_get_usage();

        $fileModel = File::where('status', 0)->orderBy('id', 'asc')->first();
        if (!$fileModel) {
            // Log::channel('upload')->info('no unprocessed file');
            return;
        }
        $fileModel->status = 1;
        $fileModel->save();

        Log::channel('upload')->info('File ID: ' . $fileModel->id);

        $count = 0;
        try {
            $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileModel->fullpath());

            $sheetData = $excel->getActiveSheet()->toArray(null, true, true, true);

            $header = $sheetData[1];

            $rows = [];
            for ($i = 2; $i <= count($sheetData); $i++) {
                $rows[] = array_combine($header, $sheetData[$i]);
            }

            $g = AttributeGroup::get()->toArray();
            $groups = array_pluck($g, 'id', 'name');

            $cmap = [];

            foreach ($rows as $row) {
                $row = array_map('trim', $row);

                if (empty($row['Name']) || empty($row['SKU']) || empty($row['Price'])) {
                    Log::channel('upload')->error('empty name or sku or price');
                    continue;
                }

                $product = Product::firstOrNew(['sku' => $row['SKU']]);

                if (!empty($row['Delete'])) {
                    Log::channel('upload')->info('remove product ' . $product->id);
                    $product->remove();
                    continue;
                }

                $cmap[$row['Category']] = 1;

                $product->name = $row['Name'];
                $product->spu = $row['SPU'] ?: $row['SKU'];
                $product->price = $row['Price'];
                $product->hidden = (int) $row['Hidden'];
                $product->category_id = (int) $row['Category'];
                $product->description = $row['Description'];
                $product->seo_url = $product->seo();

                if (!empty($row['Keywords'])) {
                    $product->keywords = $row['Keywords'];
                }
                if (!empty($row['Meta_desc'])) {
                    $product->meta_desc = $row['Meta_desc'];
                }

                $product->save();

                // Update attributes
                if (!empty($row['Attributes'])) {
                    $attributes = [];
                    $arr = explode(',', $row['Attributes']);
                    foreach ($arr as $a) {
                        if (empty($a)) {
                            continue;
                        }
                        list($g, $v) = explode(':', $a);
                        if (!empty($groups[$g])) {
                            $attribute = Attribute::where('name', $v)
                                ->where('attribute_group_id', $groups[$g])
                                ->first();
                            if ($attribute) {
                                $attributes[] = $attribute->id;
                            }
                        }
                    }

                    if (!empty($attributes)) {
                        $product->updateAttributes($attributes);
                    }
                }

                // Update stocks
                $change = (int) $row['Stock'];
                if (!empty($change)) {
                    Stock::change([
                        'product_id' => $product->id,
                        'change'     => $change,
                        'unit_cost'  => (float) $row['Cost'],
                        'currency'   => array_get($row, 'Currency', config('app.currency')),
                        'remark'     => '批量导入',
                        'user_id'    => $fileModel->user_id,
                    ]);
                }

                // Update photos, if you DO NOT want to replace old photos, let the Photos column empty in the import file
                if (!empty($row['Photos'])) {
                    // Remove old photos
                    ProductPhoto::where('product_id', $product->id)->delete();

                    // Update photos
                    $photos = explode('|', $row['Photos']);
                    $dir = config('product.ftp_dir');
                    foreach ($photos as $p) {
                        $f = $dir . DIRECTORY_SEPARATOR . $p;
                        if (!is_file($f)) {
                            continue;
                        }
                        $file = new UploadedFile($f, $p);
                        $data = [];
                        $data['filename'] = $p;
                        $data['extension'] = $file->extension();
                        $data['size'] = $file->getSize();
                        $data['md5'] = md5_file($file->getPathname());

                        if (empty($data['extension']) || empty($data['size'])) {
                            Log::channel('upload')->error('invalid photo');
                            continue;
                        }

                        $pn = Photo::generatePathAndName($data['extension']);
                        $data['path'] = $file->storeAs($pn['path'], $pn['name']);
                        $photo = Photo::create($data);

                        ProductPhoto::firstOrCreate([
                            'product_id' => $product->id,
                            'photo_id'   => $photo->id,
                        ]);
                    }
                }

                $count++;
            }
        } catch (\Exception $e) {
            Log::channel('upload')->error($e->getMessage());
            $fileModel->status = 2;
            $fileModel->save();
        }

        Log::channel('upload')->info("$count products imported");

        if ($count > 0) {
            // update export file
            foreach ($cmap as $cid => $v) {
                Log::channel('upload')->info("exporting category $cid");
                Product::export($cid);
            }

            // Log::channel('upload')->info('exporting whole products');
            // Product::export();
        }

        $second = round(microtime(true) - $startTime, 2);
        $memory = round((memory_get_usage() - $statMemory) / 1024 / 1024, 2);

        Log::channel('upload')->info("run time: $second s, memory: $memory m");
    }
}
