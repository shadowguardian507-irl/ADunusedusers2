<?php
use PHPUnit\Framework\TestCase;

class TestUseraccountcodeparser extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/useraccountcodeparser.enabled.comp.php');
    }
}
?>
