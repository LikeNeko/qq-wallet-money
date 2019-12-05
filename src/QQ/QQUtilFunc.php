<?php
/**
 * Created by PhpStorm.
 * User: Neko
 * Date: 2019/12/5
 * Time: 12:45 PM
 */
namespace QQ;


trait QQUtilFunc{

    /**
     * 生成一个唯一id
     * @return string
     */
    public static function orderId()
    {
        $year_code = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        $order_sn = $year_code[intval(date('Y')) - 2018] .
            strtoupper(dechex(date('m'))) . date('d') .
            substr(time(), -5) . substr(microtime(), 2, 5) .
            sprintf('%02d', rand(0, 99));
        return "N" . $order_sn;
    }

    /**
     * curl
     *
     * @param $url
     * @param $filed
     *
     * @return mixed
     */
    private function post($url, $filed)
    {

        date_default_timezone_set('PRC');
        $opts = [
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => ['Content-type: text/xml'],
            CURLOPT_COOKIESESSION  => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSLCERT        => $this->getCertPath(),
            CURLOPT_SSLKEY         => $this->getKeyPath()
        ];

        $opts[CURLOPT_URL]        = $url;
        $opts[CURLOPT_POST]       = 1;
        $opts[CURLOPT_POSTFIELDS] = $filed;

        //初始化，执行
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) self::error('请求发生错误：' . $error);
        return $data;
    }

    private static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . self::arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}