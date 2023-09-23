<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class WorkerTest extends TestCase
{
    private ?Client $http;
    private string $baseUrl;

    private int $worker_id;

    private int $count = 0;

    public function setUp(): void
    {
        $this->baseUrl = 'http://localhost:8080/api';
        $this->http = new GuzzleHttp\Client();
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGetAllWorkers()
    {
        $response = $this->http->request('GET', $this->baseUrl.'/workers');

        // Check status code and content type
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeader("Content-type")[0];
        $this->assertStringContainsString("application/json", $contentType);

        $data = json_decode($response->getBody()->getContents(), true);

        // Check for a successful response
        $this->assertFalse($data['error']);

        // Check that data is not empty and is an array
        $this->assertNotEmpty($data['data']);
        $this->assertIsArray($data['data']);

        // Get first data item
        $item = $data['data'][0];
        $this->assertArrayHasKey('id', $item);
        $this->assertArrayHasKey('name', $item);
        $this->assertArrayHasKey('email', $item);
    }

    public function testPost()
    {
        $id = uniqid();
        $response = $this->http->request('POST',
            $this->baseUrl.'/workers',
            ['json' => [
                'name' => 'Test worker '.$id,
                'email' => 'unit'.$id.'@test.com'
            ]]
        );

        // Check status code and content type
        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        // Check for a successful response
        $this->assertFalse($data['error']);

        $this->assertNotEmpty($data['data']);

        $this->assertArrayHasKey('id', $data['data']);

        $this->worker_id = $data['data']['id'];
    }

    /**
     * @Depends testPost
     */
    public function testUpdateWorker()
    {
        $this->testPost();

        $response = $this->http->request('PUT',
            $this->baseUrl.'/workers/'.$this->worker_id,
            ['json' => [
                'name' => 'Test worker updated'
            ]]
        );

        // Check status code and content type
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        // Check for a successful response
        $this->assertFalse($data['error']);

        $this->assertNotEmpty($data['data']);

        $this->assertArrayHasKey('name', $data['data']);

        $this->assertEquals('Test worker updated', $data['data']['name']);

        echo $this->count;
        $this->count++;
    }

    /**
     * @Depends testPost
     */
    public function testGetWorker()
    {
        $this->testPost();

        $response = $this->http->request('GET',
            $this->baseUrl.'/workers/'.$this->worker_id
        );

        // Check status code and content type
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeader("Content-type")[0];
        $this->assertStringContainsString("application/json", $contentType);

        $data = json_decode($response->getBody()->getContents(), true);

        // Check for a successful response
        $this->assertFalse($data['error']);

        $this->assertNotEmpty($data['data']);

        $this->assertArrayHasKey('id', $data['data']);
        $this->assertArrayHasKey('name', $data['data']);
        $this->assertArrayHasKey('email', $data['data']);
        $this->assertArrayHasKey('shifts', $data['data']);
    }

    /**
     * @Depends testPost
     */
    public function testDeleteWorker()
    {
        $this->testPost();

        $response = $this->http->request('DELETE',
            $this->baseUrl.'/workers/'.$this->worker_id
        );

        // Check status code and content type
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        // Check for a successful response
        $this->assertFalse($data['error']);
    }
}