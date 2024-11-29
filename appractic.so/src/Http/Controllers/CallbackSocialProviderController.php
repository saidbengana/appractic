<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Inovector\Appractic\Actions\UpdateOrCreateAccount;
use Inovector\Appractic\Facades\SocialProviderManager;

class CallbackSocialProviderController extends Controller
{
    public function __invoke(Request $request, UpdateOrCreateAccount $updateOrCreateAccount, string $providerName): RedirectResponse
    {
        $provider = SocialProviderManager::connect($providerName);

        if (empty($provider->getCallbackResponse())) {
            return redirect()->route('appractic.accounts.index');
        }

        if ($error = $request->get('error')) {
            return redirect()->route('appractic.accounts.index')->with('error', $error);
        }

        if (!$provider->isOnlyUserAccount()) {
            return redirect()->route('appractic.accounts.entities.index', ['provider' => $providerName])
                ->with('appractic_callback_response', $provider->getCallbackResponse());
        }

        $accessToken = $provider->requestAccessToken($provider->getCallbackResponse());

        if ($error = Arr::get($accessToken, 'error')) {
            return redirect()->route('appractic.accounts.index')
                ->with('error', $error);
        }

        $provider->setAccessToken($accessToken);

        $account = $provider->getAccount();

        if ($account->hasError()) {
            return redirect()->route('appractic.accounts.index')
                ->with('error', "It's something wrong. Try again.");
        }

        $updateOrCreateAccount($providerName, $account->context(), $accessToken);

        return redirect()->route('appractic.accounts.index');
    }
}
