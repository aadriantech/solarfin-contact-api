<?php

namespace Tests\Unit;

use App\Helpers\ArrayHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArrayHelperRemoveCommasTest extends TestCase
{
    public function testAcceptsArrayReturnsArray()
    {
        $result = ArrayHelper::removeCommas(['this,is,a,test']);

        $this->assertIsArray($result);
    }

    public function testAcceptsArrayWithCommaValuesReturnArrayValueWithoutComma()
    {
        $result = ArrayHelper::removeCommas(['this,is,a,test']);

        $this->assertSame('thisisatest', $result[0]);
    }

    public function testAcceptsArrayWithStringValuesReturnsStringValues()
    {
        $result = ArrayHelper::removeCommas(['this,is,a,test', 'another,array']);

        $this->assertIsString($result[0]);
        $this->assertIsString($result[1]);
    }
}
