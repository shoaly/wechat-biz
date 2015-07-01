<?php 
namespace Hexinhui\WechatBiz\Utils;


use Overtrue\Wechat\UserBiz;
use Overtrue\Wechat\AuthBiz as WechatAuth;
use Queue;
use Overtrue\Wechat\StaffBiz;

use Overtrue\Wechat\MessageBiz;


class Wechat {

    private $appId;
    private $secret;


    public function __construct(){
        $this->appId  = env("WECHAT_CORPID");
        $this->secret = env("WECHAT_CORPSECRET");
    }

    public function notify_signin_to_department($signin,$department_id){
        
        $staff_biz = new StaffBiz($this->appId, $this->secret);

        

        $news = MessageBiz::make('news')->items(function() use($signin){
            return array(
                $news = MessageBiz::make('news_item')
                    ->title(sprintf("[%s] %s %s 签到",$signin->sign_type,date_format($signin->created_at,"m月d日 H:i"), $signin->name))
                    ->description($signin->address)
                    ->url(sprintf('http://cnyy.1024it.cn/signin/maps?latitude=%s&longitude=%s',$signin->latitude,$signin->longitude)),
           );
        });


        $staff_biz->send($news)->toparty($department_id,6);
    }

    
    private function _send_message($touser,$title,$description,$url=false,$picUrl=false){

        
        // $message = MessageBiz::make("text")->with('content',"你好".date("Y-m-d H:i:s",time()));
        // $staff_biz = $staff_biz->send("你好".date("Y-m-d H:i:s",time()))->toparty(1);;
        // print_r($touser);die;
        
        if(false){
            $news = MessageBiz::make('news')->items(function(){
                return array(
                        // MessageBiz::make('news_item')->title('测试标题4')->url('http://baidu.com/abc.php')->picUrl('http://www.baidu.com/demo.jpg'),
                        // MessageBiz::make('news_item')->title('测试标题'),
                        // MessageBiz::make('news_item')->title('测试标题2')->description('好不好？'),
                        MessageBiz::make('news_item')->title('测试标题3')->description('好不好说句话？')->url('http://baidu.com'),
               );
            });
        }
        $self = $this;

        Queue::push(function() use ($self,$touser,$title,$description,$url,$picUrl){
            $staff_biz = new StaffBiz($self->appId, $self->secret);

            $news = MessageBiz::make('news_item')->title($title)->description($description);

            if($url){
                $news->url($url);
            }

            if($picUrl){
                $news->picUrl($picUrl);
            }


            $staff_biz->send($news)->touser($touser);;

        });

        

        
    }

}