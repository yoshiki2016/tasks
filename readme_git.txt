1)プッシュ先のリモートリポジトリー登録ログイン
	git remote add origin https://github.com/yoshiki2016/tasks
	ID: yoshiki2016
	PS: UYkXG-3+

2)gitのコマンド
	cd /opt/docker-dir # gitで管理する領域のルートディレクトリーに移動
	git add ./* # 変更を加えたものを、リストアップ
	git commit -m "ホゲホゲ" ＃コミット時にメッセージを入力
	git log # コミットログを確認
	git push origin master # 指定したリモートリポジトリーにプッシュ
	git fetch --all ＃ ローカルリポジトリーのコミットID確認
	git branch -avv ＃ リモートリポジトリーのコミットID確認

3)よくあるエラーに対処する
	エラー：Everything up-to-date
	対策　：ローカルとリモートのリポジトリーそれぞれのコミットIDを確認する。
	　　　　同じであった場合は、コミットのし忘れなので、再度コミットする。

