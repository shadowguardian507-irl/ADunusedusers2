<?php
use PHPUnit\Framework\TestCase;



class TestRenderoptionalrow extends TestCase
{
    public function testComponentFilePresent()
    {
       $this->assertFileExists(dirname(__FILE__) .'/../../../scriptsrc/components/php/renderoptionalrow.enabled.comp.php');
    }
    
    public function testComponentFileisPHPFile()
    {
        $isPHPFile=true;
        
        if( strpos(file_get_contents(dirname(__FILE__) .'/../../../scriptsrc/components/php/renderoptionalrow.enabled.comp.php'),"<?php") !== false) {
        }
        else
        {
            $isPHPFile=false;
        }
        if( strpos(file_get_contents(dirname(__FILE__) .'/../../../scriptsrc/components/php/renderoptionalrow.enabled.comp.php'),"?>") !== false) {
        }
        else
        {
            $isPHPFile=false;
        }
        
        $this->assertTrue( $isPHPFile,'component File does not have php tags');
        
    }

    public function testFunctionRenderoptionalrowPresent()
    {
        include(dirname(__FILE__) .'/../../../scriptsrc/components/php/renderoptionalrow.enabled.comp.php');
        $this->assertTrue(
        function_exists ('renderoptionalrow'), 
        'component does not have function renderoptionalrow'
        );
    }
    

}
?>
