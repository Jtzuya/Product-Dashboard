<?php
if(!function_exists('database_products')) {
    function database_products() {
        $directory = 'generate-products';
        if(!file_exists($directory)) {
            mkdir('generate-products');
        }

        if(!file_exists('products.txt')) {
            $myfile = fopen("generate-products/products.txt", "w");
        }
    }
}