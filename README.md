# ACT Laboratory webSite


## �����
- PHP5.5�ȏ�
- Perl5�n
- Apache 2.4
- Mysql5�n

## �X�V���@
- Git��Push����Ǝ����Ŕ��f�����悤�ɐݒ肵�Ă���
- �茳�ł悭�e�X�g���Ă���master��push����

## �茳�œ������ɂ�
1. �������N���[��
1. mysql�Ńf�[�^�x�[�X���쐬
1. �쐬����DB��setup.sql�����s
	- �z�z�łƔ���J�ł͈ꕔ�قȂ�ꍇ�����邪�A�e�[�u���\���͓����ł���
	- �擪�s��DB���͓K�X�C�����Ă�����s����
1. �E�F�u�T�[�o��ݒ肷��BApache2.4�̏ꍇ�́A.htaccess�t�@�C�����쐬���A�����̂Ƃ���ݒ�
1. ���̃t�@�C���Ŏ����A�K�v�Ȋ��ϐ���ݒ�
1. �f���������������ꍇ�ɂ́A�ecgi�t�@�C���擪�s��perl�̃p�X��p�[�~�b�V�����Ȃǂ�ݒ�
	- [�ڍׂ͌f�����W���[���z�z��](https://www.kent-web.com/bbs/light.html)��

## .htaccess�t�@�C���ł̎Q�l�ݒ��
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{REQUEST_URI} !(^/public/)
	RewriteCond %{REQUEST_URI} !(^/bbs/)
	RewriteCond %{REQUEST_URI} !(^/git-pull.php)
	RewriteRule ^ index.php [QSA,L]


## �ݒ肪�K�v�Ȋ��ϐ�
- �ݒ���@��OS�ɂ��قȂ邪�A�E�F�u�T�[�o��Apache�ŁA.htaccess���g����Ȃ��L�ݒ�ƍ��킹�Ĉȉ��̂悤�ɏ����B
	SetEnv DB_HOST 'localhost'
	SetEnv DB_USER 'actlab'
	SetEnv DB_NAME 'actlab'
	SetEnv DB_PASS '********'
	SetEnv BBS_PASS '********'
- ���̑��̊��ɂ��Ă͏�L��K�X�ǂݑւ���B

## ���p���C�u����
- slim/twig-view
- twig/extensions
- doctorine/dbal
- bryanjhv/slim-session
- Bootstrap4
- lightboard
