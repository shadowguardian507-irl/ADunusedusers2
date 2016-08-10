<?php
use PHPUnit\Framework\TestCase;

class TestMstimestampparser extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/mstimestampparser.enabled.comp.php');
    }
}
?>
