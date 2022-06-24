<?php

namespace App\Tests\Service\Formatter;

use App\Service\Formatter\ApplyFormatters;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ApplyFormatterIntegrationTest extends KernelTestCase
{
    public function testInvoke()
    {

        $container = $this->getContainer();

        /** @var ApplyFormatters */
        $applyFormatter = $container->get(ApplyFormatters::class);

        $dev = ($applyFormatter)('fdsffdfdfdfdfdf');
        $this->assertEquals('DOGFDSFFDFDFDFDFDFCATMuchas gracias por participar.', $dev);
    }
}
