<?php 
namespace Hexinhui\WechatBiz\Facades;

use Illuminate\Support\Facades\Facade;

class WechatBizTool extends Facade {
       /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'wechat_biz_serivce';
    }
}