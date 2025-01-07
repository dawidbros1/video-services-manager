<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Group;
use App\Models\GroupChannel;
use App\Google\Service\YoutubeService;

class GroupManagerController extends Controller
{
    public function index(int $id) 
    {
        $group = Group::findOrFail($id);

        YoutubeService::$api = $this->google->getYoutubeService();

        if (null == $this->youtube_user) {
            return redirect()->route('google');
        }

        // Nie przypisane kanały
        $channels = YoutubeService::getSubscriberChannels($this->youtube_user->getId());
        $_channels = [];

        foreach ($channels as $channel) {
             $_channels[$channel->id] = $channel;
        }

        // przypisane kanały
        $groupChannels = GroupChannel::where('user_id', auth()->user()->id)
            ->where('channelId', $this->youtube_user->getId())
            ->get();

        foreach($groupChannels as $groupChannel) {
            $_channels[$groupChannel->youtube_channel_id]->group_channel_id = $groupChannel->id;
        }
        
        return view('groups.manage.index', [
            'group' => $group,
            'channels' => $_channels,
        ]);
    }


    public function insert(Request $request) {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'youtube_channel_id' => 'required|exists:youtube_channels,id',
        ]);

        GroupChannel::create([
            'user_id' => auth()->user()->id,
            'group_id' => $validated['group_id'],
            'youtube_channel_id' => $validated['youtube_channel_id'],
            'channelId' => $this->youtube_user->getId(),
        ]);

        return redirect()->back();
    }

    public function remove(Request $request) {
        $validated = $request->validate([
            'id' => 'required|exists:group_channels,id',
        ]);

        $groupChannel = GroupChannel::findOrFail($validated['id']);
        $groupChannel->delete();

        return redirect()->back();
    }
}
