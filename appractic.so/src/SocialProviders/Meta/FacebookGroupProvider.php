<?php

namespace Inovector\Appractic\SocialProviders\Meta;

use Illuminate\Support\Collection;
use Inovector\Appractic\Http\Resources\AccountResource;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesFacebookGroupResources;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesFacebookOAuth;

// @deprecated
// We will remove this feature soon
class FacebookGroupProvider extends MetaProvider
{
    use ManagesFacebookOAuth;
    use ManagesFacebookGroupResources;

    public bool $onlyUserAccount = false;

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return "https://www.facebook.com/{$accountResource->pivot->provider_post_id}";
    }
}
