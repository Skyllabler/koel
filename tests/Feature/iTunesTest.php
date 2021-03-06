<?php

namespace Tests\Feature;

use App\Services\iTunes;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery as m;
use Tests\BrowserKitTestCase;

class iTunesTest extends BrowserKitTestCase
{
    use WithoutMiddleware;

    public function testGetTrackUrl()
    {
        $client = m::mock(Client::class, [
            'get' => new Response(200, [], file_get_contents(__DIR__.'../../blobs/itunes/track.json')),
        ]);

        $api = new iTunes($client);
        self::assertEquals(
            'https://itunes.apple.com/us/album/i-remember-you/id265611220?i=265611396&uo=4&at=1000lsGu',
            $api->getTrackUrl('Foo Bar')
        );

        self::assertNotNull(cache(md5('itunes_track_url_Foo Bar')));
    }
}
