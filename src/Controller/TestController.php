<?php

declare(strict_types=1);

namespace Workouse\NotifierPlugin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

final class TestController extends Controller
{
    /**
     * @param string|null $name
     *
     * @return Response
     */
    public function testAction(?string $name): Response
    {
        return $this->render('@WorkouseNotifierPlugin/test.html.twig', []);
    }
}
