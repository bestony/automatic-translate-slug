<?php

class ATS_YouDao
{
    protected $appid, $secret;
    protected $endpoint = 'https://openapi.youdao.com/api';
    public function __construct(String $appid, String $secret)
    {
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function get_slug(String $title)
    {
        return $this->request([
            'q' => $title,
            'form' => 'auto',
            'to' => 'EN',
            'appKey' => $this->appid,
            'salt' => wp_generate_uuid4(),
            'signType' => 'v3',
            'curtime' => strtotime("now"),
        ])['body'];
    }
    private function truncate($q)
    {
        $len = strlen($q);
        return $len <= 20 ? $q : (substr($q, 0, 10) . $len . substr($q, $len - 10, $len));
    }
    private function sign($param)
    {
        $signStr = $param['appKey'] . $this->truncate($param['q']) . $param['salt'] . ($param['curtime']) . $this->secret;
        return hash("sha256", $signStr);
    }
    private function request($param)
    {
        $param['sign'] = $this->sign($param);
        return wp_remote_post($this->endpoint, $param);
    }

}
