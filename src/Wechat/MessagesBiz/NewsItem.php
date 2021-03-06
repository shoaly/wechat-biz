<?php
/**
 * NewsItem.php
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

/**
 * 图文项
 */
class NewsItem extends BaseMessageBiz
{

    /**
     * 属性
     *
     * @var array
     */
    protected $properties = array(
                             'title',
                             'description',
                             'pic_url',
                             'url',
                            );
}
