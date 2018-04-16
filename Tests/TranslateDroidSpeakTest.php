<?php
require_once "../vendor/autoload.php";

use App\Lib\TranslateDroidSpeak;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7;
use GuzzleHttp\Handler;

class TranslateDroidSpeakTest extends TestCase
{
    private $prisoner_response;
    private $prisoner_json_object;

    protected function setUp()
    {
        //mock data
        $stream = Psr7\stream_for(
            '{"cell":"01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111",
                   "block": "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100"}'
        );

        // Create a mock and queue  responses.

        $mock = new GuzzleHttp\Handler\MockHandler([
            new Psr7\Response(200, ['Content-Type' => 'application/json'], $stream)
            ]);

        $handler = new GuzzleHttp\HandlerStack($mock);
        $client = new GuzzleHttp\Client(['handler' => $handler]);

        //return first response
         $response = ($client->request('GET', '/'));
         $this->response = $response;
         $this->prisoner_response  = $response->getBody()->getContents();
         $this->prisoner_json_object = json_decode($this->prisoner_response);
    }
    public function testResponseIsJson()
    {
        $this->assertEquals($this->response->getStatusCode(), '200');
        $this->assertJson($this->prisoner_response);
    }

    public function testCellAttributeExistinJsonresponse()
    {
         $this->assertObjectHasAttribute("cell", $this->prisoner_json_object);
    }

    public function testBlockAttributeExistinJsonresponse()
    {
         $this->assertObjectHasAttribute("block", $this->prisoner_json_object);
    }

    public function testCellBinaryValueMatchesTextOutcome()
    {

        $galaticaBasic = (TranslateDroidSpeak::getGalacticBasic($this->prisoner_json_object->cell));
        $this->assertNotEmpty($galaticaBasic);
        $this->assertEquals("Cell 2187", $galaticaBasic);
    }

    public function testBlockBinaryValueMatchesTextOutcome()
    {
        $galaticaBasic = (TranslateDroidSpeak::getGalacticBasic($this->prisoner_json_object->block));
        $this->assertNotEmpty($galaticaBasic);
        $this->assertEquals("Detention Block AA-23,", $galaticaBasic);
    }


    public function testBlockBinaryValueWithSpaceMatchesTextOutcome()
    {
        $block = " ".$this->prisoner_json_object->block." ";
        $galaticaBasic = (TranslateDroidSpeak::getGalacticBasic($block));
        $this->assertNotEmpty($galaticaBasic);
        $this->assertEquals("Detention Block AA-23,", $galaticaBasic);
    }
}
