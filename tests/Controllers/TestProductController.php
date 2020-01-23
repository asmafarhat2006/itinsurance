<?php namespace App;

use CodeIgniter\Test\FeatureTestCase;

class TestProductController extends FeatureTestCase
{
    
 public function setUp(): void
    {
        parent::setUp();

        // Do something here....
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Do something here....
    }
    public function testlistProducts()
    {	$result = $this->call('get','ProductController/listProducts');
		$result->assertDontSee('Data Source error Try Again');
		$result->assertDontSee('Exception');
		//$result->assertSee('.rounded-circle');
        //$this->assertTrue($result->isOK());
   }
}