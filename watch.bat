@echo off

REM -preview 

pushd %~dp0
winscp /command //^
	"open ""sftp://triangelos.org@ssh.triangelos.org"""^
	"lcd %~dp0"^
	"cd /www"^
	"keepuptodate -transfer=binary -delete -filemask="" | .git*; *.git/; *.cache/; *.sublime-*; test*/; .logs/"""^
	"exit"
echo.
popd
