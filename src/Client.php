<?php
namespace SellerLedger;

class Client extends SellerLedger
{
  public static function withApiKey($key)
  {
    return new Client($key);
  }

  public function getAccounts()
  {
    return $this->get("accounts", [], "accounts");
  }

  public function getAccount($id, $parameters = [])
  {
    $this->throwIfNull($id, "Connection ID");
    return $this->get("accounts/" . $id, $parameters, "account");
  }

  public function getAccountEntries($id, $parameters = [])
  {
    $this->throwIfNull($id, "Connection ID");
    return $this->get("accounts/" . $id . "/entries", $parameters, "entries");
  }

  public function getAccountTransactions($id, $parameters = [])
  {
    $this->throwIfNull($id, "Connection ID");
    return $this->get("accounts/" . $id . "/transactions", $parameters, "transactions");
  }

  public function getBusiness()
  {
    return $this->get("business", [], "business");
  }

  public function getCategories()
  {
    return $this->get("categories", [], "categories");
  }

  public function getConnections($parameters = [])
  {
    return $this->get("connections", $parameters, "connections");
  }

  public function getConnection($id, $parameters = [])
  {
    $this->throwIfNull($id, "Connection ID");
    return $this->get("connections/" . $id, $parameters, "connection");
  }

  public function createConnection($parameters = [])
  {
    return $this->post("connections", $parameters, "connection");
  }

  public function deleteConnection($id)
  {
    $this->throwIfNull($id, "Connection ID");
    return $this->delete("connections/" . $id, "connection");
  }

  public function getRefunds($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");

    return $this->get(
      "connections/" . $connection_id . "/refunds",
      $parameters,
      "transactions"
    );
  }

  public function getRefund($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->get(
      "connections/" . $connection_id . "/refunds/" . $id,
      $parameters,
      "transaction"
    );
  }

  public function createRefund($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");

    return $this->post("connections/" . $connection_id . "/refunds", $parameters, "transaction");
  }

  public function updateRefund($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->put("connections/" . $connection_id . "/refunds/" . $id, $parameters, "transaction");
  }

  public function deleteRefund($connection_id, $id)
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->delete("connections/" . $connection_id . "/refunds/" . $id, "transaction");
  }

  public function getOrders($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");

    return $this->get(
      "connections/" . $connection_id . "/orders",
      $parameters,
      "transactions"
    );
  }

  public function getOrder($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->get(
      "connections/" . $connection_id . "/orders/" . $id,
      $parameters,
      "transaction"
    );
  }

  public function createOrder($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");

    return $this->post("connections/" . $connection_id . "/orders", $parameters, "transaction");
  }

  public function updateOrder($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->put("connections/" . $connection_id . "/orders/" . $id, $parameters, "transaction");
  }

  public function deleteOrder($connection_id, $id)
  {
    $this->throwIfNull($connection_id, "Connection ID");
    $this->throwIfNull($id, "Transaction ID");

    return $this->delete("connections/" . $connection_id . "/orders/" . $id, "transaction");
  }

  public function getTransactions($parameters = [])
  {
    return $this->get("transactions", $parameters, "transactions");
  }

  public function getTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, "Transaction ID");
    return $this->get("transactions/" . $id, $parameters, "transaction");
  }

  public function createTransaction($parameters = [])
  {
    return $this->post("transactions", $parameters, "transaction");
  }

  public function updateTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, "Transaction ID");

    return $this->put("transactions/" . $id, $parameters, "transaction");
  }

  public function deleteTransaction($id)
  {
    $this->throwIfNull($id, "Transaction ID");

    return $this->delete("transactions/" . $id, "transaction");
  }

  public function getMileageExpenses($parameters = [])
  {
    return $this->get("mileage_expenses", $parameters, "mileage_expenses");
  }

  public function getMileageExpense($id, $parameters = [])
  {
    $this->throwIfNull($id, "Expense ID");
    return $this->get("mileage_expense/" . $id, $parameters, "mileage_expense");
  }

  public function createMileageExpense($parameters = [])
  {
    return $this->post("mileage_expense", $parameters, "mileage_expense");
  }

  public function updateMileageExpense($id, $parameters = [])
  {
    $this->throwIfNull($id, "Transaction ID");
    return $this->put("mileage_expense/" . $id, $parameters, "mileage_expense");
  }

  public function deleteMileageTransaction($id)
  {
    return $this->delete("mileage_expense/" . $id, "mileage_expense");
  }

  public function getInventoryPurchases($parameters = [])
  {
    return $this->get("inventory/purchases", $parameters, "purchases"); 
  }

  public function getInventoryPurchase($id, $parameters = [])
  {
    $this->throwIfNull($id, "Purchase ID");
    return $this->get("inventory/purchases/" . $id, $parameters, "purchase"); 
  }

  public function createInventoryPurchase($parameters = [])
  {
    return $this->post("inventory/purchases", $parameters, "purchase");
  }

  public function updateInventoryPurchase($id, $parameters = [])
  {
    $this->throwIfNull($id, "Purchase ID");
    return $this->put("inventory/purchases/" . $id, $parameters, "purchase");
  }

  public function deleteInventoryPurchase($id)
  {
    $this->throwIfNull($id, "Purchase ID");
    return $this->delete("inventory/purchases/" . $id, "purchase");
  }

  private function get($path, $parameters, $property)
  {
    if ($parameters != []) {
      $response = $this->client->get($path, ["body" => json_encode($parameters)]);
    } else {
      $response = $this->client->get($path);
    }

    return json_decode($response->getBody())->$property;
  }

  private function post($path, $parameters, $property)
  {
    $response = $this->client->post($path, ["body" => json_encode($parameters)]);
    return json_decode($response->getBody())->$property;
  }

  private function put($path, $parameters, $property)
  {
    $response = $this->client->put($path, ["body" => json_encode($parameters)]);
    return json_decode($response->getBody())->$property;
  }

  private function delete($path, $property)
  {
    $response = $this->client->delete($path);
    return json_decode($response->getBody())->$property;
  }

  private function throwIfNull($var, $name)
  {
    if (is_null($var)) { throw new \Exception($name . " must not be null."); }
  }
}
