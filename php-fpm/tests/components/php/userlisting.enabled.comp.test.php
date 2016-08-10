<?php
use PHPUnit\Framework\TestCase;

class TestUserlisting extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/userlisting.enabled.comp.php');
    }
}
?>
