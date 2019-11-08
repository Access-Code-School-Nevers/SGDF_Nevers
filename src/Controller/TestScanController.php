<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestScanController extends AbstractController
{
    /**
     * @Route("app/test-scan", name="test_scan")
     */
    public function testScan()
    {
        return $this->render('testScan/test.html.twig', [
            'title' => 'Test scan',
        ]);
    }
}
