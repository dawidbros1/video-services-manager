<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Service\YouTubeService;

class YouTubeController extends Controller
{
    public function __construct(Request $request)
    {
       parent::__construct($request);

       YouTubeService::$api = $this->google->getYoutubeService();
    }

    public function index(Request $request)
    {
        if (null == $this->user) {
            return redirect()->route('google');
        }

        return view('youtube.list', [
            'subscriptions' => YouTubeService::getSubscriptions()
        ]);
    }

    # Method shows all subscriptions and subscriptions for current category
   public function index2()
   {
      $id = $this->request->getParam('id');

      if (($category = $this->user->_getCategory((int) $id, true)) == null) {
         Session::error("Podana grupa nie istnieje");
         $this->redirect("home", [], true);
      }

      View::set($category->getName() . " - Zarządzanie grupą", 'youtube/index');

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

      return $this->render("youtube/list", [
         'category' => $category,
         'subscriptionInCategory' => $this->sortChannels($category, $youtubeChannels),
         'allMySubscriptions' => $subscriptions,
         'channels' => $category->_getChannels(),
      ]);
   }

   # Method returns all subscriptions for logged in user
   private function getSubscriptions()
   {
      $items = [];
      $subscriptions = $this->youtube->listSubscriptions();

      while ($subscriptions->nextPageToken != null) {
         $items = array_merge($items, $subscriptions->items);
         $pageToken = $subscriptions->nextPageToken;
         $subscriptions = $this->youtube->listSubscriptions($pageToken);
      }

      return array_merge($items, $subscriptions->items);
   }

   # Method removes from all subscriptions, subscription which are in our categories
   private function difference($subscriptions, $channels)
   {
      $ids = [];

      foreach ($channels as $ch) {
         $ids[] = $ch['channel_id'];
      }

      foreach ($subscriptions as $key => $item) {
         if (in_array($item->snippet->resourceId->channelId, $ids)) {
            unset($subscriptions[$key]);
         }
      }

      return $subscriptions;
   }

   # Method sorts channels
   private function sortChannels($category, $channels)
   {
      $localChannels = $category->_getChannels();
      $ids = [];

      foreach ($localChannels as $lc) {
         $ids[] = $lc->getChannelId();
      }

      $output = [];

      for ($i = 0; $i < count($channels); $i++) {
         foreach ($channels as $channel) {
            if ($channel->id == $ids[$i]) {
               $output[] = $channel;
            }
         }
      }

      return $output;
   }

   private function createShortDescription($channels)
   {
      foreach ($channels as $key => $channel) {
         $description = $channel->snippet->description;
         $shortDescription = substr($description, 0, 250);

         if (strlen($description) >= 250) {
            $shortDescription = preg_replace('/\W\w+\s*(\W*)$/', '$1', $shortDescription);
         }

         $channels[$key]->snippet->shortDescription = $shortDescription;
      }

      return $channels;
   }
}
