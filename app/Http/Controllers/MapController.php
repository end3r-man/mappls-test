<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function getLocation(Request $request)
    {
        $url = 'https://www.mapmyindia.com/api/advanced-maps/doc/sample/mapmyindia-vector-maps-atlas-geocoding-rest-api-example.php';

        $res = Http::get($url);

        $dom = new DOMDocument;
        @$dom->loadHTML($res, LIBXML_NOERROR | LIBXML_NOWARNING);

        $scripts = $dom->getElementsByTagName('script');
        $srcs = [];
        $token = null;

        foreach ($scripts as $script) {
            if ($script->hasAttribute('src')) {
                $srcs[] = $script->getAttribute('src');
            }
        }

        foreach ($srcs as $value) {
            if (str_contains($value, 'https://apis.mapmyindia.com/advancedmaps/api/')) {
                $content = explode('https://apis.mapmyindia.com/advancedmaps/api/', $value);

                if (isset($content[1])) {
                    $maps = explode('/map_sdk?layer=vector&v=2.0', $content[1]);
                    $token = $maps[0] ?? null;
                    break;
                }
            }
        }

        $location = null;
        $data = json_decode($this->searchLocation($token, $request->address));

        if ($data->status == 'success' && count($data->data) > 0) {
            $location = json_decode($data->data[0]);
        }

        return response()->json($location);
    }

    private function searchLocation(string $token, ?string $address = null)
    {
        if (is_null($address)) {
            $address = 'chennai';
        }

        $url = 'https://www.mapmyindia.com/api/advanced-maps/doc/sample/getrespgeocode.php';

        $params = [
            'address' => $address,
            'itemCount' => '1',
            'bias' => '0',
            'pod' => '',
            'bound' => '',
            'token' => $token,
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'text/plain, */*; q=0.01',
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:136.0) Gecko/20100101 Firefox/136.0',
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://www.mapmyindia.com/api/advanced-maps/doc/sample/mapmyindia-vector-maps-atlas-geocoding-rest-api-example.php',
                'Connection' => 'keep-alive',
            ])->get($url, $params);

            if ($response->failed()) {
                throw new \Exception('HTTP error! Status: '.$response->status());
            }

            return $response->body();
        } catch (\Exception $e) {
            return 'Error fetching geocode: '.$e->getMessage();
        }
    }
}
