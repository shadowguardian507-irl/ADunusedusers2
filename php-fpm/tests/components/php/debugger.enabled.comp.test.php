<?php
use PHPUnit\Framework\TestCase;

class TestDebugger extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/debugger.enabled.comp.php');
    }
}
?>
