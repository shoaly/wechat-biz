<?php 
namespace Hexinhui\WechatBiz\Providers;

use App\Tools\Wechat;
use Illuminate\Support\ServiceProvider;
/**
 * @see \Illuminate\Auth\AuthManager
 * @see \Illuminate\Auth\Guard
 */
class WechatBizServiceProvider extends ServiceProvider{


    public function register()  {
        $this->app->singleton('wechat_biz_serivce', function($app)
        {
            return new Wechat();
        });

        
    }

 

}
