<?php
/**
 * BaseMessage.php
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

namespace Hexinhui\WechatBiz\Wechat\MessagesBiz;

use Overtrue\Wechat\Messages\BaseMessage;
use Overtrue\Wechat\Utils\MagicAttributes;
use Overtrue\Wechat\Utils\XML;

/**
 * 消息基类
 *
 * @property string      $from
 * @property string      $to
 * @property string      $staff
 *
 * @method BaseMessage to($to)
 * @method BaseMessage from($from)
 * @method BaseMessage staff($staff)
 * @method array       toStaff()
 * @method array       toReply()
 * @method array       toBroadcast()
 * @method array       buildForStaff()
 * @method string      buildForReply()
 */
abstract class BaseMessageBiz extends BaseMessage
{

    /**
     * 允许的属性
     *
     * @var array
     */
    protected $properties = array();

    /**
     * 基础属性
     *
     * @var array
     */
    protected $baseProperties = array(
                                 'touser',
                                 'toparty',
                                 'totag',
                                 'agentid',
                                 'safe',
                                );


    /**
     * 生成用于主动推送的数据
     *
     * @return array
     */
    public function buildForStaff()
    {

        if (!method_exists($this, 'toStaff')) {
            throw new Exception(__CLASS__.'未实现此方法：toStaff()');
        }

        $base = array(
                 'touser'  => $this->touser,
                 'toparty'  => $this->toparty,
                 'totag'  => $this->totag,
                 'agentid'  => $this->agentid,
                 'msgtype' => $this->getDefaultMessageType(),
                );
        if (!empty($this->staff)) {
            $base['customservice'] = array('kf_account' => $this->staff);
        }
        
        return array_merge($base, $this->toStaff());
    }

    
}
