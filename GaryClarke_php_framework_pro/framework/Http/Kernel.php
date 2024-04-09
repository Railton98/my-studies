<?php

declare(strict_types=1);

namespace Tecks\Framework\Http;

class Kernel
{
    public function handle(Request $request): Response
    {
        $content = '<h1?>Hello World!</h1>';

        return new Response($content);
    }
}
