<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Google\Service\YoutubeService;
use App\Google\Youtube\Models\Channel;

class YouTubeController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        YoutubeService::$api = $this->google->getYoutubeService();
    }

    public function index(Request $request)
    {
        if (null == $this->youtube_user) {
            return redirect()->route('google');
        }

    
        return view('youtube.list', [
            'subscriptions' => YoutubeService::getSubscriberChannels($this->youtube_user->getId()),
        ]);
    }

    public function videos(string $channelId)
    {
        return view('youtube.videos', [
            'channel' => Channel::where('channelId', $channelId)->firstOrFail(),
            'videos' => YoutubeService::getVideos($channelId),
        ]);
    }

    # Method shows all subscriptions and subscriptions for current category
    public function index2()
    {
        $id = $this->request->getParam('id');

        if (($category = $this->user->_getCategory((int) $id, true)) == null) {
            Session::error('Podana grupa nie istnieje');
            $this->redirect('home', [], true);
        }

        View::set($category->getName() . ' - Zarządzanie grupą', 'youtube/index');

        $youtubeChannels = $this->youtube->getChannels($category->_getChannels())->items; // swap [local channel] to [YouTube channel] class
        $youtubeChannels = $this->createShortDescription($youtubeChannels);
        $subscriptions = $this->getSubscriptions(); // all my subscriptions

        $ids = [];

        foreach ($this->user->getCategories() as $c) {
            $ids[] = $c->getId();
        }

        $localChannels = $this->model->_getChannelsByCategoryIds($ids); // get all local channels for current user
        $subscriptions = $this->difference($subscriptions, $localChannels); // from all subs remove user channels
        $subscriptions = $this->createShortDescription($subscriptions);

        return $this->render('youtube/list', [
            'category' => $category,
            'subscriptionInCategory' => $this->sortChannels($category, $youtubeChannels),
            'allMySubscriptions' => $subscriptions,
            'channels' => $category->_getChannels(),
        ]);
    }
}
