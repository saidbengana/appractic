<?php

namespace Inovector\Appractic\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Inovector\Appractic\Concerns\UsesSocialProviderResponse;
use Inovector\Appractic\Contracts\SocialProvider as SocialProviderContract;
use Exception;
use Inovector\Appractic\Models\Account;

abstract class SocialProvider implements SocialProviderContract
{
    use UsesSocialProviderResponse;

    // For some social service providers, it is enough that the user himself can manage the content.
    // But some providers, such as Facebook, require a user account to select some entities to manage (pages or groups).
    // When you need to change this value, just overwrite it in the provider class that extends this class.
    // In case of `false` value, `getEntities()` method is required.
    public bool $onlyUserAccount = true;

    public array $callbackResponseKeys = [];
    protected array $accessToken = [];

    protected Request $request;
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected string $redirectUrl;

    protected array $values = [];

    const ACCESS_TOKEN_SESSION_NAME = 'appractic_provider_access_token';

    public function __construct(Request $request, string $clientId, string $clientSecret, string $redirectUrl, array $values = [])
    {
        $this->request = $request;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUrl = $redirectUrl;
        $this->values = $values;
    }

    public function isOnlyUserAccount(): bool
    {
        return $this->onlyUserAccount;
    }

    public function getCallbackResponse(): array
    {
        return $this->request->only($this->callbackResponseKeys);
    }

    // Use this method into web app. For example, in Controllers..etc.
    public function setAccessToken(array $token = []): void
    {
        $this->accessToken = $token;

        $this->request->session()->put(self::ACCESS_TOKEN_SESSION_NAME, $token);
    }

    public function getAccessToken()
    {
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }

        $token = $this->request->session()->get(self::ACCESS_TOKEN_SESSION_NAME);

        if (!$token) {
            throw new Exception('Missing Access Token.');
        }

        return $token;
    }

    // Use this method outside of web app. For example, in Jobs..etc.
    public function useAccessToken(array $token = []): static
    {
        $this->accessToken = $token;

        return $this;
    }

    public function forgetAccessToken(): void
    {
        $this->accessToken = [];
        $this->request->session()->forget(self::ACCESS_TOKEN_SESSION_NAME);
    }

    public function tokenIsAboutToExpire(): bool
    {
        $expires_in = $this->getAccessToken()['expires_in'];

        $expiresAt = Carbon::createFromTimestamp($expires_in, 'UTC');
        $minutesAhead = Carbon::now('UTC')->addMinute();

        return $expiresAt->lte($minutesAhead);
    }

    public function updateToken(array $newAccessToken): void
    {
        $accessToken = array_merge($this->getAccessToken(), $newAccessToken);

        $this->useAccessToken($accessToken);

        if ($account = Account::find($this->values['account_id'])) {
            $account->update([
                'access_token' => $accessToken
            ]);
        }
    }

    public function getHttpClient(): Http
    {
        return resolve(Http::class);
    }

    public function buildUrlFromBase(string $url, array $params): string
    {
        return $url . '?' . http_build_query($params, '', '&');
    }

    public function rateLimitExceedContext(int $retryAfter, ?string $customText = null): array
    {
        $defaultText = 'The rate limit has been exceeded';
        $date = Carbon::now('UTC')->addSeconds($retryAfter)->format('Y-m-d');

        return [
            'rate_limit_exceed' => true,
            'message' => $customText ?? $defaultText,
            'next_attempt_at' => $date
        ];
    }
}
