Title      : DateTimePicker plugin
Category   : Plugin
Author     : Phize
Author URI : http://phize.net
License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
Version    : 1.1.0
Last Update: 2008-12-31



概要
----

DateTimePicker プラグインはデフォルトのデートタイムピッカーを置き換えるプラグインです。

ドキュメントの編集画面で、
いつものようにカレンダーアイコンをクリックすると、新しいデートタイムピッカーが表示されます。

新しいウィンドウやタブを開くことなく、日時を入力することができるようになります。

テンプレート変数名に「-」、「.」、「_」を含む入力タイプが「Date」のテンプレート変数がある場合、
DateTimePicker プラグインは正常に動作しません。



インストール
------------

1.datetimepicker/フォルダを /assets/plugins/ にコピー。

2.「DateTimePicker」という名前のプラグインを新規作成。

3.datetimepicker.plugin.tpl.phpの内容を「プラグインコード」にコピー&ペースト。

4.次のコードを「プラグイン設定」にコピー&ペースト。
   &language=Language;string;auto

5.「OnDocFormPrerender」イベントにチェックを入れて、プラグインを保存。



パラメータ
----------

language   : デートピッカーの言語。
             /assets/plugins/datetimepicker/js/i18n/フォルダで言語コードを確認できます。
             (「ui.datetimepicker-**.js」ファイルの「**」の部分が言語コードです。)

             「auto」に設定すると、
             言語コードは「グローバル設定」の「管理画面の言語コード」と同じになります。
                         (「MODx設定」)      (「マネージャの言語コード」)

             ただし、この機能は0.9.6.2以上でのみ正しく動作します。
             (0.9.6.2未満のMODxにはバグがあるため、
              「auto」に設定しても、言語コードは常に「en」になります。)
