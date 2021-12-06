<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function display(){
        // Mail::sendで送信できる.
        // 第1引数に、テンプレートファイルのパスを指定し、
        // 第2引数に、テンプレートファイルで使うデータを指定する
        Mail::display('text', [
            "message" => "こんにちは！"

        ], function($message) {

            // 第3引数にはコールバック関数を指定し、
            // その中で、送信先やタイトルの指定を行う.
            $message
                ->to('user1@sample.com')
                ->bcc('admin@sample.com')
                ->subject("ユーザー登録ありがとうございます");
        });
    }
    }
}
