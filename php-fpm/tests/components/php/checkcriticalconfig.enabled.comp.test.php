<?php
use PHPUnit\Framework\TestCase;

class TestCritConfigCheck extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/checkcriticalconfig.enabled.comp.php');
    }
}
?>
