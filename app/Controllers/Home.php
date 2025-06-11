<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('v_home');
    // }

    protected $product;

    function __construct()
    {
        helper('number');
        helper('form');
        // Memastikan bahwa model ProductModel sudah di-load
        $this->product = new ProductModel();
    }

    public function index()
    {
        $product = $this->product->findAll();
        $data['product'] = $product;

        return view('v_home', $data);
    }
    
}