<div class="container-fluid">
    <div class="row chat-row row-flex">
        <div class="col-xs-12 col-sm-3 chat-list">
            <h2 class="playfair-display-title-font">Messagerie</h2>
            <?php
            if (empty($chat->getChat())):?>
                <div><span>Aucune conversation à afficher</span></div>
           <?php else:
                $conversations = $chat->getChat();
                foreach($conversations as $conv) :
                ?>
                    <a href="index.php?action=conversation&conversationId=<?= $conv->getConversationId()?>">
                        <?php if($conversation->getConversationId() === $conv->getConversationId()): ?>
                        <div class="row conversation-overview active-conversation-overview">
                        <?php else: ?>
                        <div class="row conversation-overview">
                        <?php endif; ?>
                            <div class="col-xs-2">
                                <img class="profile-picture medium-profile-picture" src="<?= $conv->getInterlocutor()->getPicture() ?>" alt="<?= $conv->getInterlocutor()->getNickname() ?>">
                            </div>
                            <?php if($conv->getConversation()[0]->isConnectedUserMessage() === false && $conv->getConversation()[0]->getSeenByRecipient() === false): ?>
                            <div class="col-xs-10 unseen-message">
                            <?php else: ?>
                            <div class="col-xs-10">
                            <?php endif; ?>
                                <div class="message-overview-info">
                                    <span><?= $conv->getInterlocutor()->getNickname() ?></span>
                                    <span><?= Utils::convertDateToSmallFormat($conv->getConversation()[0]->getDatetime()) ?></span>
                                </div>
                                <div class="message-overview"><?= $conv->getConversation()[0]->getText()?></div>
                            </div>
                        </div>
                    </a>
            <?php endforeach; endif; ?>
        </div>
        <div class="col-xs-12 col-sm-9 chat-conversation">
            <?php if(!is_null($conversation)): ?>
            <div class="conversation">
                <div class="conversation-header">
                    <img class="profile-picture medium-profile-picture" src="<?= $conversation->getInterlocutor()->getPicture() ?>" alt="<?= $conversation->getInterlocutor()->getNickname() ?> profile picture">
                    &nbsp;<span><?= $conversation->getInterlocutor()->getNickname() ?></span>
                </div>
                <div class="conversation-body">
                <?php if(!empty($conversation->getConversation())):
                    foreach ($conversation->getConversation() as $message) : ?>
                        <?php if($message->isConnectedUserMessage() === true):?>
                        <div class="align-right">
                            <div>
                        <?php else: ?>
                        <div class="align-left">
                            <div class="message-header">
                                <img class="profile-picture mini-profile-picture" src="<?= $message->getSender()->getPicture() ?>" alt="<?= $message->getSender()->getNickname() ?> profile picture">
                        <?php endif;?>
                                <?= Utils::convertDateToMediumFormat($message->getDatetime()) ?>
                            </div>
                        <?php if($message->isConnectedUserMessage() === true):?>
                            <div class="message connected-user-message">
                        <?php else: ?>
                            <div class="message interlocutor-message">
                        <?php endif;?>
                                <?php if($message->isConnectedUserMessage() === false && $message->getSeenByRecipient() === false): ?>
                                <span class="unseen-message"><?= $message->getText() ?></span>
                                <?php else: ?>
                                <span><?= $message->getText() ?></span>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php
                        if($message->isConnectedUserMessage() === false && $message->getSeenByRecipient() === false)
                            $unseenMessageIds[] = $message->getId();
                        ?>
                    <?php endforeach;  endif;?>
                    <form action="index.php?action=send-message" method="post">
                        <input type="hidden" name="conversationId" value="<?= $conversation->getConversationId(); ?>" />
                        <input type="hidden"  name="seenByRecipientMessagesIds" value="<?= json_encode($chat->getUnreadMessagesIds()); ?>" />
                        <div class="chat-message-form">
                            <input class="input-lg message-input" type="text" name="message" placeholder="Tapez votre message ici"/>
                            <input class="btn green-button" type="submit" value="Envoyer" />
                        </div>
                    </form>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
