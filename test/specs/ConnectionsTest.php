<?php
namespace SellerLedger\Tests\specs;

use GuzzleHttp\Psr7\Response;
use SellerLedger\Tests\SellerLedgerTestBase;

class ConnectionsTest extends SellerLedgerTestBase
{
    public function testCreateConnectionSendsKindAndExternalId()
    {
      $this->http->append(new Response(201, [], json_encode([
        "connection" => ["id" => "conn-1", "name" => "WooCommerce (shop.example)", "kind" => "sales_channel", "platform" => "woocommerce"]
      ])));

      $response = $this->client->createConnection([
        "name" => "WooCommerce (shop.example)",
        "balance_sheet_account_type" => "asset",
        "kind" => "sales_channel",
        "platform" => "woocommerce",
        "external_id" => "shop.example",
      ]);

      $request = reset($this->history)['request'];
      $this->assertSame('POST', $request->getMethod());
      $this->assertSame('/connections', $request->getUri()->getPath());
      $this->assertSame('sales_channel', json_decode((string) $request->getBody())->kind);
      $this->assertSame('conn-1', $response->id);
      $this->assertSame('sales_channel', $response->kind);
    }

    public function testCreatePayout()
    {
      $this->http->append(new Response(202, [], json_encode([
        "payout" => ["payout_id" => "po_1", "import_id" => "imp-1", "transactions" => 1]
      ])));

      $response = $this->client->createPayout("conn-2", [
        "payout_id" => "po_1",
        "amount" => "52.13",
        "currency_code" => "USD",
        "paid_out_at" => "2026-11-14T00:00:00Z",
        "transactions" => [["transaction_id" => "txn_1", "type" => "charge", "amount" => "54.00"]],
      ]);

      $request = reset($this->history)['request'];
      $this->assertSame('POST', $request->getMethod());
      $this->assertSame('/connections/conn-2/payouts', $request->getUri()->getPath());
      $this->assertSame('po_1', $response->payout_id);
    }

    public function testRevokeApiKey()
    {
      $this->http->append(new Response(200, [], json_encode(["api_key" => ["revoked" => true]])));

      $response = $this->client->revokeApiKey();

      $request = reset($this->history)['request'];
      $this->assertSame('DELETE', $request->getMethod());
      $this->assertSame('/api_key', $request->getUri()->getPath());
      $this->assertTrue($response->revoked);
    }
}
