<?php

namespace Inovector\Appractic\SocialProviders\Meta;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inovector\Appractic\Abstracts\SocialProvider;
use Inovector\Appractic\Http\Resources\AccountResource;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesConfig;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesMetaResources;
use Inovector\Appractic\SocialProviders\Meta\Concerns\ManagesRateLimit;
use Inovector\Appractic\SocialProviders\Meta\Concerns\MetaOauth;

class MetaProvider extends SocialProvider
{
    use ManagesRateLimit;
    use MetaOauth;
    use ManagesConfig;
    use ManagesMetaResources;

    public array $callbackResponseKeys = ['code'];

    protected string $apiVersion;
    protected string $apiUrl = 'https://graph.facebook.com';

    protected string $scope;

    public function __construct(Request $request, string $clientId, string $clientSecret, string $redirectUrl, array $values = [])
    {
        $this->setApiVersion();

        $this->setScope();

        parent::__construct($request, $clientId, $clientSecret, $redirectUrl, $values);
    }

    protected function setApiVersion(): void
    {
        $this->apiVersion = $this->getApiVersionConfig();
    }

    protected function setScope(): void
    {
        $this->scope = implode(',', $this->getSupportedScopeList());
    }

    public function getSupportedScopeList(): array
    {
        return match ($this->apiVersion) {
            'v16.0' => [
                'pages_show_list',
                'read_insights',
                'pages_manage_posts',
                'instagram_basic',
                'instagram_content_publish',
                'instagram_manage_insights'
            ],
            default => [
                'business_management',
                'pages_show_list',
                'read_insights',
                'pages_manage_posts',
                'instagram_basic',
                'instagram_content_publish',
                'instagram_manage_insights'
            ]
        };
    }

    public function getAuthUrl(): string
    {
        return '';
    }

    public static function externalPostUrl(AccountResource $accountResource): string
    {
        return '#';
    }
}
