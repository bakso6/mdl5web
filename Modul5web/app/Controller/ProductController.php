<?php

namespace app\Controller;

include "app/Traits/ApiResponseFormatter.php";
include "app/Models/Product.php";


use app\Models\Product;
use app\Traits\ApiResponseFormatter;

class ProductController
{
    // PAKAI TRAIT YANG SUDAH DIBUAT
    use ApiResponseFormatter;

    public function index()
    {
        //DEFINISIKAN OBJEK MODEL PRODUCT YANG SUDAH DIBUAT
        $productModel = new Product();
        // PANGGIL FUNGSI GET ALL PRODUCT
        $response = $productModel->findAll();
        // RETURN $response DENGAN MELAKUKAN FORMATTING TERLEBIH DAHULU MENGGUNAKAN TRAIT YANG SUDAH DIPANGGIL
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($id)
    {
        $productModel = new Product();
        $response = $productModel->findById($id);
        return $this->apiResponse(200, "success", $response);
    }

    public function insert()
    {
        // tangkap input json
        $jsonInput = file_get_contents('php://input');
        $inputData = json_decode($jsonInput, true);
        // Validasi apakah input valid
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        // Lanjut jika tidak eror
        $productModel = new Product();
        $response = $productModel->create([
            "product_name" => $inputData['product_name'],
            "nama_stasiun" => $inputData["nama_stasiun"],
            "nama_kereta" => $inputData["nama_kereta"]
        ]);

        return $this->apiResponse(200, "success", $response);
    }

    public function update($id)
    {
        // Tangkap input json
        $jsonInput = file_get_contents("php://input");
        $inputData = json_decode($jsonInput, true);
        // Validasi apakah input valid 
        if (json_last_error()) {
            return $this->apiResponse(400, "error invalid input", null);
        }

        // Lanjut jika tidak error
        $productModel = new Product();
        $response = $productModel->update([
            "product_name" => $inputData['product_name'],
            "nama_stasiun" => $inputData['nama_stasiun'],
            "nama_kereta" => $inputData['nama_kereta']
        ], $id);

        return $this->apiResponse(200, "success", $response);
    }

    public function delete($id)
    {

        $productModel = new Product();
        $response = $productModel->destroy($id);

        return $this->apiResponse(200, "success", $response);
    }
}