<?php
namespace SellerLedger\Tests\specs;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use SellerLedger\Tests\SellerLedgerTestBase;

class TransactionsTest extends SellerLedgerTestBase
{
    public function testTransactions()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/transactions.json")));

      $response = $this->client->getTransactions();

      $this->assertCount(1, $this->history);

      $request = reset($this->history)['request'];
      $this->assertSame('GET', $request->getMethod());
      $this->assertSame('/transactions', $request->getUri()->getPath());

      $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../fixtures/transactions.json', json_encode([
          "transactions" => $response
      ]));
    }

    public function testTransactionsWithParams()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/transactions_with_params.json")));

      $response = $this->client->getTransactions(["from_datetime" => "May 14 2024"]);

      $this->assertCount(1, $this->history);

      $request = reset($this->history)['request'];
      $this->assertSame('GET', $request->getMethod());
      $this->assertSame('/transactions', $request->getUri()->getPath());
      $this->assertSame('from_datetime=May%2014%202024', $request->getUri()->getQuery());

      $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../fixtures/transactions_with_params.json', json_encode([
          "transactions" => $response
      ]));
    }
}
