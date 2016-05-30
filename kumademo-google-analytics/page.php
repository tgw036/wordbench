<?php
    // リクエストの種類がPOSTかどうか
    if (isset($_POST['options'])) {
        // 更新処理の場合
        check_admin_referer('nonce');                            // nonce用フォームパラメータを検証する(CSRF対策)
        $options = $_POST['options'];                            // POSTされた内容を変数に格納する
        update_option('kumademo_google_analytics', $options);    // サイトオプションの値を更新する
    } else {
        // 表示処理の場合
        $options = get_option('kumademo_google_analytics');      // サイトオプションの値を取得する
    }
?>

<?php if (isset($_POST['options'])) { ?>
<div id="setting-error-settings_updated" class="updated settings-error">
    <p><strong><?php _e('Options Saved', 'kumademo-google-analytics'); ?></strong></p>
</div>
<?php } ?>
<div class="wrap">
    <div id="icon-options-general" class="icon32">
        <br />
    </div>
    <h2><?php _e('Options Title', 'kumademo-google-analytics'); ?></h2>
    <form action="" method="post">
        <?php wp_nonce_field('nonce'); /* nonce用フォームパラメータを表示する */ ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="inputtext"><?php _e('Options UserAgent', 'kumademo-google-analytics'); ?></label></th>
                <td>
                    <input name="options[UserAgent]" value="<?php echo $options['UserAgent']; ?>" />
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e('Options Submit', 'kumademo-google-analytics'); ?>" /></p>
    </form>
</div>
