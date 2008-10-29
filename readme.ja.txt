Title      : Datepicker plugin
Category   : Plugin
Author     : Phize
Author URI : http://phize.net
License    : GNU General Public License(http://www.gnu.org/licenses/gpl.html)
Version    : 1.0.0
Last Update: 2008-10-27



概要
----

Datepicker プラグインはデフォルトのデートピッカーを置き換えるプラグインです。

ドキュメントの編集画面で、
いつものようにカレンダーアイコンをクリックすると、新しいデートピッカーが表示されます。

新しいウィンドウやタブを開くことなく、日付を入力することができるようになります。



インストール
------------

1.datepicker/フォルダを /assets/plugins/ にコピー。

2.「Datepicker」という名前のプラグインを新規作成。

3.datepicker.plugin.tpl.phpの内容を「プラグインコード」にコピー&ペースト。

4.次のコードを「プラグイン設定」にコピー&ペースト。
   &language=Language;string;auto &defaultTime=Default Time(hh:mm:ss);string;00:00:00

5.「OnDocFormPrerender」イベントにチェックを入れて、プラグインを保存。



パラメータ
----------

language   : デートピッカーの言語。
             /assets/plugins/datepicker/js/i18n/フォルダで言語コードを確認できます。
             (「ui.datepicker-**.js」ファイルの「**」の部分が言語コードです。)

             「auto」に設定すると、
             言語コードは「グローバル設定」の「管理画面の言語コード」と同じになります。
                         (「MODx設定」)      (「マネージャの言語コード」)

             ただし、この機能は0.9.6.2以上でのみ正しく動作します。
             (0.9.6.2未満のMODxにはバグがあるため、
              「auto」に設定しても、言語コードは常に「en」になります。)

defaultTime: デフォルトの時刻。
             時刻のフォーマットは「hh:mm:ss」です。
