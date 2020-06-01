<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;

class OAuthController extends Controller
{
    /**
     * 各SNSのOAuth認証画面にリダイレクトして認証
     * @param string $provider サービス名
     * @return mixed
     */
    public function socialOAuth(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * 各サイトからのコールバック
     * @param string $provider サービス名
     * @return mixed
     */
    public function handleProviderCallback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();
        $user = User::firstOrNew(['email' => $socialUser->email]);
        // ユーザーが存在していなかったら
        if (!$user->exists) {
            // name及びprovider id provider nameをget
            $user->name = $socialUser->getNickname() ?? $socialUser->getName() ?? $socialUser->getNick();
            $user->provider_id = $socialUser->getId();
            $user->provider_name = $provider;
            // パスワードは適当に作成
            $user->password = \Hash::make(uniqid());
            $user->save();
            // 上記情報にてログイン
            Auth::login($user);
            return redirect('/label');  
        }
        // すでに存在していたらそのままログイン
        Auth::login($user);
        return redirect('/label');
    }
}
