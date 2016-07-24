<?php
/*
	Plugin Name: Kumademo Panorama Viewer
	Plugin URI: 
	Description: クマでもできるパノラマ表示プラグイン
	Version: 0.0.1
	Author: WordBench Kumamoto
	Author URI: http://wordbench.org/groups/kumamoto/
	Text Domain: kumademo-panorama-viewer
	Domain Path: /languages/
*/

class KumademoPanoramaViewer
{
	/*
		コンストラクタ
	*/
	function __construct()
	{
		// 初期化処理
		add_action('plugins_loaded', array($this, 'plugins_loaded'));
	}

	/*
		初期化処理
	*/
	public function plugins_loaded()
	{
		// 管理画面のメニュー追加
		add_action('admin_menu', array($this, 'admin_menu'));
		
		// 管理画面用のスクリプト読み込み
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		
		// フロントページのスクリプト読み込み
		add_action('wp_print_scripts', array($this, 'wp_print_scripts'));
		
		// ショートコードの追加
		add_shortcode('kumademo-panorama-viewer', array($this, 'short_code'));
	}

	/*
		管理画面のメニュー追加
	*/
	public function admin_menu()
	{
		// メディアのサブメニューに項目を追加する
		add_media_page('パノラマ表示', 'パノラマ表示', 'upload_files', 'kumademo-panorama-viewer-page', array($this,'show_page'));
	}

	/*
		パノラマ表示画面の出力
	*/
	public function show_page()
	{
		include "page.php";
	}

	/*
		管理画面用のスクリプト読み込み
	*/
	public function admin_enqueue_scripts($hook_suffix)
	{
		// 「メディア／パノラマ表示」である場合のみ
		if ($hook_suffix == 'media_page_kumademo-panorama-viewer-page') {
			// メディアアップローダの javascript API
		    wp_enqueue_media();
			
		    // 作成した javascript
			wp_enqueue_script(
				'mediauploader',
				plugin_dir_url( __FILE__ ) . '/mediauploader.js',
				array( 'jquery' ),
				false,
				true
			);
		}
	}

	/*
		フロントページのスクリプト読み込み
	*/
	function wp_print_scripts()
	{
		if ($this->has_shortcode()) {
			wp_enqueue_script('kumademo-panorama-viewer', plugins_url('aframe.js', __FILE__ ));
		}
	}

	/*
		ショートコード有無の判定
	*/
	function has_shortcode($shortcode)
	{
		// グローバル変数の利用
		global $wp_query;
		
		// 投稿ページまたは固定ページの場合
		if (is_single() || is_page()) {
			// 含まれる記事の分だけループする
			foreach($wp_query->posts as $post) {
				// 記事がある場合
				if (isset($post->post_content)) {
					// ショートコードの記載があるか判定する
					if (preg_match('/\[kumademo-panorama-viewer[ ]+id=[0-9]+\]/i', $post->post_content)) {
						return true;
					}
				}
			}
		}
	
		return false;
	}

	/*
		ショートコード
	*/
	public function short_code($atts)
	{
		// 引数があれば変数に代入する（なければデフォルト値）
		extract(shortcode_atts(array(
			'id' => 0,
			'src' => plugins_url( 'panorama.jpg', __FILE__ ),
			'rotation' => '0 -130 0',
		), $atts));

		// メディアIDの指定がなければ src から取得を試みる
		if ($id != 0) {
			$img = wp_get_attachment_image_src($id, 'full');
			if (!empty($img)) {
				$src = $img[0];
			}
		}

		// ショートコードの展開
		echo '<a-scene><a-sky src="' . $src . '" rotation="0 -130 0"></a-sky></a-scene>' . "\n";
	}
}

new KumademoPanoramaViewer;

?>
