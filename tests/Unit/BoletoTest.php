<?php

namespace Tests\Unit;
use App\Helpers\ApiBoleto;
use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCodigoBarra()
    {
        $this->assertIsObject((new ApiBoleto())->getDadosBoleto('34191790010104351004791020150008191070069000'));
    }
}
