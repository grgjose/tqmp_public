<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantKey;
use App\Models\ProductVariantMapping;
use App\Models\User;
use App\Models\Usertype;
use App\Models\Inventory;
use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Imports\DatabaseImport;
use App\Models\ProductVariantValue;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
 
        // Build full path to the file
        $path = storage_path('app/public/imports/DatabaseSeeder.xlsx');
        
        // Declare Importer
        $importer = new DatabaseImport();
        Excel::import($importer, $path);
        
        // Get Data from Importer
        $data = $importer->getData();

        // Segregate by Sheets
        $usertypes = $data['Usertypes'];
        $users = $data['Users'];
        $categories = $data['Categories'];
        $products = $data['Products'];
        //$variants = $data['Variants'];
        $inventories = $data['Inventory'];
        $settings = $data['Settings'];

        $usertypes_arr = array(); $i = 1;

        //Import Usertypes
        foreach(array_slice($usertypes, 1) as $row){
            if($row[1] != null || $row[1] != ""){
                Usertype::factory()->create([
                    'title' => $row[1],
                    'access' => $row[2],
                ]);
    
                $usertypes_arr[$row[1]] = $i; $i++;
            }
        }

        //Import Users
        foreach(array_slice($users, 1) as $row){
            if($row[1] != "" && $row[1] != null){
                User::factory()->create([
                    'usertype' => $usertypes_arr[$row[1]],
                    'username' => $row[2],
                    'fname' => $row[3],
                    'mname' => $row[4],
                    'lname' => $row[5],
                    'ext' => $row[6],
                    'address' => $row[7],
                    'birthdate' => is_numeric($row[8]) ? Date::excelToDateTimeObject($row[8])->format('Y-m-d') : null,
                    'email' => $row[9],
                    'contact_num' => $row[10],
                    'user_pic' => $row[11],
                    'upload_file' => null,
                    'password' => Hash::make($row[13]),
                    'status' => $row[14],
                ]);
            }
        }

        $i = 0; $ctr = 1; $idx = 1;
        $categories_arr = array();
        $sub_categories_arr = array();
        $products_arr = array();

        //Import Categories
        foreach(array_slice($categories, 1) as $row){
            if($row[3] != ""){
                
                if($row[1] != ""){
                    $i++;
                    
                    ProductCategory::factory()->create([
                        'category' => $row[1],
                        'description' => $row[2]
                    ]); 

                    $categories_arr[$row[1]] = $i;
                }

                if ($row[3] != "" && $row[3] != "-") {
                    ProductSubCategory::factory()->create([
                        'category_id' => $i,
                        'category' => $row[3],
                        'description' => $row[4]
                    ]);

                    $sub_categories_arr[$row[3]] = $ctr; $ctr++;
                }

            }
        }

        $current_category = "";
        $current_sub_category = "";

        // Import Products
        foreach(array_slice($products, 1) as $row){
            if($row[3] != ""){

                if($row[1] != ""){ $current_category = $row[1]; }
                if($row[2] != ""){ $current_sub_category = $row[2]; }

                Product::factory()->create([
                    'name' => $row[3],
                    'display_name' => $row[4],
                    'description' => $row[5],
                    'category_id' => $categories_arr[$current_category],
                    'sub_category_id' => $current_sub_category != "-" ? $sub_categories_arr[$current_sub_category] : null,
                    'brand' => $row[6],
                    'color' => $row[7],
                    'function' => $row[8],
                    'size' => $row[9],
                    'thickness' => $row[10],
                    'status' => $row[11],
                    'price' => $row[12],
                    'discounted_price' => $row[13],
                    'special_discounted_price' => $row[14],
                ]); 

                $products_arr[$row[3]] = $idx;

                ProductImage::factory()->create([
                    'product_id' => $idx,
                    'filename' => $row[15],
                    'isDeleted' => false,
                ]);

                $idx++;
            }
        }

        ProductVariant::factory()->create([
            'product_id' => 10,
            'sku' => 'G-123456789',
            'price' => 350,
            'stock' => 150,
        ]);

        ProductVariantKey::factory()->create([
            'key' => 'Thickness'
        ]);

        ProductVariantValue::factory()->create([
            'product_variant_keys_id' => 1,
            'value' => '2MM'
        ]);

        ProductVariantValue::factory()->create([
            'product_variant_keys_id' => 1,
            'value' => '3MM'
        ]);

        ProductVariantValue::factory()->create([
            'product_variant_keys_id' => 1,
            'value' => '4MM'
        ]);

        ProductVariantMapping::factory()->create([
            'product_variant_id' => 1,
            'product_variant_key_id' => 1,
            'product_variant_value_id' => 2,
        ]);


        // Import Variants
        // foreach(array_slice($variants, 1) as $row){
        //     if($row[1] != ""){

        //         $tmp_arr1 = explode(',', $row[3]);
        //         $out_arr1 = array();
        //         foreach($tmp_arr1 as $tmp){
        //             $tmp = trim($tmp);
        //             array_push($out_arr1, $tmp);
        //         }

        //         $tmp_arr2 = explode(',', $row[4]);
        //         $out_arr2 = array();
        //         foreach($tmp_arr2 as $tmp){
        //             $tmp = trim($tmp);
        //             array_push($out_arr2, $tmp);
        //         }

        //         ProductVariant::factory()->create([
        //             'product_id' => $products_arr[$row[1]],
        //             'key' => $row[2],
        //             'value' => json_encode($out_arr1),
        //             'price' => json_encode($out_arr2),
        //         ]); 

        //     }
        // }

        //Import Inventories
        foreach(array_slice($inventories, 1) as $row){
            if($row[1] != ""){

                Inventory::factory()->create([
                    'product_id' => $products_arr[$row[1]],
                    'stock' => $row[2],
                    'status' => $row[3],
                ]);

            }
        }

        //Import Settings
        foreach(array_slice($settings, 1) as $row){
            if($row[1] != ""){

                Setting::factory()->create([
                    'key' => $row[1],
                    'type' => $row[2],
                    'description' => $row[3],
                    'value' => $row[4],
                ]);

            }
        }

    }
}
