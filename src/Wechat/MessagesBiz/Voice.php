<?php
/**
 * Voice.php
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

use Overtrue\Wechat\Media;

/**
 * 声音消息
 *
 * @property string $media_id
 */
class Voice extends BaseMessageBiz
{

    /**
     * 属性
     *
     * @var array
     */
    protected $properties = array('media_id');

    /**
     * 媒体
     *
     * @var \Overtrue\Wechat\Media
     */
    protected $media;

    /**
     * constructor
     *
     * @param string $appId
     * @param string $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->media = new Media($appId, $appSecret);
    }

    /**
     * 设置语音
     *
     * @param string $path
     *
     * @return Voice
     */
    public function media($path)
    {
        $this->setAttribute('media_id', $this->media->voice($path));

        return $this;
    }

    /**
     * 生成主动消息数组
     *
     * @return array
     */
    public function toStaff()
    {
        return array(
                'voice' => array(
                            'media_id' => $this->media_id,
                           ),
               );
    }

    /**
     * 生成回复消息数组
     *
     * @return array
     */
    public function toReply()
    {
        return array(
                'Voice' => array(
                            'MediaId' => $this->media_id,
                           ),
               );
    }
}
