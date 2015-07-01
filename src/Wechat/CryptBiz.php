<?php
/**
 * Crypt.php
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

use Overtrue\Wechat\Utils\XML;

/**
 * 加密解密
 */
class CryptBiz extends Crypt
{   
    //仅仅处理握手的信息
    public function decryptVerifyMsg($msgSignature="", $nonce="", $timestamp="", $echostr=""){



        $encrypted  = $echostr;

        //验证安全签名
        $signature = $this->getSHA1($this->token, $timestamp, $nonce, $encrypted);
       
        if ($signature !== $msgSignature) {
            throw new Exception('Invalid Signature.', self::ERROR_INVALID_SIGNATURE);
        }
        $echostr_crypted = $this->decrypt($encrypted, $this->appId);
        // return $crypted;
        // print_r($crypted);die;
        return array("echostr"=>$echostr_crypted);
        // return XML::parse("<echostr_crypted>".$crypted."</echostr_crypted>");
    }
    
}
