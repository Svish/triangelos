@echo off

REM -preview 

pushd %~dp0
winscp /command //^
	"open ""triangelos"""^
	"lcd %~dp0"^
	"synchronize remote -mirror -transfer=binary -delete -filemask="" | .git*; *.sublime-*; *.bat; test/; test*/; *.git/; *.cache/"""^
	"rm "".cache"""^
	"exit"
echo.
popd
