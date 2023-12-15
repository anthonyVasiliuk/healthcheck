<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has healthcheck all ok', function () {
    $response = $this->get('/healthcheck');
    $response->assertStatus(200);

    $this->assertTrue($response->json()['redis']);
    $this->assertTrue($response->json()['database']);
    $this->assertTrue($response->json()['sentry']);
});

it('has healthcheck redis failed', function () {
    config()->set('database.redis.default.host', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertFalse($response->json()['redis']);
    $this->assertTrue($response->json()['database']);
    $this->assertTrue($response->json()['sentry']);
});

it('has healthcheck db failed', function () {
    config()->set('database.connections.mysql.database', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertTrue($response->json()['redis']);
    $this->assertFalse($response->json()['database']);
    $this->assertTrue($response->json()['sentry']);
});

it('has healthcheck sentry failed', function () {
    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertTrue($response->json()['redis']);
    $this->assertTrue($response->json()['database']);
    $this->assertFalse($response->json()['sentry']);
});

it('has healthcheck redis and db failed', function () {
    config()->set('database.redis.default.host', 'test');
    config()->set('database.connections.mysql.database', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertFalse($response->json()['redis']);
    $this->assertFalse($response->json()['database']);
    $this->assertTrue($response->json()['sentry']);
});

it('has healthcheck db and sentry failed', function () {
    config()->set('database.connections.mysql.database', 'test');
    config()->set('sentry.dsn', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertTrue($response->json()['redis']);
    $this->assertFalse($response->json()['database']);
    $this->assertFalse($response->json()['sentry']);
});

it('has healthcheck redis and sentry failed', function () {
    config()->set('database.redis.default.host', 'test');
    config()->set('sentry.dsn', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertFalse($response->json()['redis']);
    $this->assertTrue($response->json()['database']);
    $this->assertFalse($response->json()['sentry']);
});

it('has healthcheck service unavailable', function () {
    config()->set('database.redis.default.host', 'test');
    config()->set('database.connections.mysql.database', 'test');
    config()->set('sentry.dsn', 'test');

    $response = $this->get('/healthcheck');
    $response->assertStatus(503);

    $this->assertFalse($response->json()['redis']);
    $this->assertFalse($response->json()['database']);
    $this->assertFalse($response->json()['sentry']);
});

it('has healthcheck internal error', function () {
    config()->set('database.redis.default.host', false);
    config()->set('database.connections.mysql.database', false);
    config()->set('sentry.dsn', 'http://localhost');

    $response = $this->get('/healthcheck');
    $response->assertStatus(500);
});
