<?php

namespace Inovector\Appractic\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Inovector\Appractic\SocialProviders\Mastodon\MastodonProvider;
use Inovector\Appractic\SocialProviders\Meta\FacebookGroupProvider;
use Inovector\Appractic\SocialProviders\Meta\FacebookPageProvider;
use Inovector\Appractic\SocialProviders\Twitter\TwitterProvider;

class AccountResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'image' => $this->image(),
            'provider' => $this->provider,
            'provider_options' => $this->providerOptions(),
            'created_at' => $this->created_at->diffForHumans(),
            'external_url' => $this->whenPivotLoaded('appractic_post_accounts', function () {
                if (!$this->pivot->provider_post_id) {
                    return null;
                }

                return $this->getExternalPostUrl();
            }),
            'errors' => $this->whenPivotLoaded('appractic_post_accounts', function () {
                return $this->pivot->errors ? json_decode($this->pivot->errors) : [];
            })
        ];
    }

    protected function getExternalPostUrl(): ?string
    {
        return match ($this->provider) {
            'twitter' => TwitterProvider::externalPostUrl($this),
            'facebook_page' => FacebookPageProvider::externalPostUrl($this),
            'facebook_group' => FacebookGroupProvider::externalPostUrl($this),
            'mastodon' => MastodonProvider::externalPostUrl($this),
            default => '#'
        };
    }
}
