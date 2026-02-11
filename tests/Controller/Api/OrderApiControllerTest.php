<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OrderApiControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testListOrders(): void
    {
        $this->client->request('GET', '/api/orders');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');

        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertIsArray($data['data']);
    }

    public function testCreateOrder(): void
    {
        $orderData = [
            'orderNumber' => 'API-TEST-'.time(),
            'customerCode' => 'API-CUST-001',
            'customerName' => 'API Test Customer',
            'products' => [
                [
                    'productCode' => 'API-PROD-001',
                    'productName' => 'API Test Product',
                    'price' => '29.99',
                    'quantity' => 2
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/api/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($orderData)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($orderData['orderNumber'], $data['data']['orderNumber']);
    }

    public function testCreateOrderWithInvalidData(): void
    {
        $invalidOrderData = [
            'orderNumber' => '',
            'customerCode' => '',
            'customerName' => '',
            'products' => []
        ];

        $this->client->request(
            'POST',
            '/api/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($invalidOrderData)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertFalse($data['success']);
    }

    public function testShowOrder(): void
    {
        // First create an order
        $orderData = [
            'orderNumber' => 'SHOW-TEST-'.time(),
            'customerCode' => 'SHOW-CUST',
            'customerName' => 'Show Test Customer',
            'products' => [
                [
                    'productCode' => 'SHOW-PROD',
                    'productName' => 'Show Test Product',
                    'price' => '19.99',
                    'quantity' => 1
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/api/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($orderData)
        );

        $createData = json_decode($this->client->getResponse()->getContent(), true);
        $orderId = $createData['data']['id'];

        // Now test showing the order
        $this->client->request('GET', '/api/orders/' . $orderId);

        $this->assertResponseIsSuccessful();
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals($orderId, $data['data']['id']);
    }

    public function testShowNonExistentOrder(): void
    {
        $this->client->request('GET', '/api/orders/999999');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertFalse($data['success']);
    }

    public function testUpdateOrder(): void
    {
        // First create an order
        $orderData = [
            'orderNumber' => 'UPDATE-TEST-'.time(),
            'customerCode' => 'UPDATE-CUST',
            'customerName' => 'Update Test Customer',
            'products' => [
                [
                    'productCode' => 'UPDATE-PROD',
                    'productName' => 'Update Test Product',
                    'price' => '39.99',
                    'quantity' => 1
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/api/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($orderData)
        );

        $createData = json_decode($this->client->getResponse()->getContent(), true);
        $orderId = $createData['data']['id'];

        // Now update the order
        $updateData = [
            'orderNumber' => $orderData['orderNumber'],
            'customerCode' => 'UPDATED-CUST',
            'customerName' => 'Updated Customer Name',
            'products' => [
                [
                    'productCode' => 'NEW-PROD',
                    'productName' => 'New Product',
                    'price' => '49.99',
                    'quantity' => 2
                ]
            ]
        ];

        $this->client->request(
            'PUT',
            '/api/orders/' . $orderId,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($updateData)
        );

        $this->assertResponseIsSuccessful();
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($data['success']);
        $this->assertEquals('Updated Customer Name', $data['data']['customerName']);
    }

    public function testDeleteOrder(): void
    {
        // First create an order
        $orderData = [
            'orderNumber' => 'DELETE-TEST-'.time(),
            'customerCode' => 'DELETE-CUST',
            'customerName' => 'Delete Test Customer',
            'products' => [
                [
                    'productCode' => 'DELETE-PROD',
                    'productName' => 'Delete Test Product',
                    'price' => '9.99',
                    'quantity' => 1
                ]
            ]
        ];

        $this->client->request(
            'POST',
            '/api/orders',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($orderData)
        );

        $createData = json_decode($this->client->getResponse()->getContent(), true);
        $orderId = $createData['data']['id'];

        // Now delete the order
        $this->client->request('DELETE', '/api/orders/' . $orderId);

        $this->assertResponseIsSuccessful();
        
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertTrue($data['success']);

        // Verify it's deleted
        $this->client->request('GET', '/api/orders/' . $orderId);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
