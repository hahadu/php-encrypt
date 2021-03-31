<?php
/**
 *  +----------------------------------------------------------------------
 *  | Created by  hahadu (a low phper and coolephp)
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2020. [hahadu] All rights reserved.
 *  +----------------------------------------------------------------------
 *  | SiteUrl: https://github.com/hahadu/php-encrypt
 *  +----------------------------------------------------------------------
 *  | Author: hahadu <582167246@qq.com>
 *  +----------------------------------------------------------------------
 *  | Date: 2021/03/17 下午6:04
 *  +----------------------------------------------------------------------
 *  | Description:   AES加密类
 *  +----------------------------------------------------------------------
 **/

namespace Hahadu\Encrypt\Aes;
use Hahadu\Encrypt\Base64\Base64;

/****
 * AES加解密类
 * Class AesEncrypt
 * @package Hahadu\Wechat
 */

final class AesEncrypt
{
    /**
     * @var string $method 加解密方法，可通过openssl_get_cipher_methods()获得
     */
    protected $method;

    /**
     * @var string $secret_key 加解密的密钥
     */
    protected $secret_key;

    /****
     * @var false|int  获取密码iv长度
     */
    protected $ivlen;

    /**
     * @var string $iv 加解密的向量，有些方法需要设置比如CBC
     */
    protected $iv;

    /**
     * @var string $options （不知道怎么解释，目前设置为0没什么问题）
     */
    protected $options;

    /****
     * @var Base64 base64编解码
     */
    protected $base64;

    /**
     * 构造函数
     *
     * @param string $key 密钥
     * @param string $method 加密方式
     * @param string $iv iv向量
     * @param mixed $options 还不是很清楚
     * 使用意见。后台请使用 AES-128-ECB API传输加密建议使用 AES-128-CBC 并携带IV向量。必备
     *
     */
    public function __construct($key, $method = 'AES-256-ECB', $iv = '', $options = OPENSSL_NO_PADDING)
    {
        $this->base64 = new Base64();
        // key是必须要设置的
        $this->secret_key = isset($key) ? $key : '132465';

        $this->method = $method;

        $this->options = $options;

        $this->ivlen = openssl_cipher_iv_length($this->method);

        $this->iv = isset($iv)?$iv:openssl_random_pseudo_bytes($this->ivlen);
    }

    /**
     * 加密方法，对数据进行加密，返回加密后的数据
     * @param string $data 要加密的数据
     * @return string
     */
    public function encrypt($data)
    {
        $aesValue = openssl_encrypt($data, $this->method, $this->secret_key, $this->options, $this->iv);
        return $this->base64->url_safe_b64encode($aesValue);
    }

    /**
     * 解密方法，对数据进行解密，返回解密后的数据
     * @param string $data 要解密的数据
     * @return string
     */
    public function decrypt($data)
    {
        $data = $this->base64->url_safe_b64decode($data);
        return openssl_decrypt($data, $this->method, $this->secret_key, $this->options, $this->iv);
    }

}
