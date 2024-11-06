<?php

test('the application returns a successful response')
    ->get('/')
    ->assertStatus(200);
