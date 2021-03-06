<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

use Jose\Algorithm\Signature\HS256;
use Jose\Algorithm\Signature\HS384;
use Jose\Algorithm\Signature\HS512;
use Jose\Object\JWK;

/**
 * Class HMACSignatureTest.
 *
 * @group HMAC
 * @group Unit
 */
class HMACSignatureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong key type.
     */
    public function testInvalidKey()
    {
        $key = new JWK([
            'kty' => 'EC',
        ]);

        $hmac = new HS256();
        $data = 'Live long and Prosper.';

        $hmac->sign($key, $data);
    }

    public function testSignatureHasBadBadLength()
    {
        $key = new JWK([
            'kty' => 'oct',
            'k' => 'foo',
        ]);
        $hmac = new HS256();
        $data = 'Live long and Prosper.';

        $this->assertFalse($hmac->verify($key, $data, hex2bin('326eb338c465d3587f3349df0b96ba81')));
    }

    public function testHS256SignAndVerify()
    {
        $key = new JWK([
            'kty' => 'oct',
            'k' => 'foo',
        ]);
        $hmac = new HS256();
        $data = 'Live long and Prosper.';

        $signature = $hmac->sign($key, $data);

        $this->assertEquals(hex2bin('89f750759cb8ad9315d7ec6bd8d5dc5899e0a97bc12f9e355f383776f53f025c'), $signature);
        $this->assertTrue($hmac->verify($key, $data, $signature));
    }

    public function testHS384SignAndVerify()
    {
        $key = new JWK([
            'kty' => 'oct',
            'k' => 'foo',
        ]);
        $hmac = new HS384();
        $data = 'Live long and Prosper.';

        $signature = $hmac->sign($key, $data);

        $this->assertEquals(hex2bin('8985f2c6efef1c1b9baf7d7b0b17ce6db65184044bdeaa01296fe6d61900224fc783f4bb7b7aadfdfb4d0663b1284e66'), $signature);
        $this->assertTrue($hmac->verify($key, $data, $signature));
    }

    public function testHS512SignAndVerify()
    {
        $key = new JWK([
            'kty' => 'oct',
            'k' => 'foo',
        ]);
        $hmac = new HS512();
        $data = 'Live long and Prosper.';

        $signature = $hmac->sign($key, $data);

        $this->assertEquals(hex2bin('6f91ca09dc2e655d089f1018fb447f16c68d65f32f54ea84542edb1db5dfbbda141cbb41741b7383a7dff6af56be564fd74a8857eab6a680094bbcb41b2f29e1'), $signature);
        $this->assertTrue($hmac->verify($key, $data, $signature));
    }
}
