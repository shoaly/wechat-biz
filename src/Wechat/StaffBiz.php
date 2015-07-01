<?php
/**
 * Staff.php
 *
 * Part of Overtrue\Wechat.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    overtrue <i@overtrue.me>
 * @copyright 2015 overtrue <i@overtrue.me>
 * @link      https://github.com/overtrue
 * @link      http://overtrue.me
 */

namespace Hexinhui\WechatBiz\Wechat;

use Overtrue\Wechat\MessagesBiz\BaseMessageBiz;

/**
 * 客服
 */
class StaffBiz
{

    /**
     * 消息
     *
     * @var \Overtrue\Wechat\Messages\BaseMessage;
     */
    protected $message;

    /**
     * 指定消息发送客服账号
     *
     * @var string
     */
    protected $by;

    /**
     * 请求的headers
     *
     * @var array
     */
    protected $headers = array('content-type:application/json');

    // const API_GET           = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist';
    // const API_ONLINE        = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist';
    // const API_DELETE        = 'https://api.weixin.qq.com/customservice/kfaccount/del';
    // const API_UPDATE        = 'https://api.weixin.qq.com/customservice/kfaccount/update';
    // const API_CREATE        = 'https://api.weixin.qq.com/customservice/kfaccount/add';
    // const API_AVATAR_UPLOAD = 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg';
    const API_MESSAGE_SEND  = 'https://qyapi.weixin.qq.com/cgi-bin/message/send';

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    /**
     * constructor
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->http = new Http(new AccessTokenBiz($appId, $appSecret));
    }

    
    /**
     * 准备消息
     *
     * @param \Overtrue\Wechat\Messages\BaseMessage $message
     *
     * @return Staff
     */
    public function send($message)
    {

        is_string($message) && $message = MessageBiz::make('text')->with('content', $message);
        // print_r($message);die;
        if (!$message instanceof BaseMessageBiz) {
            throw new Exception("消息必须继承自 'Overtrue\Wechat\BaseMessageBiz'");
        }
        // die;
        $this->message = $message;

        return $this;

    }

    
    /**
     * 发送消息
     *
     * @param string $openId
     *
     * @return bool
     */
    public function touser($userId,$agentid=1)
    {
        if (empty($this->message)) {
            throw new Exception('未设置要发送的消息');
        }
        $this->message->touser = $userId;
        $this->message->agentid = $agentid;
        $message_body = $this->message->buildForStaff();
        return $this->http->jsonPost(self::API_MESSAGE_SEND, $message_body);
    }
    /**
     * 发送消息
     *
     * @param string $openId
     *
     * @return bool
     */
    public function toparty($partyid,$agentid=1)
    {
        if (empty($this->message)) {
            throw new Exception('未设置要发送的消息');
        }

        $this->message->toparty = $partyid;
        $this->message->agentid = $agentid;
        $message_body = $this->message->buildForStaff();
        return $this->http->jsonPost(self::API_MESSAGE_SEND, $message_body);
    }
    /**
     * 发送消息
     *
     * @param string $openId
     *
     * @return bool
     */
    public function totag($tagid,$agentid=1)
    {
        if (empty($this->message)) {
            throw new Exception('未设置要发送的消息');
        }
        $this->message->totag = $tagid;
        $this->message->agentid = $agentid;
        $message_body = $this->message->buildForStaff();
        
        return $this->http->jsonPost(self::API_MESSAGE_SEND, $message_body);
    }


}
