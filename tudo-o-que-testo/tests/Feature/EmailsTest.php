<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\post;

test('an email was sent', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-mail', $user))
        ->assertOk();

    Mail::assertSent(WelcomeMail::class);
});

test('an email was sent to user:x', function () {
    Mail::fake();

    $user = User::factory()->create();

    post(route('sending-mail', $user))
        ->assertOk();

    Mail::assertSent(
        WelcomeMail::class,
        fn (WelcomeMail $mail) => $mail->hasTo($user->email)
    );
});

test('email subject should contain the user name', function () {
    $user = User::factory()->create();

    $mail = new WelcomeMail($user);

    expect($mail)
        ->assertHasSubject('Thank you '.$user->name);
});

test('email content should contain user email with a text', function () {
    $user = User::factory()->create();

    $mail = new WelcomeMail($user);

    expect($mail)
        ->assertSeeInHtml('Confirm the e-mail address is: '.$user->email);
});
