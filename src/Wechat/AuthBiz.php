<?php
/**
 * Auth.php
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

use Overtrue\Wechat\Utils\Bag;

use Log;

/**
 * OAuth 网页授权获取用户信息
 */
class AuthBiz
{

    /**
     * 应用ID
     *
     * @var string
     */
    protected $appId;

    /**
     * 应用secret
     *
     * @var string
     */
    protected $appSecret;

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    /**
     * 输入
     *
     * @var Bag
     */
    protected $input;

    /**
     * 获取上一次的授权信息
     *
     * @var array
     */
    protected $lastPermission;

    /**
     * 已授权用户
     *
     * @var \Overtrue\Wechat\Utils\Bag
     */
    protected $authorizedUser;

    const API_URL            = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    const API_USER           = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo';

    /**
     * constructor
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId     = $appId;
        $this->appSecret = $appSecret;
        $this->http      = new Http(); // 不需要公用的access_token
        $this->input     = new Input();
    }

    /**
     * 生成outh URL
     *
     * @param string $to
     * @param string $scope
     * @param string $state
     *
     * @return string
     */
    public function url($to = null, $scope = 'snsapi_base', $state = 'STATE')
    {
        $to !== null || $to = Url::current();

        $params = array(
                   'appid'         => $this->appId,
                   'redirect_uri'  => $to,
                   'response_type' => 'code',
                   'scope'         => $scope,
                   'state'         => $state,
                  );

        return self::API_URL.'?'.http_build_query($params).'#wechat_redirect';
    }

    /**
     * 直接跳转
     *
     * @param string $to
     * @param string $scope
     * @param string $state
     */
    public function redirect($to = null, $scope = 'snsapi_base', $state = 'STATE')
    {
        header('Location:'.$this->url($to, $scope, $state));

        exit;
    }

    /**
     * 获取已授权用户
     *
     * @return \Overtrue\Wechat\Utils\Bag | null
     */
    public function user()
    {
        if ($this->authorizedUser
            || !$this->input->has('state')
            || (!$code = $this->input->get('code')) && $this->input->has('state')) {
            return $this->authorizedUser;
        }

        $permission = $this->getAccessPermission($code);

        $user = new Bag(array(
            'UserId' => $permission['UserId'],
            'DeviceId' => $permission['DeviceId']
        ));
      

        return $this->authorizedUser = $user;
    }

    /**
     * 通过授权获取用户
     *
     * @param string $to
     * @param string $state
     * @param string $scope
     *
     * @return Bag | null
     */
    public function authorize($to = null, $scope = 'snsapi_base', $state = 'STATE')
    {
        if (!$this->input->has('state') && !$this->input->has('code')) {
            $this->redirect($to, $scope, $state);
        }

        return $this->user();
    }

   

    /**
     * 获取access token
     *
     * @param string $code
     *
     * @return string
     */
    public function getAccessPermission($code)
    {
        $access_token = new AccessTokenBiz($this->appId, $this->appSecret);

        $params = array(
                   'code'       => $code,
                   'access_token' => $access_token->getToken(),
                  );

        Log::info($params);

        return $this->lastPermission = $this->http->get(self::API_USER, $params);
    }

    /**
     * 魔术访问
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (isset($this->lastPermission[$property])) {
            return $this->lastPermission[$property];
        }
    }
}
