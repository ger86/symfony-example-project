<?php

namespace App\Tests\Service\Formatter;

use App\Service\Formatter\ApplyFormatters;
use App\Service\Formatter\Formatter;
use ArrayObject;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ApplyFormattersUnitTest extends TestCase
{
    public function testInvoke()
    {
        $text = 'Lorem ipsum';

        /** @var Formatter&MockObject */
        $formatterOne = $this->getMockBuilder(Formatter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $formatterOne
            ->expects(self::exactly(1))
            ->method('format')
            ->with('Lorem ipsum')
            ->willReturn('Lorem ipsum.');

        /** @var Formatter&MockObject */
        $formatterTwo = $this->getMockBuilder(Formatter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $formatterTwo
            ->expects(self::exactly(1))
            ->method('format')
            ->with('Lorem ipsum.')
            ->willReturn('.Lorem ipsum.');

        $applyFormatter = new ApplyFormatters(new ArrayObject([$formatterOne, $formatterTwo]));
        $dev = ($applyFormatter)($text);
        $this->assertEquals('.Lorem ipsum.', $dev);
    }
}
