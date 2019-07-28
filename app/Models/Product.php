<?php

namespace App\Models;

use DB;
use Helper;
use Illuminate\Database\Eloquent\Model;
use Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Product extends Model
{
    protected $guarded = [];

    public function photos()
    {
        return $this->hasManyThrough(
            Photo::class,        // the final model
            ProductPhoto::class, // the intermediate model
            'product_id',        // foreign key on ProductPhoto table
            'id',                // foreign key on Photo table
            'id',                // local key on Product table
            'photo_id'           // local key on ProductPhoto table
        );
    }

    public function mainPhoto()
    {
        $photos = $this->photos()->get();
        if (count($photos)) {
            return $photos[0]->url();
        }
        return config('product.empty_photo');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function attributes()
    {
        return $this->hasManyThrough(
            Attribute::class,        // the final model
            ProductAttribute::class, // the intermediate model
            'product_id',            // foreign key on ProductAttribute table
            'id',                    // foreign key on Attribute table
            'id',                    // local key on Product table
            'attribute_id'           // local key on ProductAttribute table
        );
    }

    public function reviews()
    {
        return ProductReview::whereIn('product_id', [0, $this->id])
            ->where('hidden', 0)
            ->orderBy('comment_time', 'desc')
            ->get();
    }

    public function getAttributeGroup()
    {
        $group = [];
        foreach ($this->attributes()->get() as $attribute) {
            $group[$attribute->attributeGroup->name][] = $attribute->name;
        }
        return $group;
    }

    public function money()
    {
        return Helper::money($this->price, session('currency'));
    }

    /**
     * Update Attributes
     *
     * @param  array  $attributes The attribute IDs array
     * @return void
     */
    public function updateAttributes($attributes = [])
    {
        $old = ProductAttribute::where('product_id', $this->id)->get();
        if ($old) {
            $old = $old->toArray();
        } else {
            $old = [];
        }

        $o = array_pluck($old, 'attribute_id');
        $new = array_diff($attributes, $o);
        foreach ($new as $a) {
            ProductAttribute::create([
                'product_id'   => $this->id,
                'attribute_id' => $a,
            ]);
        }
        $gone = array_diff($o, $attributes);
        foreach ($gone as $a) {
            ProductAttribute::where('product_id', $this->id)
                ->where('attribute_id', $a)
                ->delete();
        }
    }

    public function seo()
    {
        $name = str_replace('/', ' ', $this->name);
        $seo = strtolower(preg_replace([
            '/-|\.|\\|\/|\+|#|\"|\'|;|\?|:|@|&|=|\$|,|\*|\(|\)|\[|\]|\{|\}/',
            '/\s+/'],
            [' ', '-'],
            $name));
        $p = self::where('id', '<>', $this->id)->where('seo_url', $seo)->first();
        if ($p) {
            $seo .= '-' . $this->sku;
        }
        return $seo;
    }

    public function url()
    {
        if (!$this->seo_url) {
            return url('/product/' . $this->id);
        }
        return url('/p/' . $this->category->seo() . '/' . $this->seo_url . '.html');
    }

    public function remove()
    {
        DB::transaction(function () {
            ProductAttribute::where('product_id', $this->id)->delete();
            ProductPhoto::where('product_id', $this->id)->delete();
            ProductReview::where('product_id', $this->id)->delete();
            Stock::where('product_id', $this->id)->delete();
            Wishlist::where('product_id', $this->id)->delete();
            Cart::where('product_id', $this->id)->delete();
            OrderProduct::where('product_id', $this->id)->delete();

            $this->delete();
        }, 5);
    }

    public function ratings()
    {
        return ProductReview::select(DB::raw('count(*) as num, round(avg(rating)) as rating'))
            ->whereIn('product_id', [0, $this->id])
            ->where('hidden', 0)
            ->first();
    }

    public static function export($categoryID = 0)
    {
        $query = self::where('hidden', 0);
        if ($categoryID > 0) {
            $query->where('category_id', $categoryID);
            Log::channel('export')->info('Category ID: ' . $categoryID);
        }

        $total = $query->count();
        Log::channel('export')->info('Total products: ' . $total);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'title');
        $sheet->setCellValue('C1', 'price');
        $sheet->setCellValue('D1', 'sku');
        $sheet->setCellValue('E1', 'img');
        $sheet->setCellValue('F1', 'description');
        $sheet->setCellValue('G1', 'url');

        $offset = 0;
        $limit = 1000;

        $line = 2;
        while ($offset < $total) {
            $data = $query->limit($limit)->offset($offset)->get();

            foreach ($data as $p) {
                $sheet->setCellValue('A' . $line, $p->id);
                $sheet->setCellValue('B' . $line, $p->name);
                $sheet->setCellValue('C' . $line, $p->money());
                $sheet->setCellValue('D' . $line, $p->sku);
                $sheet->setCellValue('E' . $line, url($p->mainPhoto()));
                $sheet->setCellValue('F' . $line, $p->meta_desc);
                $sheet->setCellValue('G' . $line, $p->url());

                $line++;
            }

            $offset += $limit;
        }

        $file = 'products.xlsx';
        if ($categoryID > 0) {
            $file = $categoryID . '_products.xlsx';
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path('downloads/' . $file));
    }
}
