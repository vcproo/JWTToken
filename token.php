<?php
/*
 * @Author: han hants666@163.com
 * @Date: 2023-04-17 11:05:46
 * @LastEditors: han hants666@163.com
 * @LastEditTime: 2023-04-17 11:44:34
 * @FilePath: \JWTtoken\token.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
include 'jwt.php';
class Token{
    function __construct() {
      
    }
    private $config = ["jwt" => [
        'key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDacj5EAnD8QxS4
        8pHsMdbRwzFgUuPELnHOTDWD/aZ5skSbw/hhcM5tdNl4bpwIHv91ovmJEPBlzvlV
        sF//6HUqAwl9E6jCEZGq4aOeReKeI+ZjhHX1nzs94I758Ln6QzyvRSMByyYv5rqG
        kzytKB2ewYsZuWmTs2Pa+samq3YeS+Xhklg8WEE8Dxfe9gakZVC6ttPA/C+pQNEu
        FUxiOsgKK3LL2xXYFPt/ELjXTlzi7XVZKZmoTJbA9zUQXz0YBKMoPMeRLAFm26e/
        5Dak2+QACVpOkyBnG85OOaIFaqe54qjgQvTjmSyc4K+E/zNgne7Sxako+J6zvx8D
        zehKM/Y3AgMBAAECggEAR0zItAwT8tK2XdOW+4Ac/OR4JleHzk3WiZ5oTUeqYchl
        Cm6BkNRwHFvqa5u2xBPSEAR87FciECjpSyXBf9bQ/0B0hWW4THfNkvgJHqzy1ekj
        1tGyatRpUr4MDNqc6Wmu0gp/7aLwOOxXb3t5b49Lc7j6fQ/+vN3tttjppBcM+7/x
        yScHEUrmgcyeCEmnkbFB2yk0+vVIDIWL6kfjzZ2gJrrD7mgXWzN3VBcjI08+w6B+
        fVjGeACGP5mbhqlMGTmY13q/MAj5JgbxUcON3YUh7SIm42IcorGhuBwFm7vBuJS2
        JslKrcmCZhPf9enb70TNJd2GyaOFs4SkqOX+lZRTKQKBgQDwLl817kUstwAZtxUh
        YxePQlJun3tzxMrjqsWHY+E/9cSlTBfuRPxB9pdHN7AvsWjYuQSduSXHw2bj9B7I
        U+WQaBuieVz4vU7vNxyeZcCYXDvP6mOzKAFsmWmMG4+xGxBuLYHDDqfM3PaUJT81
        2qjrUAodN9VLz378CV0AiUb2zQKBgQDo1WfQHooWv9SIaD6IOfUqJXSiKfX7HrAo
        OnFiuJvuTZiRerARq5izULMW2wI8t413a4gRBhsKloAD8JJs6LjbU9Cwu/FwSkk+
        OnoSnWZW2bE5kUFj1I1HM3g15NxGPLSKbsj64yuO+pzOsyeYmTpovK8Ri/vTlEpg
        +egY6Ow5EwKBgQCqLuFt0FAZl+2tSunhB1q5OrA4DC8oX6e3W9isz1vauyVETr+i
        KCVqA/U7FD11/cohzi90Jq2bd1xfZymsnq3J/cqe/EmhQlo87BsOLWEjVC9ZamaM
        mmsv7SA5k4nkXx3sQ7hvYuIJKgRaAm5glXgdjFAuVdJ/7h23LldEuwCafQKBgFro
        F6RWiCvhsiWgLeoaVvKhtSwrnfLyRG0whFy7H4annU4PzPbZPMGmXIYr9G+oav+Z
        aILdE2nK4SiooUMMikB4NR8MAnSJTJeTVV43PmHilSOY5yMHNjH6kpDYTnjN8t+p
        6aarU7J7fwXlRSx7hyalpOUA9s3hNDkw2cIAD1spAoGBAKiUFyWJjtiMar0X11zr
        Qn7N84EV2csyMHS0I+8lCIwsOtpn4mr7rq0B/I1bY0V+oPJAGWB/AbjjOXzCQAPZ
        koypDRtqwhGzdHuO4aU0ymFotJJNf12X2tW+tNjE4rRC/skWW9ALYVatPLjuJqc9
        1iFj8/i+x6cOzLqapZN2bM7b", //自定义秘钥 http://web.chacuo.net/netrsakeypair 生成秘钥
        "iss" => "admin",  //签发者 可以为空
        "aud" => "user_for_xxx", //面象的用户，可以为空
        "iat" => '0', //签发时间
        "nbf" => '0', //在什么时候jwt开始生效
        "exp" => 7*24*3600, //token 过期时间 7 天
    ]];
    // function __construct($param) {
    //     var_dump($param);exit;
    // }
    /**
     * jwt生成token
     * @param 用户信息 ['user_name'=>'','user_id'=>''] 内容及结构可自定义按需求填写
     * @return array
     */
    public function createToken($param)
    {
        $config = $this->config;
        $key = $config['jwt']['key'];  //这里是自定义的一个随机字串
        $token = [
            "iss" => $config['jwt']['iss'],  //签发者 可以为空
            "aud" => $config['jwt']['aud'], //面象的用户，可以为空
            "iat" => time() + $config['jwt']['iat'], //签发时间
            "nbf" => time() + $config['jwt']['nbf'], //在什么时候jwt开始生效
            "exp" => time() + $config['jwt']['exp'], //token 过期时间
            'jti'=>md5(uniqid('JWT').time()),
        ];
        foreach($param as $k => $row){
            $token[$k] = $row;
        }
        try
        {
            $jwt = Jwt::getToken($token,$key);
            $result = ['state'=>1,'code'=>200,'message'=>'','data'=>$jwt];
            return $result;
        }
        catch(\Exception $e)
        {
            //捕获异常
            $result = ['state'=>0,'code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
        return $result;
    }
     /**
     * 检查token状态
     * @param $request token
     * @return array
     */
    public function checkToken($token)
    {
        $config = $this->config;//上一个方法中的 $key
        $key = $config['jwt']['key'];  //这里是自定义的一个随机字串
        try
        {
            $result = Jwt::verifyToken($token,$key);
            $result = ['state'=>$result['state'],'code'=>$result['code'],'message'=>$result['msg'],'data'=>$result['data']];
            return $result;
        }
        catch(\Exception $e)
        {
            //捕获异常
            $result = ['state'=>0,'code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
        return $result;
    }
    
}
?>