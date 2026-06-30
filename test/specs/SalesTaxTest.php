<?php
namespace SellerLedger\Tests\specs;

use GuzzleHttp\Psr7\Response;
use SellerLedger\Tests\SellerLedgerTestBase;

class SalesTaxTest extends SellerLedgerTestBase
{
    private function params()
    {
      return [
          "ship_to_country_code" => "US",
          "ship_to_state" => "TX",
          "ship_to_zip" => "78701",
          "items_subtotal" => 100.0,
          "shipping_amount" => 10.0,
          "items" => [
              [
                  "product_name" => "Widget",
                  "quantity" => 1,
                  "total_amount" => 100.0,
                  "item_amount" => 100.0,
              ],
          ],
      ];
    }

    public function testCalculateSalesTax()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/sales_tax.json")));

      $params = $this->params();
      $response = $this->client->calculateSalesTax($params);

      $this->assertCount(1, $this->history);

      $request = reset($this->history)['request'];
      $this->assertSame('POST', $request->getMethod());
      $this->assertSame('/sales-tax/calculate', $request->getUri()->getPath());
      $this->assertJsonStringEqualsJsonString(json_encode($params), $request->getBody()->getContents());

      $this->assertTrue($response->has_nexus);
      $this->assertSame(9.08, $response->amount_to_collect);
      $this->assertSame(0.0825, $response->rate);

      $this->assertJsonStringEqualsJsonFile(__DIR__ . '/../fixtures/sales_tax.json', json_encode([
          "tax" => $response
      ]));
    }

    public function testCalculateSalesTaxNoNexus()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/sales_tax_no_nexus.json")));

      $response = $this->client->calculateSalesTax($this->params());

      $this->assertFalse($response->has_nexus);
      $this->assertSame(0.0, $response->amount_to_collect);
      $this->assertNull($response->breakdown);
    }

    public function testGetSalesTaxNexus()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/sales_tax_nexus.json")));

      $response = $this->client->getSalesTaxNexus();

      $this->assertCount(1, $this->history);

      $request = reset($this->history)['request'];
      $this->assertSame('GET', $request->getMethod());
      $this->assertSame('/sales-tax/nexus', $request->getUri()->getPath());

      $this->assertCount(2, $response);
      $this->assertSame('CA', $response[0]->state);
      $this->assertSame('Texas', $response[1]->name);
    }

    public function testReturnsNullWhenResponseBodyHasNoProperty()
    {
      $this->http->append(new Response(200, [], 'null'));

      $response = $this->client->getSalesTaxNexus();

      $this->assertNull($response);
    }

    public function testCalculateSalesTaxAcceptsRequestOptions()
    {
      $this->http->append(new Response(200, [], file_get_contents(__DIR__ . "/../fixtures/sales_tax.json")));

      $response = $this->client->calculateSalesTax($this->params(), ["timeout" => 5, "connect_timeout" => 3]);

      $this->assertCount(1, $this->history);

      $options = reset($this->history)['options'];
      $this->assertSame(5, $options['timeout']);
      $this->assertSame(3, $options['connect_timeout']);
      $this->assertTrue($response->has_nexus);
    }
}
