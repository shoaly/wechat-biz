<?php
/**
 * User.php
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

/**
 * 用户
 */
class UserBiz
{

    /**
     * Http对象
     *
     * @var Http
     */
    protected $http;

    const API_GET       = 'https://qyapi.weixin.qq.com/cgi-bin/user/get';
    const API_USER_LIST_DEPARTMENT      = 'https://qyapi.weixin.qq.com/cgi-bin/user/list';

    const API_DEPARTMENT_LIST    = 'https://qyapi.weixin.qq.com/cgi-bin/department/list';

    const API_TAG_LIST    = 'https://qyapi.weixin.qq.com/cgi-bin/tag/list';
    const API_USER_LIST_TAG    = 'https://qyapi.weixin.qq.com/cgi-bin/tag/get';
    // const API_REMARK    = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark';
    // const API_OAUTH_GET = 'https://api.weixin.qq.com/sns/userinfo';




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
     * 读取用户信息
     *
     * @param string $userid
     * @param string $lang
     *
     * @return Bag
     */
    public function get($userid = null, $lang = 'zh_CN')
    {
        if (empty($userid)) {
            return $this->lists();
        }

        $params = array(
                   'userid' => $userid,
                   'lang'   => $lang,
                  );

        return new Bag($this->http->get(self::API_GET, $params));
    }

    
    /**
     * 获取用户列表
     *
     * @param string $department_id
     * fetch_child    否   1/0：是否递归获取子部门下面的成员
     * status  否   0获取全部成员，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     *
     * @return Bag
     */
    public function lists_by_department($department_id = 1, $fetch_child=0,$status=0)
    {
        $params = array(
            'department_id' => $department_id,
            'fetch_child' => $fetch_child,
            'status' => $status,
        );

        return new Bag($this->http->get(self::API_USER_LIST_DEPARTMENT, $params));
    }

    public function department_list($id=1){

        $params = array(
            'id' => $id,
        );

        return new Bag($this->http->get(self::API_DEPARTMENT_LIST, $params));
    }

    public function tag_list(){
        $params = array(
        );

        return new Bag($this->http->get(self::API_TAG_LIST, $params));
    }

    public function lists_by_tag($tagid=1){
        $params = array(
            "tagid"=>$tagid
        );

        return new Bag($this->http->get(self::API_USER_LIST_TAG, $params));
    }


}
