<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Category;

class DownloadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Скачать данные с удаленного сервера, внести в локальную БД.';

    protected $dataUrl = 'https://markethot.ru/export/bestsp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Скачиваем данные в формате JSON с удаленного сервера
        $client = new Client();

        $res = $client->request('GET', $this->dataUrl);

        $data = json_decode($res->getBody()->getContents(), true)['products'];

        // Вытаскиваем из JSON все продукты, вариации, категории
        $products = [];
        $offers = [];
        $categories = [];
        $categoryProducts = [];

        foreach ($data as $product) {
            // Вытаскиваем категории
            foreach ($product['categories'] as $category) {
                $category = collect($category)->only([
                    'id',
                    'title',
                    'alias',
                    'parent',
                ]);

                // Если задать ID категории в кач-ве ключа, то дупликатов в
                // массиве автоматически не будет
                $categories[$category['id']] = $category;

                // Запоминаем принадлежность данного товара к данной категории
                array_push($categoryProducts, collect([
                    'category_id' => $category['id'],
                    'product_id' => $product['id'],
                ]));
            }

            // Вытаскиваем вариации (здесь дупликаты не предвидятся)
            foreach ($product['offers'] as $offer) {
                $offer['product_id'] = $product['id'];

                $offer = collect($offer)->only([
                    'id',
                    'product_id',
                    'price',
                    'amount',
                    'sales',
                    'article',
                ]);

                array_push($offers, $offer);
            }

            // Вытаскиваем сам товар (здесь дупликаты не предвидятся)
            $product = collect($product)->only([
                'id',
                'title',
                'image',
                'description',
                'first_invoice',
                'url',
                'price',
                'amount',
            ]);

            array_push($products, $product);
        }

        // Записываем данные в БД
        $this->insertData('products', $products);
        $this->insertData('offers', $offers);
        $this->insertData('categories', $categories);
        $this->insertData('category_product', $categoryProducts);

        // Конвертируем '0' FK для категорий в NULL
        Category::where('parent', 0)->update([
            'parent' => null
        ]);
    }

    /**
     * Подгатавливает данные для записи в БД через raw query
     * Нужен INSERT IGNORE, чтобы MySQL проигнорировал запись дупликатов
     * В ORM Eloquent поддержки INSERT IGNORE из коробки нет
     *
     * @param array $items
     * @return string
     */
    protected function prepareSqlData($items)
    {
        $sql = '';

        foreach ($items as $item) {
            $sql .= '(';

            foreach ($item as $key => $value) {
                // Эскейпим ковычки
                $value = addslashes($value);
                $sql .= "'{$value}',";
            }

            $sql = mb_substr($sql, 0, -1);
            $sql .= '),';
        }

        $sql = mb_substr($sql, 0, -1);

        return $sql;
    }

    /**
     * Записывает указанные данные в указанную таблицу
     *
     * @param string $table
     * @param array $data
     * @return void
     */
    public function insertData($table, $data)
    {
        if (count($data) > 0) {
            // Вытаскиваем список полей сущности
            $firstItem = reset($data);
            $fields = implode(',', $firstItem->keys()->toArray());

            // Подгатавливаем данные для записи в БД
            $data = $this->prepareSqlData($data);

            // Записываем данные
            DB::insert("
                INSERT IGNORE
                INTO {$table} ({$fields})
                VALUES {$data}
            ");
        }
    }
}
