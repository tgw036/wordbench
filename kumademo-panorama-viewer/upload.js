(function ($) {
	var custom_uploader;
	$("input:button[name=media]").click(function(e) {
		e.preventDefault();
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		custom_uploader = wp.media({
			title: "Choose Image",
			/* ライブラリの一覧は画像のみにする */
			library: {
				type: "image"
			},
			button: {
				text: "Choose Image"
			},
			/* 選択できる画像は 1 つだけにする */
			multiple: false
		});
		custom_uploader.on("select", function() {
			var images = custom_uploader.state().get("selection");
			/* file の中に選択された画像の各種情報が入っている */
			images.each(function(file){
				/* テキストフォームと表示されたサムネイル画像があればクリア */
				$("input:text[name=mediaid]").val("");
				$("#media").empty();
				/* テキストフォームに画像の ID を表示 */
				$("input:text[name=mediaid]").val("[kumademo-panorama-viewer id=" + file.id + "]");
				/* プレビュー用に選択されたサムネイル画像を表示 */
				$("#media").append('<p><img src="'+file.attributes.sizes.full.url+'" style="max-width:100%"/></p>');
			});
		});
		custom_uploader.open();
	});
	/* クリアボタンを押した時の処理 */
	$("input:button[name=media-clear]").click(function() {
	 
		$("input:text[name=mediaid]").val("");
		$("#media").empty();
	});
})(jQuery);
