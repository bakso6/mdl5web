<?php

namespace app\Models;

include "app/config/DatabaseConfig.php";

use app\Config\DatabaseConfig;
use mysqli;

class Product extends DatabaseConfig
{

    public $conn;

    public function __construct()
    {
        //CONNECT KE DATABASE MYSQL
        $this ->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: ". $this->conn->connect_error);
        }
    }

    // PROSES MENAMPILKAN SEMUA DATA
    public function findAll()
    {
        $sql = "SELECT * FROM stasiun JOIN products ON stasiun.id_stasiun = products.id";
        $result = $this->conn->query($sql);
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        return $data;
    }

    // PROSES MENAMPILKAN DATA DENGAN ID
    public function findById($id)
    {
        $sql = "SELECT * FROM stasiun JOIN products ON stasiun.id_stasiun = products.id WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->conn->close();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    // PROSES INSERT DATA
    public function create($data)
    {
        $productName = $data['product_name'];
        $namaStasiun = $data['nama_stasiun'];
        $namaKereta = $data['nama_kereta'];

        $queryProducts = "INSERT INTO products (product_name) VALUES (?)";
        $stmtProducts = $this->conn->prepare($queryProducts);
        $stmtProducts->bind_param("s", $productName);
        $stmtProducts->execute();
        $stmtProducts->close();

        $idBaruProducts = $this->conn->insert_id;
        $queryStasiun = "INSERT INTO stasiun (id_stasiun, nama_stasiun, nama_kereta) VALUES (?, ?, ?)";
        $stmtStasiun = $this->conn->prepare($queryStasiun);
        $stmtStasiun->bind_param("iss", $idBaruProducts, $namaStasiun, $namaKereta);
        $stmtStasiun->execute();
        $stmtStasiun->close();


        $this->conn->close();
    }
    // PROSES UPDATE DATA DENGAN ID
   public function update($data, $id)
    {
        $productName = $data['product_name'];
        $namaStasiun = $data['nama_stasiun'];
        $namaKereta = $data['nama_kereta'];

        // Update data di tabel 'products'
        $queryProducts = "UPDATE products SET product_name = ? WHERE id = ?";
        $stmtProducts = $this->conn->prepare($queryProducts);
        $stmtProducts->bind_param("si", $productName, $id);
        $stmtProducts->execute();

        // Update data di tabel 'buku'
        $queryStasiun = "UPDATE stasiun SET nama_stasiun = ?, nama_kereta = ? WHERE id_stasiun = ?";
        $stmtStasiun = $this->conn->prepare($queryStasiun);
        $stmtStasiun->bind_param("ssi", $namaStasiun, $namaKereta, $id);
        $stmtStasiun->execute();

        $this->conn->close();
    }

    // PROSES DELETE DATA DENGAN ID
    public function destroy($id)
    {
        // DELETE statement for products table
        $queryProducts = "DELETE FROM products WHERE id = ?";
        $stmtProducts = $this->conn->prepare($queryProducts);
        $stmtProducts->bind_param("i", $id);
        $stmtProducts->execute();

        // DELETE statement for buku table
        $queryStasiun = "DELETE FROM stasiun WHERE id_stasiun = ?";
        $stmtStasiun = $this->conn->prepare($queryStasiun);
        $stmtStasiun->bind_param("i", $id);
        $stmtStasiun->execute();

        $this->conn->close();
    }

}