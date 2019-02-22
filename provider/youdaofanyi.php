<?php

class ATS_YoudaoFanYi
{
    private $key, $from;

    public function __construct(array $config)
    {
        $this->key = $config['key'];
        $this->from = $config['from'];
    }
    public function getSlug(String $string)
    {
        $englishSentence = $this->request($string);
        return $englishSentence;
    }
    private function request($char)
    {
        $url = "http://fanyi.youdao.com/fanyiapi.do?keyfrom=" . $this->from . "&key=" . $this->key . "&type=data&doctype=json&version=1.1&q=" . $char;
        $response = wp_remote_get(esc_url_raw($url));
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);
        if (strlen($data->translation[0]) < 2) {
            return $char;
        } else {
            return $data->translation[0];
        }
    }
}
