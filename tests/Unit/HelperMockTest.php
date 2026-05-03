<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Unit;

use SamuelMwangiW\Africastalking\Africastalking as BaseClass;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Tests\TestCase;

class HelperMockTest extends TestCase
{
    public function testAfricastalkingGlobalFunction(): void
    {
        $baseClass = Africastalking::getFacadeRoot();
        $GlobalFunctionMock = $this->createMock(GlobalFunctionsMockPlaceholder::class);
        $GlobalFunctionMock->expects($this->once())
            ->method('africastalking')
            ->willReturn($baseClass);
        GlobalFunctionsMocker::$mock = $GlobalFunctionMock;

        $this->assertSame($baseClass, africastalking());
    }
}

class GlobalFunctionsMockPlaceholder
{
    public function africastalking(): BaseClass
    {
        return new BaseClass();
    }
}

class GlobalFunctionsMocker
{
    public static GlobalFunctionsMockPlaceholder $mock;

    public static function africastalking(): BaseClass
    {
        return call_user_func([self::$mock, 'africastalking']);
    }
}

function africastalking(): BaseClass
{
    return call_user_func([GlobalFunctionsMocker::class, 'africastalking']);
}
