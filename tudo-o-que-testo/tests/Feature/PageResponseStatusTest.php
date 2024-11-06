<?php

test('testing code 200')
    ->get('/')
    ->assertStatus(200)
    ->assertOk();

test('testing code 404')
    ->get('/not-found')
    ->assertStatus(404)
    ->assertNotFound();

test('testing code 403')
    ->get('/forbidden')
    ->assertStatus(403)
    ->assertForbidden();
