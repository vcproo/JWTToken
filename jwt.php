<?php
/*
 * @Author: han hants666@163.com
 * @Date: 2023-04-17 10:11:54
 * @LastEditors: han hants666@163.com
 * @LastEditTime: 2023-04-17 13:55:24
 * @FilePath: \JWTtoken\jwt.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
class Jwt {
 
    //头部
    private static $header=array(
        'alg'=>'HS256', //生成signature的算法
        'typ'=>'JWT'    //类型
    );
    /**
     * 获取jwt token
     * @param array $payload jwt载荷   格式如下非必须
     * [
     *  'iss'=>'jwt_admin',  //该JWT的签发者
     *  'iat'=>time(),  //签发时间
     *  'exp'=>time()+7200,  //过期时间
     *  'nbf'=>time()+60,  //该时间之前不接收处理该Token
     * ]
     * @return bool|string
     */
    public static function getToken($payload,$key)
    {
        if(is_array($payload))
        {
            $base64header=self::base64UrlEncode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64payload=self::base64UrlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            $token=$base64header.'.'.$base64payload.'.'.self::signature($base64header.'.'.$base64payload,$key,self::$header['alg']);
            return $token;
        }else{
            return false;
        }
    }
 
    /**
     * 验证token是否有效,默认验证exp,nbf,iat时间
     * @param string $Token 需要验证的token
     * @return bool|string
     */
    public static function verifyToken($Token,$key)
    {
        $tokens = explode('.', $Token);
        if (count($tokens) != 3){
            return ['state'=>0,'code'=>506,'msg'=>'无效的Token'];
        }
 
        list($base64header, $base64payload, $sign) = $tokens;
 
        //获取jwt算法
        $base64decodeheader = json_decode(self::base64UrlDecode($base64header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64decodeheader['alg'])){
            return ['state'=>0,'code'=>505,'msg'=>'未指定算法'];
        }
 
        //签名验证
        if (self::signature($base64header . '.' . $base64payload, $key, $base64decodeheader['alg']) !== $sign){
            return ['state'=>0,'code'=>504,'msg'=>'验签错误'];
        }
 
        $payload = json_decode(self::base64UrlDecode($base64payload), JSON_OBJECT_AS_ARRAY);
        //签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time()){
            return ['state'=>0,'code'=>503,'msg'=>'验签错误'];
            // return ['state'=>0,'code'=>config('errorCode.signError'),'msg'=>'验签错误'];
        }
 
        //过期时间小宇当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time()){
            return ['state'=>0,'code'=>502,'msg'=>'Toekn已过期'];
        }
 
        //该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time()){
            return ['state'=>0,'code'=>501,'msg'=>'Toekn未生效'];
        }
 
        return ['state'=>1,'code'=>'200','data'=>$payload];
        // return ['state'=>1,'code'=>config('errorCode.success'),'data'=>$payload];
    }
 
    /**
     * base64UrlEncode   https://jwt.io/  中base64UrlEncode编码实现
     * @param string $input 需要编码的字符串
     * @return string
     */
    private static function base64UrlEncode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
 
    /**
     * base64UrlEncode  https://jwt.io/  中base64UrlEncode解码实现
     * @param string $input 需要解码的字符串
     * @return bool|string
     */
    private static function base64UrlDecode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
 
    /**
     * HMACSHA256签名   https://jwt.io/  中HMACSHA256签名实现
     * @param string $input 为base64UrlEncode(header).".".base64UrlEncode(payload)
     * @param string $key
     * @param string $alg   算法方式
     * @return mixed
     */
    private static function signature($input, $key, $alg = 'HS256')
    {
        $alg_config=array(
            'HS256'=>'sha256'
        );
        return self::base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key,true));
    }
}