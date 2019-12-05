<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2018/11/1
 * Time: 2:19 PM
 */

namespace QQ;

class QQPay
{
    use QQConfig;
    use QQUtilFunc;

    public $config = [];

    public $result = [];

    /**
     * @var callable
     */
    private static $success_func = null;
    /**
     * @var callable
     */
    private static $error_func = null;

    public function __construct($config = [])
    {
        $this->config['input_charset'] = "UTF-8";
        $this->config['appid']         = '';

        $this->config['mch_id']    = "";
        $this->config['nonce_str'] = md5(rand(1, 30000) . time());

        $this->config['out_trade_no'] = self::orderId();
        $this->config['memo'] = '提现啦！';
        $this->config['check_real_name'] = '0';

        $this->config['op_user_id']     = '';
        $this->config['op_user_passwd'] = '';

        $this->config['spbill_create_ip'] = '111.207.253.216';


        $this->config = array_merge($this->config, $config);
    }


    /**
     * 提交提现申请
     *
     * @param $success callable 传递一个闭包方法
     * @param $error   callable 传递一个闭包方法
     *
     * @throws
     * @return string
     */
    public function send($success = null, $error = null)
    {
        if (!isset($this->config['sign'])) {
            $this->createSign();
        }
        if ($this->config['total_fee'] == 0) {
            throw new QQException("提现金额不能为0");
        }


        $data = $this->config;

        $xml = self::arrayToXml($data);

        $ret_xml = self::post($this->pay_url, $xml);

        $result       = json_decode(json_encode(simplexml_load_string($ret_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $this->result = $result;

        // 成功条件 商户号 商户订单号 qq钱包订单号
        if ($this->check()) {
            $success ? $success($result) : null;
            $s_obj = self::$success_func;
            $s_obj ? $s_obj($result) : null;

            return 'ok';
        } else {
            $e_obj = self::$error_func;
            $e_obj ? $e_obj($result) : null;

            // 失败条件
            $error ? $error($result) : null;

            return 'no';
        }
    }

    private function check()
    {
        // 成功条件 商户号 商户订单号 qq钱包订单号
        if (isset($this->result['mch_id']) && isset($this->result['out_trade_no']) && isset($this->result['transaction_id'])) {
            if (!empty($this->result['mch_id']) && !empty($this->result['out_trade_no']) && !empty($this->result['transaction_id'])) {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * 成功下走
     *
     * @param $func callable
     *
     * @return void
     */
    public function success($func)
    {
        self::$success_func = $func;
    }

    /**
     * 失败下走
     *
     * @param $func callable
     *
     * @return void
     */
    public function error($func)
    {
        self::$error_func = $func;
    }


    /**
     * 创建sign
     *
     * @throws
     * @return $this
     */
    private function createSign()
    {
        if (empty($this->key)) {
            throw new QQException('商户key未设置');
        }

        ksort($this->config);

        $str                  = urldecode(http_build_query($this->config));// 顺序一定要对
        $str                  .= '&key=' . $this->key; //注：key为商户平台设置的密钥key
        $sign                 = strtoupper(MD5($str)); //注：MD5签名方式
        $this->config['sign'] = $sign;
        return $this;
    }

}