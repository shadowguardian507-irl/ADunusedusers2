<?php
use PHPUnit\Framework\TestCase;

class TestDCconncetions extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/dcconnections.enabled.comp.php');
    }
}
?>