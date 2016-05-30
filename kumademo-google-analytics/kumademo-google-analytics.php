<?php
/*
Plugin Name: Kumademo Google Analytics
Plugin URI: 
Description: クマでもできる Google Analytics を導入するプラグイン
Version: 0.1
Author: WordBench Kumamoto
Author URI: http://wordbench.org/groups/kumamoto/
Text Domain: kumademo-google-analytics
Domain Path: /languages/
*/

class KumademoGoogleAnalytics
{
    /*
        コンストラクタ
    */
    function __construct()
    {
        // インストール時に実行する関数を登録する
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));

        // アンインストール時に実行する関数を登録する
        register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));

        // 初期化処理
        add_action('plugins_loaded', array($this, 'plugins_loaded'));

        // wp_head() に自前の関数を登録する
        add_action('wp_head', array($this, 'wp_head'));

        // 管理画面の設定欄に項目を追加する
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /*
        初期化処理
    */
    public function plugins_loaded()
    {
        // 翻訳ファイルの読み込み
        load_plugin_textdomain('kumademo-google-analytics', false, basename(dirname(__FILE__)) . '/languages/');
    }

    /*
        ヘッダー部分への機能追加
    */
    public function wp_head()
    {
        // データベースから任意の保存データを取得する
        $options = get_option('kumademo_google_analytics');
        if (!empty($options['UserAgent'])) {
            // Google Analytics 用のスクリプトを埋め込む
            echo "<script>\n";
            echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
            echo "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n";
            echo "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
            echo "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n";
            echo "ga('create', '" . $options['UserAgent'] . "', 'auto');\n";
            echo "ga('send', 'pageview');\n";
            echo "</script>\n";
        }
    }

    /*
        管理画面のメニュー追加
    */
    public function admin_menu()
    {
        // 設定メニューにサブメニューページを追加する
        add_options_page(
            'Kumademo Google Analytics', // メニューが選択したページのタイトルタグに表示されるテキスト
            'Google Analytics',          // メニューに使用されるテキスト
            'manage_options',            // 権限（管理画面設定へのアクセスを許可）
            'kumademo-google-analytics', // スラッグ名
            array($this, 'show_page')    // コールバック関数
        );
    }

    /*
        管理画面の設定メニューに設定画面を表示する
    */
    public function show_page()
    {
        include 'page.php';
    }

    /*
        インストール時に保存データを初期化する
    */
    public static function activate()
    {
        add_option('kumademo_google_analytics', '');
    }

    /*
        アンインストール時に保存データを削除する
    */
    public static function uninstall()
    {
        delete_option("kumademo_google_analytics");
    }
}

new KumademoGoogleAnalytics;

?>
