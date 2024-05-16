<?php
namespace SellerLedger;

class Client extends SellerLedger
{
  public static function withApiKey($key)
  {
    return new Client($key);
  }

  public function getCategories()
  {
    return $this->get('categories', [], 'categories');
  }

  public function getConnections($parameters = [])
  {
    return $this->get('connections', $parameters, 'connections');
  }

  public function getConnection($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Connection ID');
    return $this->get('connections/' . $id, $parameters, 'connection');
  }

  public function createConnection($parameters = [])
  {
    return $this->post('connections', $parameters, 'connection');
  }

  public function deleteConnection($id)
  {
    $this->throwIfNull($id, 'Connection ID');
    return $this->delete('connections/' . $id, 'connection');
  }

  public function getConnectionTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/' . $id,
      $parameters,
      'transaction'
    );
  }

  public function getConnectionTransactions($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions',
      $parameters,
      'transactions'
    );
  }

  public function getConnectionFinancialTransactions($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/financial',
      $parameters,
      'transactions'
    );
  }

  public function getConnectionFinancialTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/financial/' . $id,
      $parameters,
      'transaction'
    );
  }

  public function createConnectionFinancialTransaction($connecton_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->post('connections/' . $connection_id . '/transactions/financial', $parameters, 'transaction');
  }

  public function updateConnectionFinancialTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->put('connections/' . $connection_id . '/transactions/financial' . $id, $parameters, 'transaction');
  }

  public function deleteConnectionFinancialTransaction($connection_id, $id)
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->delete('connections/' . $connection_id . '/transactions/financial' . $id, 'transaction');
  }

  public function getConnectionRefundTransactions($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/refunds',
      $parameters,
      'transactions'
    );
  }

  public function getConnectionRefundTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/refunds/' . $id,
      $parameters,
      'transaction'
    );
  }

  public function createConnectionRefundTransaction($connecton_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->post('connections/' . $connection_id . '/transactions/refunds', $parameters, 'transaction');
  }

  public function updateConnectionRefundTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->put('connections/' . $connection_id . '/transactions/refunds' . $id, $parameters, 'transaction');
  }

  public function deleteConnectionRefundTransaction($connection_id, $id)
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->delete('connections/' . $connection_id . '/transactions/refunds' . $id, 'transaction');
  }

  public function getConnectionOrderTransactions($connection_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/orders',
      $parameters,
      'transactions'
    );
  }

  public function getConnectionOrderTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->get(
      'connections/' . $connection_id . '/transactions/orders/' . $id,
      $parameters,
      'transaction'
    );
  }

  public function createConnectionOrderTransaction($connecton_id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');

    return $this->post('connections/' . $connection_id . '/transactions/orders', $parameters, 'transaction');
  }

  public function updateConnectionOrderTransaction($connection_id, $id, $parameters = [])
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->put('connections/' . $connection_id . '/transactions/orders' . $id, $parameters, 'transaction');
  }

  public function deleteConnectionOrderTransaction($connection_id, $id)
  {
    $this->throwIfNull($connection_id, 'Connection ID');
    $this->throwIfNull($id, 'Transaction ID');

    return $this->delete('connections/' . $connection_id . '/transactions/orders' . $id, 'transaction');
  }

  public function getTransactions($parameters = [])
  {
    return $this->get('transactions', $parameters, 'transactions');
  }

  public function getTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->get('transactions/' . $id, $parameters, 'transaction');
  }

  public function getMileageTransactions($parameters = [])
  {
    return $this->get('transactions/mileage', $parameters, 'transactions');
  }

  public function getMileageTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->get('transactions/mileage/' . $id, $parameters, 'transaction');
  }

  public function createMileageTransaction($parameters = [])
  {
    return $this->post('transactions/mileage', $parameters, 'transaction');
  }

  public function updateMileageTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->put('transactions/mileage/' . $id, $parameters, 'transaction');
  }

  public function deleteMileageTransaction($id)
  {
    return $this->delete('transactions/mileage/' . $id, 'transaction');
  }

  public function getIncomeTransactions($parameters = [])
  {
    return $this->get('transactions/income', $parameters, 'transactions');
  }

  public function getIncomeTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->get('transactions/income/' . $id, $parameters, 'transaction');
  }

  public function createIncomeTransaction($parameters = [])
  {
    return $this->post('transactions/income', $parameters, 'transaction');
  }

  public function updateIncomeTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->put('transactions/income/' . $id, $parameters, 'transaction');
  }

  public function deleteIncomeTransaction($id)
  {
    return $this->delete('transactions/income/' . $id, 'transaction');
  }

  public function getExpenseTransactions($parameters = [])
  {
    return $this->get('transactions/expense', $parameters, 'transactions');
  }

  public function getExpenseTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->get('transactions/expense/' . $id, $parameters, 'transaction');
  }

  public function createExpenseTransaction($parameters = [])
  {
    return $this->post('transactions/expense', $parameters, 'transaction');
  }

  public function updateExpenseTransaction($id, $parameters = [])
  {
    $this->throwIfNull($id, 'Transaction ID');
    return $this->put('transactions/expense/' . $id, $parameters, 'transaction');
  }

  public function deleteExpenseTransaction($id)
  {
    return $this->delete('transactions/expense/' . $id, 'transaction');
  }

  private function get($path, $parameters, $property)
  {
    if ($parameters != []) {
      $response = $this->client->get($path, ['query' => $parameters]);
    } else {
      $response = $this->client->get($path);
    }

    return json_decode($response->getBody())->$property;
  }

  private function post($path, $parameters, $property)
  {
    $response = $this->client->post($path, ['query' => $parameters]);
    return json_decode($response->getBody())->$property;
  }

  private function put($path, $parameters, $property)
  {
    $response = $this->client->put($path, ['query' => $parameters]);
    return json_decode($response->getBody())->$property;
  }

  private function delete($path, $property)
  {
    $response = $this->client->delete($path);
    return json_decode($response->getBody())->$property;
  }

  private function throwIfNull($var, $name)
  {
    if (is_null($var)) { throw new \Exception($name . ' must not be null.'); }
  }
}
