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
			/* ���C�u�����̈ꗗ�͉摜�݂̂ɂ��� */
			library: {
				type: "image"
			},
			button: {
				text: "Choose Image"
			},
			/* �I���ł���摜�� 1 �����ɂ��� */
			multiple: false
		});
		custom_uploader.on("select", function() {
			var images = custom_uploader.state().get("selection");
			/* file �̒��ɑI�����ꂽ�摜�̊e���񂪓����Ă��� */
			images.each(function(file){
				/* �e�L�X�g�t�H�[���ƕ\�����ꂽ�T���l�C���摜������΃N���A */
				$("input:text[name=mediaid]").val("");
				$("#media").empty();
				/* �e�L�X�g�t�H�[���ɉ摜�� ID ��\�� */
				$("input:text[name=mediaid]").val("[kumademo-panorama-viewer id=" + file.id + "]");
				/* �v���r���[�p�ɑI�����ꂽ�T���l�C���摜��\�� */
				$("#media").append('<p><img src="'+file.attributes.sizes.full.url+'" style="max-width:100%"/></p>');
			});
		});
		custom_uploader.open();
	});
	/* �N���A�{�^�������������̏��� */
	$("input:button[name=media-clear]").click(function() {
	 
		$("input:text[name=mediaid]").val("");
		$("#media").empty();
	});
})(jQuery);
