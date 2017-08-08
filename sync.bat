@echo off

REM -preview 

pushd %~dp0
winscp /command //^
	"open ""sftp://triangelos.org@ssh.triangelos.org"""^
	"lcd %~dp0"^
	"cd /www"^
	"synchronize remote -mirror -transfer=binary -delete -filemask="" | .git*; *.git/; *.cache/; *.sublime-*; test*/; .logs/"""^
	"rm "".cache"""^
	"exit"
echo.
popd
