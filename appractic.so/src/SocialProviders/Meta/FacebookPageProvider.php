<?php

namespace Inovector\Appractic\SocialProviders\Meta;

use Illuminate\Support\Collection;
use Inovector\Appractic\Http\Resources\AccountResource;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesFacebookOAuth;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesFacebookPageResources;

class FacebookPageProvider extends MetaProvider
{
    use ManagesFacebookOAuth;
    use ManagesFacebookPageResources;

    public bool $onlyUserAccount = false;

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://www.facebook.com/{$accountResource->pivot->provider_post_id}";
    }
}
