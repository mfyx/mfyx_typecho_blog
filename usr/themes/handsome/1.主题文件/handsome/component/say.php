<?php
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  //如果是文章作者的评论添加 .comment-by-author 样式
        } else {
            $commentClass .= ' comment-by-user';  //如果是评论作者的添加 .comment-by-user 样式
        }
    }
    $commentLevelClass = $comments->_levels > 0 ? ' comment-child' : ' comment-parent';  //评论层数大于0为子级，否则是父级
    ?>

    <!--自定义评论代码结构-->
    <div id="<?php $comments->theId(); ?>" class="comment-body<?php
    if ($comments->_levels > 0) {
        echo ' comment-child';
        $comments->levelsAlt('comment-level-odd', ' comment-level-even');
    } else {
        echo ' comment-parent';
    }
    $comments->alt(' comment-odd', ' comment-even');
    echo $commentClass;
    ?>">


        <a class="pull-left thumb-sm avatar m-l-n-md">
            <?php echo Utils::avatarHtml($comments); ?>
        </a>

        <div class="m-l-lg m-b-lg">
            <div class="m-b-xs">
                <a href="" class="h4"><?php $comments->author(); ?></a>
                <span class="format_time text-muted m-l-sm pull-right" datetime="<?php $comments->date('c'); ?>"><?php echo Utils::formatDate($comments,$comments->created, $options->dateFormat); ?></span>
            </div>
            <div class="m-b">
                <div class="m-b words_contents">
                    <?php echo Content::timeMachineCommentContent($comments->content); ?>
                </div>
                <div class="m-t-sm" style="display: none">
                    <a data-id="<?php $comments->theId(); ?>" class="text-muted m-xs"><i class="glyphicon glyphicon-heart-empty"></i></a>
                </div>
            </div>
        </div>

        <!-- 单条评论者信息及内容 -->
    </div><!--匹配`自定义评论的代码结构`下面的div标签-->
<?php } ?>

<div id="comments" class="timeMachine">
    <!--如果允许评论，会出现评论框和个人信息的填写-->
    <?php if($this->allow('comment')): ?>
        <!--判断是否登录，只有登陆者才有权利发表说说-->
        <?php if($this->user->hasLogin()): ?>
            <div id="<?php $this->respondId(); ?>" class="respond comment-respond">

                <div class="panel panel-default m-t-md pos-rlt m-b-lg">
                    <form id="comment_form" action="<?php $this->commentUrl() ?>" method="post" class="comment-form" role="form">
                        <textarea id="comment" class="textarea form-control no-border" name="text" rows="3" maxlength="65525" aria-required="true"><?php $this->remember('text'); ?></textarea>

                        <!--提交按钮-->
                        <div class="panel-footer bg-light lter">
                            <button type="submit" name="submit" id="submit" class="submit btn btn-info pull-right btn-sm">
                                <span class="text"><?php _me("发表新鲜事") ?></span>
                                <span class="text-active"><?php _me("提交中") ?>...
            <i class="animate-spin fontello fontello-spinner hide" id="spin"></i>
          </span>
                            </button>
                            <ul class="nav nav-pills nav-sm">
                                <li><a id="image-insert" data-toggle="modal" data-target="#imageInsertModal"><i class="fontello fontello-picture text-muted"></i></a></li>
                                <li><a id="video-insert" data-toggle="modal" data-target="#videoInsertModal"><i class="fontello fontello-youtube-play text-muted"></i></a></li>
                                <li><a id="music-insert" data-toggle="modal" data-target="#musicInsertModal"><i class="fontello fontello-headphones text-muted"></i></a></li>
                            </ul>
                            <!--模态框-->
                            <?php
                            echo Content::returnCrossInsertModelHtml("imageInsertModal","imageInsertOk","插入图片","请在下方的输入框内输入要插入的远程图片地址");
                            echo Content::returnCrossInsertModelHtml("videoInsertModal","videoInsertOk","插入视频","请在下方的输入框内输入要插入的远程视频地址");
                            echo Content::returnCrossInsertModelHtml("musicInsertModal","musicInsertOk","插入音乐","请在下方的输入框内输入要插入的单曲地址或者远程音乐地址");
                            ?>

                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!--如果没有登录则什么操作按钮都不会显示-->
        <?php endif; ?>
    <?php else: ?>
        <h4><?php _me("此处评论已关闭") ?></h4>
    <?php endif; ?>
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
        <div class="streamline b-l b-info m-l-lg m-b padder-v">

            <h4 style="display: none" class="comments-title m-t-lg m-b">&nbsp;<?php $this->commentsNum(_mt('暂无评论'), _mt('1 条评论'), _mt(' %d 条评论')); ?></h4>
            <?php $comments->listComments(); ?>
        </div>
        <nav class="text-center m-b-lg" role="navigation">
            <?php $comments->pageNav('<i class="fontello fontello-chevron-left"></i>', '<i class="fontello fontello-chevron-right"></i>'); ?>
        </nav>

    <?php else: ?>
        <!--一条说说都没有，则显示默认信息-->
        <div class="streamline b-l b-info m-l-lg m-b padder-v">
            <ol class="comment-list list-unstyled m-b-none">
                <div class="comment-body comment-parent comment-odd comment-by-author">

                    <a class="pull-left thumb-sm avatar m-l-n-md">
                        <img nogallery src="<?php $this->options->BlogPic(); ?>">
                    </a>

                    <div class="m-l-lg m-b-lg">
                        <div class="m-b-xs">
                            <a href="" class="h4"></a><a href="<?php $this->options->rootUrl(); ?>"><?php $this->user->screenName(); ?></a>
                            <span class="format_time text-muted m-l-sm pull-right"><?php echo date(_mt("Y 年 m 月 d 日 h 时 i 分 A"),time()+($this->options->timezone - idate("Z"))); ?></span>
                        </div>
                        <div class="m-b">
                            <div class="m-b"><p><?php _me("欢迎你来到「时光机」栏目。在这里你可以记录你的日常和心情。而且，首页的“闲言碎语”栏目会显示最新的三条动态!</br></br>这是默认的第一条说说，当你发布第一条说说，刷新页面后，该条动态会自动消失。") ?></p></div>
                        </div>
                    </div>
                </div>
            </ol>
        </div>

    <?php endif; ?>

</div>
