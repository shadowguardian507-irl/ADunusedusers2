<?php
use PHPUnit\Framework\TestCase;

class TestNlousr extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../scriptsrc/nlousr.php');
    }
}
?>
