<?php 

namespace Pierre\TrackMyCash\controllers;

use Pierre\TrackMyCash\core\Response;
use Pierre\TrackMyCash\core\Database;

class TransactionController 
{
    use Response;

    public function index()
    {
        $transactions = Database::getInstance()->all("Transactions",["id","type","amount","description","date","user_id","category_id"]);

        return count($transactions) != 0 
            ? $this->json(200,"transactions",$transactions) 
            : $this->json(404,"transactions",$transactions,"There is no transactions");
    }

    public function store($params)
    {       
        $now = date('Y-m-d H:i:s');

        // il faut trim & sanitizer
        $type = $params["type"];
        $amount = $params["amount"];
        $description = $params["description"];
        $user_id = $params["user_id"];
        $category_id = $params["category_id"];

        $data = [ 
            "type" => $type,
            "amount" => $amount,
            "description" => $description,
            "date" => $now,
            "user_id" => $user_id,
            "category_id" => $category_id
        ];

        Database::getInstance()->store("Transactions",$data);

        return $this->json(
            202,
            "Transaction",
            $data,
            "Transaction added");
    }

    public function delete($param)
    {
        Database::getInstance()->delete("Transactions",$param);
        return $this->success_202();
    }
}