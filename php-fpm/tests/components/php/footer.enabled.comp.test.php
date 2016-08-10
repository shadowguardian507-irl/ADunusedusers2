<?php
use PHPUnit\Framework\TestCase;

class TestFooter extends TestCase
{
    public function testFailure()
    {
       $this-> assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/footer.enabled.comp.php');
    }
}
?>
