<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\User;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Requests\UrlStoreRequest;

class UrlController extends Controller
{
    public function show(Url $url, Request $request)
    {
        // increase views count
        $url->update([
            'views' => ++$url->views,
            'last_visited_at' => now(),
        ]);

        // Record detail of the visitor
        if ($url->enable_tracking) {
            $agent = new Agent();

            $url->trackers()->create([
                'ip_address' => $request->ip(),
                'device_name' => $agent->device(),
                'platform' => $agent->platform(),
                'browser' => $browser = $agent->browser(),
                'browser_version' => $agent->version($browser),
                'device_type' => $agent->isDesktop() ? 'Desktop' : ($agent->isPhone() ? 'Phone' : ($agent->isTablet() ? 'Tablet' : 'Robot')),
                'referer_url' => $request->headers->get('referer'),
            ]);
        }

        // check if enforce https
        // if true: replace "http" with "https" -> then redirect to destination
        // else : redirect to destination
        $destinationUrl = $url->destination;
        if ($url->enforce_https) {
            $destinationUrl = preg_replace("/^http:/i", "https:", $url->destination);
        }

        return redirect()->to($destinationUrl);
    }


    public function create(UrlStoreRequest $request)
    {
        $data = $request->validated();

        do {
            $slug = Str::random(5);
        } while (Url::where('slug', $slug)->exists());

        // assign for first user since no api authentication is implemented because it was in the assessment doc
        // if needed we can implement API authentication using "sanctum"
        if ($user = User::first()) {
            $url = Url::create([
                'user_id' => $user->id,
                'destination' => $data['destination'],
                'enforce_https' => $data['enforce_https'],
                'enable_tracking' => $data['enable_tracking'],
                'slug' => $slug
            ]);

            // Using API resource to make a standard API format
            return new UrlResource($url);
        } else {
            abort('EMPTY USER');
        }
    }
}
