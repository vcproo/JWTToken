<?php
    include 'token.php';
    $token = new Token();
    
    $token = $token->createToken(['id'=>'10','name'=>'tom']);
    // $token = $token->checkToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJhZG1pbiIsImF1ZCI6InVzZXJfZm9yX3h4eCIsImlhdCI6MTY4MTcwMjkzNSwibmJmIjoxNjgxNzAyOTM1LCJleHAiOjE2ODIzMDc3MzUsImp0aSI6IjZhYzA0NjkwNDdiMWE4ODQyNjhkOTIxZTBmZGE2ZDdmIiwiaWQiOiIxMCIsIm5hbWUiOiJ0b20ifQ.uBSfgnDo6SOfCUG_uRkqP7DJp9OZMnouhUCUV4Cssx4');
    var_dump($token);
?>